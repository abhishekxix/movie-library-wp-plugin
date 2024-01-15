/* global jQuery,mlbImageGalleryTranslatedStrings */

jQuery(document).ready(function ($) {
	// Uploading files
	let movieLibraryImageGalleryFrame;
	const imageGalleryIDs = $('#movie_library_image_gallery');

	const movieLibraryCarouselPosters = $(
		'#movie-library_image_container ul.movie-library_images'
	);

	jQuery(document).on(
		'click',
		'#movie-library_add_image_btn',
		function (event) {
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if (movieLibraryImageGalleryFrame) {
				movieLibraryImageGalleryFrame.open();
				return;
			}

			// Create the media frame.
			movieLibraryImageGalleryFrame = wp.media.frames.downloadable_file =
				wp.media({
					// Set the title of the modal.
					title: mlbImageGalleryTranslatedStrings.modal_title,
					button: {
						text: mlbImageGalleryTranslatedStrings.modal_button_text,
					},
					multiple: true,
				});

			// When an image is selected, run a callback.
			movieLibraryImageGalleryFrame.on('select', function () {
				const selection = movieLibraryImageGalleryFrame
					.state()
					.get('selection');

				let attachmentIDs = imageGalleryIDs.val();

				selection.forEach(function (attachment) {
					attachment = attachment.toJSON();
					if (attachment.id) {
						attachmentIDs = attachmentIDs
							? attachmentIDs + ',' + attachment.id
							: attachment.id;

						movieLibraryCarouselPosters.append(`
							<li class="image ui-state-default" data-attachment_id="${attachment.id}">
								<img width="150" height="150" src="${attachment.url}"/>

								<ul class="actions">
									<li>
										<a 
											href="javascript:;"
											class="delete"
											title="${mlbImageGalleryTranslatedStrings.delete_link_title}"
										>
											${mlbImageGalleryTranslatedStrings.delete_link_text}
										</a>
									</li>
								</ul>
							</li>
						`);
					}
				});

				imageGalleryIDs.val(attachmentIDs);
			});

			// Finally, open the modal.
			movieLibraryImageGalleryFrame.open();
		}
	);

	// Remove images
	$('#movie-library_image_container').on('click', 'a.delete', function () {
		$(this).closest('li.image').remove();

		let attachmentIDs = '';

		$('#movie-library_image_container ul li.image')
			.css('cursor', 'default')
			.each(function () {
				const attachmentID = jQuery(this).attr('data-attachment_id');
				attachmentIDs = attachmentIDs + attachmentID + ',';
			});

		imageGalleryIDs.val(attachmentIDs);

		return false;
	});
});
