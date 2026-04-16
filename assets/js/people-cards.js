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

	document.addEventListener("DOMContentLoaded", function () {
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
