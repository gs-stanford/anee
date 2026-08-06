(function () {
	"use strict";

	function element(tag, className, text) {
		var node = document.createElement(tag);
		if (className) node.className = className;
		if (text !== undefined) node.textContent = text;
		return node;
	}

	function byType(data, type) {
		return data.nodes.filter(function (node) { return node.type === type; });
	}

	function nodeMap(data) {
		return new Map(data.nodes.map(function (node) { return [node.id, node]; }));
	}

	function connectedIds(data, id, relation) {
		return data.edges
			.filter(function (edge) {
				return edge.relation === relation && (edge.source === id || edge.target === id);
			})
			.map(function (edge) { return edge.source === id ? edge.target : edge.source; });
	}

	function uniqueNodes(ids, map) {
		return Array.from(new Set(ids))
			.map(function (id) { return map.get(id); })
			.filter(Boolean)
			.sort(function (a, b) { return a.label.localeCompare(b.label); });
	}

	function initials(label) {
		return label.split(/\s+/).map(function (part) { return part.charAt(0); }).join("").slice(0, 2);
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

	function profileSlugsFromHtml(html) {
		var page = new DOMParser().parseFromString(html, "text/html");
		var profiles = new Set();
		var emailProfiles = {
			aboies: "adam-boies",
			chall: "cheyenne-halverson",
			cyprien: "cyprien-jourdain",
			dakanmu: "david-akanmu",
			hzhang29: "hao-zhang",
			jpong: "julie-pongetti",
			karimehp: "karime-hernandez",
			larsonm: "michael-larson",
			mswint: "maddie-swint",
			nategies: "nate-giessner",
			oallah: "omar-allahham",
			sharmag: "gaurav-sharma",
			sonnert: "sophia-sonnert"
		};

		page.querySelectorAll(".anee-profile-card").forEach(function (card) {
			var heading = card.querySelector("h2, h3, h4, h5");
			var profileSlug = card.dataset.person || card.id.replace(/^person-/, "") || (heading ? slug(heading.textContent.trim()) : "");
			if (profileSlug) profiles.add(profileSlug);

			var emailMatch = card.textContent.match(/\b([a-z0-9._%+-]+)@(stanford\.edu|cam\.ac\.uk)\b/i);
			if (emailMatch && emailProfiles[emailMatch[1].toLowerCase()]) {
				profiles.add(emailProfiles[emailMatch[1].toLowerCase()]);
			}
		});

		return profiles;
	}

	function loadProfileSlugs() {
		if (!window.BoiesResearch.peopleUrl) return Promise.resolve(new Set());

		return fetch(window.BoiesResearch.peopleUrl, { credentials: "same-origin" })
			.then(function (response) {
				if (!response.ok) throw new Error("People page could not be checked.");
				return response.text();
			})
			.then(profileSlugsFromHtml)
			.catch(function () { return new Set(); });
	}

	function personMarkup(person, profileSlugs) {
		var profileSlug = slug(person.label);
		var hasProfile = profileSlugs.has(profileSlug);
		var node = element(hasProfile ? "a" : "span", "boies-network-person" + (hasProfile ? "" : " is-static"));

		if (hasProfile) {
			node.href = person.url || window.BoiesResearch.peopleUrl + "?person=" + encodeURIComponent(profileSlug) + "#person-" + profileSlug;
			node.setAttribute("aria-label", "Open " + person.label + " profile");
		} else {
			node.title = "Profile not currently published";
		}

		node.appendChild(element("span", "boies-network-person__initials", initials(person.label)));
		node.appendChild(element("span", "boies-network-person__name", person.label));
		return node;
	}

	function topicBranches(data, topic) {
		var map = nodeMap(data);
		var projects = uniqueNodes(connectedIds(data, topic.id, "project"), map);
		var projectPeople = new Set();
		var branches = projects.map(function (project) {
			var people = uniqueNodes(connectedIds(data, project.id, "researcher"), map);
			people.forEach(function (person) { projectPeople.add(person.id); });
			return { project: project, people: people };
		});
		var collaborators = uniqueNodes(connectedIds(data, topic.id, "researcher"), map)
			.filter(function (person) { return !projectPeople.has(person.id); });

		return { branches: branches, collaborators: collaborators };
	}

	function branchMarkup(branch, index, profileSlugs) {
		var section = element("section", "boies-network-branch");
		section.style.setProperty("--branch-index", String(index));

		var project = element("details", "boies-network-project");
		var summary = element("summary", "boies-network-project__summary");
		var summaryText = element("span", "boies-network-project__summary-text");
		summaryText.appendChild(element("span", "boies-network-project__kind", "Project"));
		summaryText.appendChild(element("span", "boies-network-project__title", branch.project.label));
		summary.appendChild(summaryText);
		summary.appendChild(element("span", "boies-network-project__toggle", "+"));
		project.appendChild(summary);
		if (branch.project.description) {
			var body = element("div", "boies-network-project__body");
			body.appendChild(element("p", "", branch.project.description));
			project.appendChild(body);
		}
		section.appendChild(project);

		var people = element("div", "boies-network-branch__people");
		if (branch.people.length) {
			branch.people.forEach(function (person) { people.appendChild(personMarkup(person, profileSlugs)); });
		} else {
			people.appendChild(element("p", "boies-network-branch__empty", "Project team details coming soon."));
		}
		section.appendChild(people);
		return section;
	}

	function expandedPanel(data, topic, profileSlugs) {
		var connections = topicBranches(data, topic);
		var panel = element("div", "boies-network-tree");
		panel.id = "network-panel-" + topic.id;

		var intro = element("div", "boies-network-tree__intro");
		intro.appendChild(element("span", "boies-network-tree__eyebrow", "Selected research theme"));
		intro.appendChild(element("p", "", topic.description));
		panel.appendChild(intro);

		var branches = element("div", "boies-network-tree__branches");
		if (connections.branches.length) {
			connections.branches.forEach(function (branch, index) {
				branches.appendChild(branchMarkup(branch, index, profileSlugs));
			});
		} else {
			branches.appendChild(element("p", "boies-network-branch__empty", "Project details coming soon."));
		}
		panel.appendChild(branches);

		if (connections.collaborators.length) {
			var collaborators = element("section", "boies-network-collaborators");
			collaborators.appendChild(element("h3", "", "Additional researchers across this theme"));
			var people = element("div", "boies-network-collaborators__people");
			connections.collaborators.forEach(function (person) { people.appendChild(personMarkup(person, profileSlugs)); });
			collaborators.appendChild(people);
			panel.appendChild(collaborators);
		}

		return panel;
	}

	function themeCard(data, topic, selectedId, profileSlugs, onSelect) {
		var isOpen = topic.id === selectedId;
		var article = element("article", "boies-network-theme" + (isOpen ? " is-open" : ""));
		article.dataset.topicId = topic.id;

		var button = element("button", "boies-network-theme__button");
		button.type = "button";
		button.setAttribute("aria-expanded", isOpen ? "true" : "false");
		button.setAttribute("aria-controls", "network-panel-" + topic.id);
		button.appendChild(element("span", "boies-network-theme__title", topic.label));
		button.appendChild(element("span", "boies-network-theme__action", isOpen ? "Close branches" : "Explore"));
		button.addEventListener("click", function () { onSelect(isOpen ? null : topic.id); });
		article.appendChild(button);

		if (isOpen) article.appendChild(expandedPanel(data, topic, profileSlugs));
		return article;
	}

	function boot() {
		var root = document.querySelector("[data-research-network]");
		if (!root || !window.BoiesResearch) return;

		var explorer = root.querySelector("[data-network-explorer]");
		var status = root.querySelector("[data-network-status]");

		Promise.all([
			fetch(window.BoiesResearch.dataUrl).then(function (response) {
				if (!response.ok) throw new Error("Research data could not be loaded.");
				return response.json();
			}),
			loadProfileSlugs()
		])
			.then(function (results) {
				var data = results[0];
				var profileSlugs = results[1];
				var map = nodeMap(data);
				var topics = byType(data, "topic");

				function render(selectedId, updateHistory) {
					var selected = selectedId ? map.get(selectedId) : null;
					if (!selected || selected.type !== "topic") selectedId = null;
					root.classList.toggle("is-focused", Boolean(selectedId));
					explorer.replaceChildren();
					topics.forEach(function (topic) {
						explorer.appendChild(themeCard(data, topic, selectedId, profileSlugs, selectTopic));
					});

					if (selectedId) {
						var connections = topicBranches(data, map.get(selectedId));
						var peopleIds = new Set(connections.collaborators.map(function (person) { return person.id; }));
						connections.branches.forEach(function (branch) {
							branch.people.forEach(function (person) { peopleIds.add(person.id); });
						});
						var peopleCount = peopleIds.size;
						status.textContent = "Expanded " + map.get(selectedId).label + " with " + connections.branches.length + " projects and " + peopleCount + " researcher links.";
					} else {
						status.textContent = "Showing " + topics.length + " research themes.";
					}

					if (updateHistory) {
						var url = selectedId ? "#" + selectedId : window.location.pathname + window.location.search;
						window.history.pushState({ topic: selectedId }, "", url);
					}
				}

				function selectTopic(topicId) {
					render(topicId, true);
					if (topicId) {
						window.requestAnimationFrame(function () {
							var selected = explorer.querySelector('[data-topic-id="' + topicId + '"]');
							if (selected) selected.scrollIntoView({ behavior: "smooth", block: "start" });
						});
					}
				}

				function renderLocation() {
					var id = window.location.hash.replace(/^#/, "");
					render(id, false);
				}

				window.addEventListener("popstate", renderLocation);
				document.addEventListener("keydown", function (event) {
					if (event.key === "Escape" && root.classList.contains("is-focused")) selectTopic(null);
				});
				renderLocation();
			})
			.catch(function (error) {
				root.classList.add("has-error");
				explorer.textContent = error.message;
			});
	}

	document.addEventListener("DOMContentLoaded", boot);
})();
