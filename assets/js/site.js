(function () {
	"use strict";

	document.addEventListener("DOMContentLoaded", function () {
		var toggle = document.querySelector(".boies-nav-toggle");
		var nav = document.querySelector(".boies-nav");

		if (toggle && nav) {
			nav.id = "boies-primary-menu";
			toggle.addEventListener("click", function () {
				var open = toggle.getAttribute("aria-expanded") === "true";
				toggle.setAttribute("aria-expanded", open ? "false" : "true");
				nav.classList.toggle("is-open", !open);
			});
		}

		if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
			document.querySelectorAll("video[autoplay]").forEach(function (video) {
				video.pause();
			});
		}
	});
})();
