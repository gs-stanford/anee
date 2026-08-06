(function () {
	"use strict";

	var SVG_NS = "http://www.w3.org/2000/svg";

	function svg(tag, attributes) {
		var element = document.createElementNS(SVG_NS, tag);
		Object.keys(attributes || {}).forEach(function (key) {
			element.setAttribute(key, attributes[key]);
		});
		return element;
	}

	function escapeHtml(value) {
		var div = document.createElement("div");
		div.textContent = value || "";
		return div.innerHTML;
	}

	function byType(data, type) {
		return data.nodes.filter(function (node) { return node.type === type; });
	}

	function connectedIds(data, id, relation) {
		return data.edges
			.filter(function (edge) {
				return (!relation || edge.relation === relation) && (edge.source === id || edge.target === id);
			})
			.map(function (edge) { return edge.source === id ? edge.target : edge.source; });
	}

	function nodeMap(data) {
		return new Map(data.nodes.map(function (node) { return [node.id, node]; }));
	}

	function polar(index, total, radius, centerX, centerY, offset) {
		var angle = (Math.PI * 2 * index) / Math.max(total, 1) + (offset || 0);
		return { x: centerX + Math.cos(angle) * radius, y: centerY + Math.sin(angle) * radius };
	}

	function positionOverview(data) {
		var positions = new Map();
		var topics = byType(data, "topic");
		var projects = byType(data, "project");

		topics.forEach(function (topic, index) {
			positions.set(topic.id, polar(index, topics.length, 315, 700, 430, -Math.PI / 2));
		});

		projects.forEach(function (project, index) {
			var topicIds = connectedIds(data, project.id, "project");
			var anchors = topicIds.map(function (id) { return positions.get(id); }).filter(Boolean);
			var x = anchors.reduce(function (sum, point) { return sum + point.x; }, 0) / Math.max(anchors.length, 1);
			var y = anchors.reduce(function (sum, point) { return sum + point.y; }, 0) / Math.max(anchors.length, 1);
			var nudge = polar(index, projects.length, 100, 700, 430, Math.PI / 4);
			positions.set(project.id, {
				x: anchors.length ? x * 0.58 + 700 * 0.42 : nudge.x,
				y: anchors.length ? y * 0.58 + 430 * 0.42 : nudge.y,
			});
		});

		return positions;
	}

	function focusData(data, topicId) {
		var map = nodeMap(data);
		var projectIds = connectedIds(data, topicId, "project");
		var personIds = new Set(connectedIds(data, topicId, "researcher"));

		projectIds.forEach(function (projectId) {
			connectedIds(data, projectId, "researcher").forEach(function (personId) { personIds.add(personId); });
		});

		return {
			topic: map.get(topicId),
			projects: projectIds.map(function (id) { return map.get(id); }).filter(Boolean),
			people: Array.from(personIds).map(function (id) { return map.get(id); }).filter(Boolean).sort(function (a, b) { return a.label.localeCompare(b.label); }),
		};
	}

	function positionFocus(focus) {
		var positions = new Map();
		positions.set(focus.topic.id, { x: 260, y: 425 });

		focus.projects.forEach(function (project, index) {
			var spacing = 650 / Math.max(focus.projects.length, 1);
			positions.set(project.id, { x: 610, y: 105 + spacing * index + spacing / 2 });
		});

		focus.people.forEach(function (person, index) {
			var column = index % 2;
			var row = Math.floor(index / 2);
			var rows = Math.ceil(focus.people.length / 2);
			var spacing = Math.min(88, 650 / Math.max(rows, 1));
			positions.set(person.id, { x: 960 + column * 250, y: 105 + row * spacing + spacing / 2 });
		});

		return positions;
	}

	function edgePath(start, end) {
		var controlX = (start.x + end.x) / 2;
		return "M " + start.x + " " + start.y + " C " + controlX + " " + start.y + ", " + controlX + " " + end.y + ", " + end.x + " " + end.y;
	}

	function textLines(label, max) {
		var words = label.split(/\s+/);
		var lines = [""];
		words.forEach(function (word) {
			var current = lines[lines.length - 1];
			if ((current + " " + word).trim().length > max && current) lines.push(word);
			else lines[lines.length - 1] = (current + " " + word).trim();
		});
		return lines.slice(0, 3);
	}

	function addLabel(group, node, y, max, className) {
		var text = svg("text", { x: "0", y: String(y), "text-anchor": "middle", class: className || "boies-network-node__label" });
		textLines(node.label, max).forEach(function (line, index) {
			var tspan = svg("tspan", { x: "0", dy: index ? "1.05em" : "0" });
			tspan.textContent = line;
			text.appendChild(tspan);
		});
		group.appendChild(text);
	}

	function drawNode(stage, node, point, onSelect) {
		var group = svg("g", {
			class: "boies-network-node boies-network-node--" + node.type,
			transform: "translate(" + point.x + " " + point.y + ")",
			tabindex: "0",
			role: node.type === "project" ? "group" : "button",
			"aria-label": node.label,
		});

		if (node.type === "topic") {
			group.appendChild(svg("circle", { r: "82" }));
			addLabel(group, node, -7, 17);
			var prompt = svg("text", { x: "0", y: "40", "text-anchor": "middle", class: "boies-network-node__meta" });
			prompt.textContent = "Explore";
			group.appendChild(prompt);
		} else if (node.type === "project") {
			group.appendChild(svg("rect", { x: "-90", y: "-38", width: "180", height: "76", rx: "38" }));
			addLabel(group, node, -5, 23, "boies-network-node__label boies-network-node__label--small");
		} else {
			group.appendChild(svg("circle", { r: "27" }));
			var initials = svg("text", { x: "0", y: "5", "text-anchor": "middle", class: "boies-network-node__initials" });
			initials.textContent = node.label.split(/\s+/).map(function (part) { return part[0]; }).join("").slice(0, 2);
			group.appendChild(initials);
			var personLabel = svg("text", { x: "39", y: "5", class: "boies-network-node__person-label" });
			personLabel.textContent = node.label;
			group.appendChild(personLabel);
		}

		if (node.type !== "project") {
			group.addEventListener("click", function () { onSelect(node); });
			group.addEventListener("keydown", function (event) {
				if (event.key === "Enter" || event.key === " ") {
					event.preventDefault();
					onSelect(node);
				}
			});
		}

		stage.appendChild(group);
	}

	function renderOverview(svgElement, data, selectTopic) {
		var positions = positionOverview(data);
		var visibleIds = new Set(byType(data, "topic").concat(byType(data, "project")).map(function (node) { return node.id; }));
		var edgesLayer = svg("g", { class: "boies-network-edges" });
		var nodesLayer = svg("g", { class: "boies-network-nodes" });

		data.edges.filter(function (edge) {
			return edge.relation === "project" && visibleIds.has(edge.source) && visibleIds.has(edge.target);
		}).forEach(function (edge) {
			edgesLayer.appendChild(svg("path", { d: edgePath(positions.get(edge.source), positions.get(edge.target)), class: "boies-network-edge" }));
		});

		byType(data, "project").forEach(function (node) { drawNode(nodesLayer, node, positions.get(node.id), function () {}); });
		byType(data, "topic").forEach(function (node) { drawNode(nodesLayer, node, positions.get(node.id), selectTopic); });
		svgElement.replaceChildren(edgesLayer, nodesLayer);
	}

	function renderFocus(svgElement, data, topicId, selectNode) {
		var focus = focusData(data, topicId);
		var positions = positionFocus(focus);
		var visibleIds = new Set([focus.topic].concat(focus.projects, focus.people).map(function (node) { return node.id; }));
		var edgesLayer = svg("g", { class: "boies-network-edges" });
		var nodesLayer = svg("g", { class: "boies-network-nodes" });

		data.edges.filter(function (edge) {
			return visibleIds.has(edge.source) && visibleIds.has(edge.target);
		}).forEach(function (edge) {
			var start = positions.get(edge.source);
			var end = positions.get(edge.target);
			if (start && end) edgesLayer.appendChild(svg("path", { d: edgePath(start, end), class: "boies-network-edge boies-network-edge--" + edge.relation }));
		});

		[focus.topic].concat(focus.projects, focus.people).forEach(function (node) {
			drawNode(nodesLayer, node, positions.get(node.id), selectNode);
		});
		svgElement.replaceChildren(edgesLayer, nodesLayer);
		return focus;
	}

	function detailMarkup(focus) {
		var projectItems = focus.projects.map(function (project) {
			return "<li><strong>" + escapeHtml(project.label) + "</strong><span>" + escapeHtml(project.description) + "</span></li>";
		}).join("");
		var people = focus.people.map(function (person) {
			return "<a href='" + escapeHtml(person.url) + "'>" + escapeHtml(person.label) + "</a>";
		}).join("");

		return "<p class='boies-section-label'>Research theme</p>" +
			"<h2>" + escapeHtml(focus.topic.label) + "</h2>" +
			"<p>" + escapeHtml(focus.topic.description) + "</p>" +
			(projectItems ? "<h3>Connected projects</h3><ul>" + projectItems + "</ul>" : "") +
			(people ? "<h3>People</h3><div class='boies-network-detail__people'>" + people + "</div>" : "");
	}

	function buildMobile(root, data, selectTopic) {
		var mobile = root.querySelector(".boies-network-mobile");
		byType(data, "topic").forEach(function (topic) {
			var item = document.createElement("button");
			item.type = "button";
			item.innerHTML = "<span>" + escapeHtml(topic.label) + "</span><small>Explore theme</small>";
			item.addEventListener("click", function () { selectTopic(topic); });
			mobile.appendChild(item);
		});
	}

	function boot() {
		var root = document.querySelector("[data-research-network]");
		if (!root || !window.BoiesResearch) return;

		var svgElement = root.querySelector("svg");
		var detail = root.querySelector(".boies-network-detail");
		var reset = root.querySelector("[data-network-reset]");
		var status = root.querySelector("[data-network-status]");

		fetch(window.BoiesResearch.dataUrl)
			.then(function (response) {
				if (!response.ok) throw new Error("Research data could not be loaded.");
				return response.json();
			})
			.then(function (data) {
				function showOverview() {
					root.classList.remove("is-focused");
					detail.innerHTML = "<p class='boies-network-detail__prompt'>Select a research theme to reveal its active projects and people.</p>";
					status.textContent = "Showing the full research network.";
					renderOverview(svgElement, data, selectNode);
				}

				function selectNode(node) {
					if (node.type === "person") {
						window.location.href = node.url;
						return;
					}
					if (node.type !== "topic") return;
					root.classList.add("is-focused");
					var focus = renderFocus(svgElement, data, node.id, selectNode);
					detail.innerHTML = detailMarkup(focus);
					status.textContent = "Showing " + focus.topic.label + ", " + focus.projects.length + " projects, and " + focus.people.length + " people.";
					detail.scrollIntoView({ behavior: "smooth", block: "nearest" });
				}

				reset.addEventListener("click", showOverview);
				buildMobile(root, data, selectNode);
				showOverview();
			})
			.catch(function (error) {
				root.classList.add("has-error");
				detail.textContent = error.message;
			});
	}

	document.addEventListener("DOMContentLoaded", boot);
})();
