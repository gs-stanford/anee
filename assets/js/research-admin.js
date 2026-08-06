(function ($) {
	"use strict";

	const control = document.querySelector(".boies-research-image-control");
	if (!control || !window.wp || !wp.media) {
		return;
	}

	const imageId = control.querySelector("[data-boies-research-image-id]");
	const preview = control.querySelector("[data-boies-research-image-preview]");
	const chooseButton = control.querySelector("[data-boies-research-image-choose]");
	const removeButton = control.querySelector("[data-boies-research-image-remove]");
	let frame;

	chooseButton.addEventListener("click", function () {
		if (!frame) {
			frame = wp.media({
				title: "Choose research image",
				button: { text: "Use this image" },
				library: { type: "image" },
				multiple: false,
			});

			frame.on("select", function () {
				const attachment = frame.state().get("selection").first().toJSON();
				const source = attachment.sizes?.medium?.url || attachment.sizes?.full?.url || attachment.url;

				imageId.value = attachment.id;
				preview.innerHTML = "";
				const image = document.createElement("img");
				image.src = source;
				image.alt = "";
				image.style.cssText = "display:block;width:100%;height:auto;max-height:180px;object-fit:cover;border-radius:6px;";
				preview.appendChild(image);
				chooseButton.textContent = "Replace image";
				removeButton.hidden = false;
			});
		}

		frame.open();
	});

	removeButton.addEventListener("click", function () {
		imageId.value = "";
		preview.innerHTML = '<p class="description">No research image selected.</p>';
		chooseButton.textContent = "Choose image";
		removeButton.hidden = true;
	});
})(jQuery);
