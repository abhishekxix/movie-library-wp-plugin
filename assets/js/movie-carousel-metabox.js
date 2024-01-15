/* global jQuery,mlbMovieCarouselPosterTranslatedStrings */

jQuery(document).ready(function ($) {
	// Uploading files
	let movieLibraryGalleryFrame;
	const carouselPosterGalleryIDs = $(
		'#movie_library_carousel_poster_gallery'
	);

	const movieLibraryCarouselPosters = $(
		'#movie-library_carousel_poster_container ul.movie-library_carousel_posters'
	);

	jQuery(document).on(
		'click',
		'#movie-library_add_carousel_poster_btn',
		function (event) {
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if (movieLibraryGalleryFrame) {
				movieLibraryGalleryFrame.open();
				return;
			}

			// Create the media frame.
			movieLibraryGalleryFrame = wp.media.frames.downloadable_file =
				wp.media({
					// Set the title of the modal.
					title: mlbMovieCarouselPosterTranslatedStrings.modal_title,
					button: {
						text: mlbMovieCarouselPosterTranslatedStrings.modal_button_text,
					},
					multiple: true,
				});

			// When an image is selected, run a callback.
			movieLibraryGalleryFrame.on('select', function () {
				const selection = movieLibraryGalleryFrame
					.state()
					.get('selection');

				let attachmentIDs = carouselPosterGalleryIDs.val();

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
											title="${mlbMovieCarouselPosterTranslatedStrings.delete_link_title}"
										>
											${mlbMovieCarouselPosterTranslatedStrings.delete_link_text}
										</a>
									</li>
								</ul>
							</li>
						`);
					}
				});

				carouselPosterGalleryIDs.val(attachmentIDs);
			});

			// Finally, open the modal.
			movieLibraryGalleryFrame.open();
		}
	);

	// Remove images
	$('#movie-library_carousel_poster_container').on(
		'click',
		'a.delete',
		function () {
			$(this).closest('li.image').remove();

			let attachmentIDs = '';

			$('#movie-library_carousel_poster_container ul li.image')
				.css('cursor', 'default')
				.each(function () {
					const attachmentID =
						jQuery(this).attr('data-attachment_id');
					attachmentIDs = attachmentIDs + attachmentID + ',';
				});

			carouselPosterGalleryIDs.val(attachmentIDs);

			return false;
		}
	);
});
