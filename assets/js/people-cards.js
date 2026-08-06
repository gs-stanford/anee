(function () {
	"use strict";

	function slug(value) {
		return value
			.normalize("NFKD")
			.replace(/[\u0300-\u036f]/g, "")
			.toLowerCase()
			.replace(/&/g, " and ")
			.replace(/[^a-z0-9]+/g, "-")
			.replace(/^-|-$/g, "");
	}

	function isInteractive(element) {
		return Boolean(element.closest("a, button, input, textarea, select, summary, [contenteditable='true']"));
	}

	function cardName(card) {
		var heading = card.querySelector("h2, h3, h4, h5");
		return heading ? heading.textContent.trim() : "Group member";
	}

	function prepareCard(card) {
		var name = cardName(card);
		var id = "person-" + slug(name);
		var bio = card.querySelector(".anee-profile-bio, details");

		card.id = id;
		card.dataset.person = slug(name);

		if (!bio) return;

		card.classList.add("has-clickable-bio");
		card.tabIndex = 0;
		card.setAttribute("aria-expanded", bio.open ? "true" : "false");

		bio.addEventListener("toggle", function () {
			card.classList.toggle("is-expanded", bio.open);
			card.setAttribute("aria-expanded", bio.open ? "true" : "false");
		});

		card.addEventListener("click", function (event) {
			if (isInteractive(event.target)) return;
			bio.open = !bio.open;
		});

		card.addEventListener("keydown", function (event) {
			if (event.target !== card || (event.key !== "Enter" && event.key !== " ")) return;
			event.preventDefault();
			bio.open = !bio.open;
		});
	}

	function grid() {
		var element = document.createElement("div");
		element.className = "anee-normalized-card-grid";
		return element;
	}

	function heading(text, className) {
		var element = document.createElement("h2");
		element.className = className || "anee-live-heading";
		element.textContent = text;
		return element;
	}

	function introFrom(root) {
		var paragraphs = Array.prototype.slice.call(root.querySelectorAll("p"));
		return paragraphs.find(function (paragraph) {
			return !paragraph.closest(".anee-profile-card, .anee-people-panel") && paragraph.textContent.trim().length > 45;
		});
	}

	function normalizePeoplePage() {
		var content = document.querySelector(".boies-page-content");
		if (!content || content.dataset.peopleNormalized === "true") return;

		var allCards = Array.prototype.slice.call(content.querySelectorAll(".anee-profile-card"));
		if (!allCards.length) return;

		var pi = allCards.find(function (card) { return card.classList.contains("anee-pi-card"); });
		var panels = Array.prototype.slice.call(content.querySelectorAll("details.anee-people-panel"));
		var panelCards = new Set();

		panels.forEach(function (panel) {
			panel.querySelectorAll(".anee-profile-card").forEach(function (card) { panelCards.add(card); });
		});

		var stanfordCards = allCards.filter(function (card) {
			return card !== pi && !panelCards.has(card);
		});
		var live = document.createElement("div");
		live.className = "anee-live-directory";

		var intro = introFrom(content);
		if (intro) {
			var introCopy = document.createElement("p");
			introCopy.className = "anee-live-intro";
			introCopy.textContent = intro.textContent.trim();
			live.appendChild(introCopy);
		}

		if (pi) {
			var piSection = document.createElement("section");
			piSection.className = "anee-live-pi";
			piSection.setAttribute("aria-label", "Principal investigator");
			piSection.appendChild(pi);
			live.appendChild(piSection);
		}

		if (stanfordCards.length) {
			var stanfordSection = document.createElement("section");
			stanfordSection.className = "anee-live-section";
			stanfordSection.appendChild(heading("Stanford members", "anee-people-subheading"));
			var stanfordGrid = grid();
			stanfordCards.forEach(function (card) { stanfordGrid.appendChild(card); });
			stanfordSection.appendChild(stanfordGrid);
			live.appendChild(stanfordSection);
		}

		panels.forEach(function (panel) {
			var cards = Array.prototype.slice.call(panel.querySelectorAll(".anee-profile-card"));
			if (cards.length) {
				var panelGrid = grid();
				cards.forEach(function (card) { panelGrid.appendChild(card); });
				panel.appendChild(panelGrid);
			}
			live.appendChild(panel);
		});

		allCards.forEach(prepareCard);
		content.prepend(live);
		content.dataset.peopleNormalized = "true";
		content.classList.add("anee-people-is-normalized");

		var requested = new URLSearchParams(window.location.search).get("person");
		var hash = window.location.hash.replace(/^#(?:person-)?/, "");
		var targetSlug = slug(requested || hash || "");
		if (!targetSlug) return;

		window.setTimeout(function () {
			var target = live.querySelector("[data-person='" + CSS.escape(targetSlug) + "']");
			if (!target) return;
			var parentPanel = target.closest("details.anee-people-panel");
			var bio = target.querySelector(".anee-profile-bio, details");
			if (parentPanel) parentPanel.open = true;
			if (bio) bio.open = true;
			target.scrollIntoView({ behavior: "smooth", block: "center" });
		}, 120);
	}

	document.addEventListener("DOMContentLoaded", normalizePeoplePage);
})();
