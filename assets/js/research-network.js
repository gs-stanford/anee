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

	function distribute(index, total, start, end) {
		if (total <= 1) return (start + end) / 2;
		return start + ((end - start) * index) / (total - 1);
	}

	function positionOverview(data) {
		var positions = new Map();
		var topics = byType(data, "topic");
		var xPositions = [220, 700, 1180];
		var yPositions = [245, 590];

		topics.forEach(function (topic, index) {
			positions.set(topic.id, {
				x: xPositions[index % 3],
				y: yPositions[Math.floor(index / 3)],
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
			projects: projectIds.map(function (id) { return map.get(id); }).filter(Boolean).sort(function (a, b) { return a.label.localeCompare(b.label); }),
			people: Array.from(personIds).map(function (id) { return map.get(id); }).filter(Boolean).sort(function (a, b) { return a.label.localeCompare(b.label); }),
		};
	}

	function positionFocus(focus) {
		var positions = new Map();
		var peopleColumns = focus.people.length > 10 ? 3 : (focus.people.length > 1 ? 2 : 1);
		var peopleRows = Math.ceil(focus.people.length / peopleColumns);
		var peopleX = peopleColumns === 3 ? [830, 1045, 1240] : (peopleColumns === 2 ? [900, 1180] : [1035]);

		positions.set(focus.topic.id, { x: 165, y: 405 });

		focus.projects.forEach(function (project, index) {
			positions.set(project.id, {
				x: 525,
				y: distribute(index, focus.projects.length, 160, 650),
			});
		});

		focus.people.forEach(function (person, index) {
			var column = index % peopleColumns;
			var row = Math.floor(index / peopleColumns);
			positions.set(person.id, {
				x: peopleX[column],
				y: distribute(row, peopleRows, 130, 680),
			});
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
		var lines = textLines(node.label, max);
		var firstLineY = y - ((lines.length - 1) * 10);
		var text = svg("text", { x: "0", y: String(firstLineY), "text-anchor": "middle", class: className || "boies-network-node__label" });
		lines.forEach(function (line, index) {
			var tspan = svg("tspan", { x: "0", dy: index ? "1.05em" : "0" });
			tspan.textContent = line;
			text.appendChild(tspan);
		});
		group.appendChild(text);
	}

	function addLaneLabel(stage, x, label, className) {
		var text = svg("text", { x: String(x), y: "52", "text-anchor": "middle", class: "boies-network-lane-label " + className });
		text.textContent = label;
		stage.appendChild(text);
	}

	function drawNode(stage, node, point, onSelect) {
		var isInteractive = node.type !== "project";
		var group = svg("g", {
			class: "boies-network-node boies-network-node--" + node.type,
			transform: "translate(" + point.x + " " + point.y + ")",
			tabindex: isInteractive ? "0" : "-1",
			role: isInteractive ? "button" : "group",
			"aria-label": node.label,
		});

		if (node.type === "topic") {
			group.appendChild(svg("circle", { r: "96" }));
			addLabel(group, node, -2, 18);
			var prompt = svg("text", { x: "0", y: "54", "text-anchor": "middle", class: "boies-network-node__meta" });
			prompt.textContent = "Select";
			group.appendChild(prompt);
		} else if (node.type === "project") {
			group.appendChild(svg("rect", { x: "-112", y: "-42", width: "224", height: "84", rx: "26" }));
			addLabel(group, node, 1, 25, "boies-network-node__label boies-network-node__label--small");
		} else {
			group.appendChild(svg("circle", { r: "29" }));
			var initials = svg("text", { x: "0", y: "5", "text-anchor": "middle", class: "boies-network-node__initials" });
			initials.textContent = node.label.split(/\s+/).map(function (part) { return part[0]; }).join("").slice(0, 2);
			group.appendChild(initials);
			var personLabel = svg("text", { x: "41", y: "5", class: "boies-network-node__person-label" });
			personLabel.textContent = node.label;
			group.appendChild(personLabel);
		}

		if (isInteractive) {
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
		var labelsLayer = svg("g", { class: "boies-network-lanes" });
		var nodesLayer = svg("g", { class: "boies-network-nodes" });

		addLaneLabel(labelsLayer, 700, "RESEARCH THEMES", "is-theme");
		byType(data, "topic").forEach(function (node) {
			drawNode(nodesLayer, node, positions.get(node.id), selectTopic);
		});
		svgElement.replaceChildren(labelsLayer, nodesLayer);
	}

	function renderFocus(svgElement, data, topicId, selectNode) {
		var focus = focusData(data, topicId);
		var positions = positionFocus(focus);
		var visibleIds = new Set([focus.topic].concat(focus.projects, focus.people).map(function (node) { return node.id; }));
		var edgesLayer = svg("g", { class: "boies-network-edges" });
		var labelsLayer = svg("g", { class: "boies-network-lanes" });
		var nodesLayer = svg("g", { class: "boies-network-nodes" });

		addLaneLabel(labelsLayer, 165, "RESEARCH THEME", "is-theme");
		addLaneLabel(labelsLayer, 525, "PROJECTS", "is-project");
		addLaneLabel(labelsLayer, 1040, "PEOPLE", "is-person");

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
		svgElement.replaceChildren(edgesLayer, labelsLayer, nodesLayer);
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
			item.addEventListener("click", function () { selectTopic(topic, true); });
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
				var map = nodeMap(data);

				function overviewUrl() {
					return window.location.pathname + window.location.search;
				}

				function showOverview(updateHistory) {
					root.classList.remove("is-focused");
					detail.innerHTML = "<p class='boies-network-detail__prompt'>Select a research theme to reveal its active projects and people.</p>";
					status.textContent = "Showing six research themes.";
					renderOverview(svgElement, data, selectNode);
					if (updateHistory) window.history.pushState({ topic: null }, "", overviewUrl());
				}

				function showTopic(topic, updateHistory) {
					root.classList.add("is-focused");
					var focus = renderFocus(svgElement, data, topic.id, selectNode);
					detail.innerHTML = detailMarkup(focus);
					status.textContent = "Showing " + focus.topic.label + ", " + focus.projects.length + " projects, and " + focus.people.length + " people.";
					if (updateHistory) window.history.pushState({ topic: topic.id }, "", "#" + topic.id);
				}

				function selectNode(node, updateHistory) {
					if (node.type === "person") {
						window.location.href = node.url;
						return;
					}
					if (node.type === "topic") showTopic(node, updateHistory !== false);
				}

				function renderLocation() {
					var id = window.location.hash.replace(/^#/, "");
					var node = map.get(id);
					if (node && node.type === "topic") showTopic(node, false);
					else showOverview(false);
				}

				reset.addEventListener("click", function () { showOverview(true); });
				window.addEventListener("popstate", renderLocation);
				document.addEventListener("keydown", function (event) {
					if (event.key === "Escape" && root.classList.contains("is-focused")) showOverview(true);
				});
				buildMobile(root, data, selectNode);
				renderLocation();
			})
			.catch(function (error) {
				root.classList.add("has-error");
				detail.textContent = error.message;
			});
	}

	document.addEventListener("DOMContentLoaded", boot);
})();
