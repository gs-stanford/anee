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
		document
			.querySelectorAll(".anee-people-section-default")
			.forEach(function (section) {
				collectCards(section, ".anee-profile-card:not(.anee-pi-card)");
				removeEmptyPeopleWrappers(section);
			});

		document.querySelectorAll(".anee-people-panel").forEach(function (panel) {
			collectCards(panel, ".anee-profile-card");
			removeEmptyPeopleWrappers(panel);
		});

		collectLooseStanfordCards();
	}

	function collectLooseStanfordCards() {
		var directory = document.querySelector(".anee-people-directory");

		if (!directory) {
			return;
		}

		var stanfordGrid =
			directory.querySelector(".anee-people-section-default .anee-normalized-card-grid") ||
			Array.prototype.slice
				.call(directory.querySelectorAll(".anee-normalized-card-grid"))
				.filter(function (grid) {
					return !grid.closest(".anee-people-panel");
				})[0];

		if (!stanfordGrid) {
			return;
		}

		Array.prototype.slice
			.call(directory.querySelectorAll(".anee-normalized-card-grid"))
			.forEach(function (grid) {
				if (grid === stanfordGrid || grid.closest(".anee-people-panel")) {
					return;
				}

				Array.prototype.slice
					.call(grid.querySelectorAll(".anee-profile-card:not(.anee-pi-card)"))
					.forEach(function (card) {
						stanfordGrid.appendChild(card);
					});

				if (!grid.children.length) {
					grid.remove();
				}
			});

		Array.prototype.slice
			.call(directory.querySelectorAll(".anee-profile-card:not(.anee-pi-card)"))
			.filter(function (card) {
				return (
					!card.closest(".anee-normalized-card-grid") &&
					!card.closest(".anee-people-panel")
				);
			})
			.forEach(function (card) {
				stanfordGrid.appendChild(card);
			});

		removeEmptyPeopleWrappers(directory);
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
