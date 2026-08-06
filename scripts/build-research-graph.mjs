import { readdir, readFile, writeFile, mkdir } from "node:fs/promises";
import path from "node:path";
import process from "node:process";

const vault = process.argv[2] || process.env.BOIES_VAULT;

if (!vault) {
	throw new Error("Pass the ANEE Obsidian vault path as the first argument or BOIES_VAULT.");
}

const output = path.resolve("assets/data/research-network.json");

const topicCopy = {
	"1D Materials": {
		title: "One-dimensional materials",
		description: "We synthesize and characterize carbon nanotubes and other one-dimensional materials, then translate their exceptional transport and mechanical properties into macroscopic conductors, fibers, and devices.",
	},
	"Autonomous Experimentation": {
		title: "Autonomous experimentation",
		description: "Automation, online diagnostics, and data-driven decision making help the lab navigate large synthesis spaces and accelerate the discovery of useful materials and operating conditions.",
	},
	"Climate-Pollution": {
		title: "Climate and pollution",
		description: "We measure how particles form, evolve, and affect air quality and climate, spanning aviation, transportation, wildfire, and low-cost sensing applications.",
	},
	"Energy materials": {
		title: "Energy materials",
		description: "The group develops materials and diagnostics for batteries, electrochemical systems, energy storage, and cleaner energy conversion.",
	},
	Methane: {
		title: "Methane conversion",
		description: "We study catalytic and high-temperature pathways that convert methane into valuable solid carbon and hydrogen while improving selectivity, efficiency, and scalability.",
	},
	"Solid Carbon": {
		title: "Sustainable nanocarbon",
		description: "Gas-phase synthesis, reactor design, and multiscale characterization are used to produce useful carbon materials with lower emissions and stronger circular-economy potential.",
	},
};

const projectCopy = {
	"ARPA-E CNT": "Scalable carbon-nanotube synthesis and processing for high-performance conductors.",
	"Astera Mars": "Aerosol and atmospheric tools for understanding extreme and remote environments.",
	"Battery Synthesis Equipment": "Automated equipment and diagnostics for repeatable energy-material synthesis.",
	"FAA-Boeing": "Measurement and modeling of aviation emissions, particle evolution, and climate-relevant impacts.",
	"Kavli 1D Material": "Fundamental synthesis and characterization of one-dimensional materials.",
	"Precourt Conductors": "Lightweight nanocarbon conductors for electrified energy systems.",
	"SLAC-Battery": "Advanced battery materials and coupled electrochemical characterization.",
	STEER: "Reactor and process development for methane conversion and solid-carbon production.",
	Spark: "Autonomous experimentation for catalyst and reaction-space discovery.",
	"Sustainability Accelerator": "Translation of laboratory materials research into scalable climate and energy solutions.",
};

const projectTopics = {
	"ARPA-E CNT": ["1D Materials", "Solid Carbon"],
	"Astera Mars": ["Climate-Pollution"],
	"Battery Synthesis Equipment": ["Energy materials", "Autonomous Experimentation"],
	"FAA-Boeing": ["Climate-Pollution"],
	"Kavli 1D Material": ["1D Materials"],
	"Precourt Conductors": ["1D Materials", "Energy materials"],
	"SLAC-Battery": ["Energy materials"],
	STEER: ["Methane", "Solid Carbon"],
	Spark: ["Autonomous Experimentation", "Methane"],
	"Sustainability Accelerator": ["Energy materials", "Solid Carbon"],
};

const publicPersonNames = {
	"Eli Fletes": "Elizabeth Fletes",
};

function publicPersonName(name) {
	return publicPersonNames[name] || name;
}

function slug(value) {
	return value
		.normalize("NFKD")
		.replace(/[\u0300-\u036f]/g, "")
		.toLowerCase()
		.replace(/&/g, " and ")
		.replace(/[^a-z0-9]+/g, "-")
		.replace(/^-|-$/g, "");
}

function links(markdown) {
	return [...markdown.matchAll(/\[\[([^\]|#]+)(?:#[^\]|]+)?(?:\|[^\]]+)?\]\]/g)]
		.map((match) => match[1].trim())
		.filter(Boolean);
}

function sectionLinks(markdown, heading) {
	const pattern = new RegExp(`^#{1,6}\\s+${heading}\\s*$`, "im");
	const match = pattern.exec(markdown);
	if (!match) return [];
	const rest = markdown.slice(match.index + match[0].length);
	const next = rest.search(/^#{1,6}\s+/m);
	return links(next === -1 ? rest : rest.slice(0, next));
}

async function markdownFiles(directory) {
	const entries = await readdir(directory, { withFileTypes: true });
	return entries
		.filter((entry) => entry.isFile() && entry.name.endsWith(".md"))
		.map((entry) => path.join(directory, entry.name))
		.sort();
}

async function readNamedFiles(directory) {
	const files = await markdownFiles(directory);
	return Promise.all(
		files.map(async (file) => ({
			name: path.basename(file, ".md"),
			markdown: await readFile(file, "utf8"),
		}))
	);
}

const memberRoot = path.join(vault, "01_Members");
const memberGroups = await readdir(memberRoot, { withFileTypes: true });
const members = [];

for (const group of memberGroups.filter((entry) => entry.isDirectory()).sort((a, b) => a.name.localeCompare(b.name))) {
	for (const member of await readNamedFiles(path.join(memberRoot, group.name))) {
		members.push({
			name: publicPersonName(member.name),
			projects: sectionLinks(member.markdown, "Projects Involved"),
			applications: sectionLinks(member.markdown, "Applications"),
		});
	}
}

const applications = await readNamedFiles(path.join(vault, "03_Applications"));
const projects = await readNamedFiles(path.join(vault, "02_Projects"));
const personByName = new Map(members.map((member) => [member.name, member]));

for (const application of applications) {
	for (const name of links(application.markdown)) {
		const publicName = publicPersonName(name);
		if (!personByName.has(publicName)) {
			personByName.set(publicName, { name: publicName, projects: [], applications: [] });
		}
	}
}

for (const project of projects) {
	for (const name of links(project.markdown)) {
		const publicName = publicPersonName(name);
		if (!personByName.has(publicName)) {
			personByName.set(publicName, { name: publicName, projects: [], applications: [] });
		}
	}
}

const nodes = [];
const edges = [];
const edgeKeys = new Set();

function addEdge(source, target, relation) {
	const key = `${source}|${target}|${relation}`;
	if (edgeKeys.has(key)) return;
	edgeKeys.add(key);
	edges.push({ source, target, relation });
}

for (const application of applications) {
	const copy = topicCopy[application.name] || { title: application.name, description: "An active Boies Group research theme." };
	const id = `topic-${slug(application.name)}`;
	nodes.push({ id, label: copy.title, sourceLabel: application.name, type: "topic", description: copy.description });

	for (const name of links(application.markdown)) {
		addEdge(id, `person-${slug(publicPersonName(name))}`, "researcher");
	}
}

for (const project of projects.filter((item) => Object.hasOwn(projectCopy, item.name))) {
	const id = `project-${slug(project.name)}`;
	nodes.push({ id, label: project.name, type: "project", description: projectCopy[project.name] });

	for (const topic of projectTopics[project.name] || []) {
		addEdge(`topic-${slug(topic)}`, id, "project");
	}

	for (const name of links(project.markdown)) {
		addEdge(id, `person-${slug(publicPersonName(name))}`, "researcher");
	}
}

for (const person of [...personByName.values()].sort((a, b) => a.name.localeCompare(b.name))) {
	const id = `person-${slug(person.name)}`;
	nodes.push({
		id,
		label: person.name,
		type: "person",
		url: `/people/?person=${slug(person.name)}#${id}`,
	});

	for (const application of person.applications) {
		if (topicCopy[application]) addEdge(`topic-${slug(application)}`, id, "researcher");
	}

	for (const project of person.projects) {
		if (projectCopy[project]) addEdge(`project-${slug(project)}`, id, "researcher");
	}
}

const payload = {
	schemaVersion: 1,
	source: "ANEE Lab Management Vault",
	nodes,
	edges,
};

await mkdir(path.dirname(output), { recursive: true });
await writeFile(output, `${JSON.stringify(payload, null, 2)}\n`, "utf8");
console.log(`Wrote ${nodes.length} nodes and ${edges.length} edges to ${output}`);
