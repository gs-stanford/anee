(function () {
	"use strict";

	function isInteractiveElement(element) {
		return Boolean(
			element.closest(
				'a, button, input, textarea, select, summary, [contenteditable="true"]'
			)
		);
	}

	function setCardState(card, bio) {
		card.classList.toggle("is-expanded", bio.open);
		card.setAttribute("aria-expanded", bio.open ? "true" : "false");
	}

	function collectCards(section, selector) {
		var cards = Array.prototype.slice
			.call(section.querySelectorAll(selector))
			.filter(function (card) {
				return !card.closest(".anee-normalized-card-grid");
			});

		if (!cards.length) {
			return;
		}

		var grid = document.createElement("div");
		grid.className = "anee-normalized-card-grid";

		var anchor = section.querySelector(".anee-people-subheading, summary");
		if (anchor && anchor.parentNode === section) {
			anchor.insertAdjacentElement("afterend", grid);
		} else {
			section.appendChild(grid);
		}

		cards.forEach(function (card) {
			grid.appendChild(card);
		});
	}

	function normalizePeopleLayouts() {
		normalizeStanfordCards();
		normalizePanelCards();
	}

	function normalizeStanfordCards() {
		var directory = document.querySelector(".anee-people-directory");

		if (!directory) {
			return;
		}

		var section = directory.querySelector(".anee-people-section-default");

		if (!section) {
			return;
		}

		var cards = Array.prototype.slice
			.call(directory.querySelectorAll(".anee-profile-card:not(.anee-pi-card)"))
			.filter(function (card) {
				return !card.closest(".anee-people-panel");
			});

		if (!cards.length) {
			return;
		}

		var stanfordGrid = section.querySelector(".anee-normalized-card-grid");

		if (!stanfordGrid) {
			stanfordGrid = document.createElement("div");
			stanfordGrid.className = "anee-normalized-card-grid";

			var anchor = section.querySelector(".anee-people-subheading");
			if (anchor) {
				anchor.insertAdjacentElement("afterend", stanfordGrid);
			} else {
				section.appendChild(stanfordGrid);
			}
		}

		cards.forEach(function (card) {
			stanfordGrid.appendChild(card);
		});

		Array.prototype.slice
			.call(directory.querySelectorAll(".anee-normalized-card-grid"))
			.filter(function (card) {
				return card !== stanfordGrid && !card.closest(".anee-people-panel");
			})
			.forEach(function (grid) {
				grid.remove();
			});

		removeEmptyPeopleWrappers(directory);
	}

	function normalizePanelCards() {
		document.querySelectorAll(".anee-people-panel").forEach(function (panel) {
			collectCards(panel, ".anee-profile-card");
			removeEmptyPeopleWrappers(panel);
		});
	}

	function removeEmptyPeopleWrappers(section) {
		section
			.querySelectorAll(".wp-block-columns, .wp-block-column, .wp-block-group")
			.forEach(function (wrapper) {
				if (
					wrapper.classList.contains("anee-normalized-card-grid") ||
					wrapper.classList.contains("anee-pi-feature") ||
					wrapper.classList.contains("anee-pi-card") ||
					wrapper.classList.contains("anee-profile-card")
				) {
					return;
				}

				if (!wrapper.querySelector(".anee-profile-card") && wrapper.textContent.trim() === "") {
					wrapper.remove();
				}
			});
	}

	document.addEventListener("DOMContentLoaded", function () {
		normalizePeopleLayouts();

		document.querySelectorAll(".anee-profile-card").forEach(function (card) {
			var bio = card.querySelector(".anee-profile-bio");

			if (!bio) {
				return;
			}

			card.classList.add("has-clickable-bio");
			card.setAttribute("tabindex", "0");
			setCardState(card, bio);

			bio.addEventListener("toggle", function () {
				setCardState(card, bio);
			});

			card.addEventListener("click", function (event) {
				if (isInteractiveElement(event.target)) {
					return;
				}

				bio.open = !bio.open;
				setCardState(card, bio);
			});

			card.addEventListener("keydown", function (event) {
				if (event.target !== card || (event.key !== "Enter" && event.key !== " ")) {
					return;
				}

				event.preventDefault();
				bio.open = !bio.open;
				setCardState(card, bio);
			});
		});
	});
})();
