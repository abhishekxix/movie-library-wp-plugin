/* global jQuery,mlbVideoGalleryTranslatedStrings */

jQuery(document).ready(function ($) {
	// Uploading files
	let movieLibraryVideoGalleryFrame;
	const videoGalleryIDs = $('#movie_library_video_gallery');

	const movieLibraryCarouselPosters = $(
		'#movie-library_video_container ul.movie-library_videos'
	);

	jQuery(document).on(
		'click',
		'#movie-library_add_video_btn',
		function (event) {
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if (movieLibraryVideoGalleryFrame) {
				movieLibraryVideoGalleryFrame.open();
				return;
			}

			// Create the media frame.
			movieLibraryVideoGalleryFrame = wp.media.frames.downloadable_file =
				wp.media({
					// Set the title of the modal.
					title: mlbVideoGalleryTranslatedStrings.modal_title,
					button: {
						text: mlbVideoGalleryTranslatedStrings.modal_button_text,
					},
					multiple: true,
				});

			// When an video is selected, run a callback.
			movieLibraryVideoGalleryFrame.on('select', function () {
				const selection = movieLibraryVideoGalleryFrame
					.state()
					.get('selection');

				let attachmentIDs = videoGalleryIDs.val();

				selection.forEach(function (attachment) {
					attachment = attachment.toJSON();
					if (attachment.id) {
						attachmentIDs = attachmentIDs
							? attachmentIDs + ',' + attachment.id
							: attachment.id;

						movieLibraryCarouselPosters.append(`
							<li class="video ui-state-default" data-attachment_id="${attachment.id}">
								<video width="150" height="150" controls><source src="${attachment.url}"/>
								</video>

								<ul class="actions">
									<li>
										<a 
											href="javascript:;"
											class="delete"
											title="${mlbVideoGalleryTranslatedStrings.delete_link_title}"
										>
											${mlbVideoGalleryTranslatedStrings.delete_link_text}
										</a>
									</li>
								</ul>
							</li>
						`);
					}
				});

				videoGalleryIDs.val(attachmentIDs);
			});

			// Finally, open the modal.
			movieLibraryVideoGalleryFrame.open();
		}
	);

	// Remove videos
	$('#movie-library_video_container').on('click', 'a.delete', function () {
		$(this).closest('li.video').remove();

		let attachmentIDs = '';

		$('#movie-library_video_container ul li.video')
			.css('cursor', 'default')
			.each(function () {
				const attachmentID = jQuery(this).attr('data-attachment_id');
				attachmentIDs = attachmentIDs + attachmentID + ',';
			});

		videoGalleryIDs.val(attachmentIDs);

		return false;
	});
});
