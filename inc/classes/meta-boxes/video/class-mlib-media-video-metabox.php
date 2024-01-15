<?php
/**
 * MLib_Media_Video_Metabox: Video metabox for mlib-media-meta-video
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes\Video;

use WP_Post;
use Movie_Library\Inc\Meta_Boxes\Base;

/**
 * MLib_Media_Video_Metabox for metabox on Video.
 */
class MLib_Media_Video_Metabox extends Base {
	/**
	 * Metabox ID
	 *
	 * @since 0.1.0
	 */
	protected const ID = 'mlib-media-meta-video';

	/**
	 * Metabox TITLE
	 *
	 * @since 0.1.0
	 */
	protected const TITLE = 'Video';

	/**
	 * Metabox SCREENS
	 *
	 * @since 0.1.0
	 */
	protected const SCREENS = array( 'mlib-movie', 'mlib-person' );

	/**
	 * Attachment ID key
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public static $attachment_id_key = 'mlib-media-meta-video';

	/**
	 * Renders the html of the Metabox
	 *
	 * @param WP_Post $post Post object passed to the callback.
	 * @since 0.1.0
	 * @return void
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field(
			'save_mlib-media_metadata_img',
			'mlib-media_metadata_img_nonce'
		);
		$movie_library_video_gallery = json_decode(
			get_post_meta(
				$post->ID,
				self::$attachment_id_key,
				true
			),
			true
		) ?? array();
		?>
		<button id="movie-library_add_video_btn"><?php esc_html_e( 'Add video', 'movie-library' ); ?></button>
		<div id="movie-library_video_container">
			<ul class="movie-library_videos">
				<?php
					$attachments = $movie_library_video_gallery ?? array();

					$delete_link_title = esc_attr__(
						'Delete video',
						'movie-library'
					);

					$delete_link_text = esc_attr__(
						'Delete',
						'movie-library'
					);

				if ( $attachments ) {
					foreach ( $attachments as $attachment_id ) {

						$attachment_id = esc_attr( $attachment_id );

						$attachment_url = esc_attr(
							wp_get_attachment_url(
								$attachment_id
							)
						);

						$attachment_list_item = <<<ATTACHMENT_LIST_ITEM
							<li class="video ui-state-default" data-attachment_id="{$attachment_id}">
								<video width="150" height="150" controls><source src="{$attachment_url}">
								</video>

								
								<ul class="actions">
									<li>
										<a
											href="javascript:;"
											class="delete" 
											title="{$delete_link_title}"
										>
											{$delete_link_text}
										</a>
									</li>
								</ul>
							</li>
						ATTACHMENT_LIST_ITEM;
						//phpcs:ignore
						echo $attachment_list_item;
					}
				}
				?>
			</ul>

			<input
				type="hidden"
				id="movie_library_video_gallery"
				name="movie_library_video_gallery"
				value="<?php echo esc_attr( implode( ',', $movie_library_video_gallery ) ); ?>"/>

		</div>

		<?php
		$modal_title       = esc_html__(
			'Add Videos to Gallery',
			'movie-library'
		);
		$modal_button_text = esc_html__(
			'Add Gallery',
			'movie-library'
		);
		$script_data       = <<<SCRIPT_DATA
				const mlbVideoGalleryTranslatedStrings = {
					delete_link_title:		'{$delete_link_title}',
					delete_link_text:		'{$delete_link_text}',
					modal_title:			'{$modal_title}',
					modal_button_text:		'{$modal_button_text}'
				};
		SCRIPT_DATA;

		wp_add_inline_script(
			'mlb-video-gallery-metabox',
			$script_data,
			'before'
		);
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 * @return void
	 * @since 0.1.0
	 */
	public function save_metadata( $post_id ) {
		if ( true === empty( $_POST ) ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		if ( 'mlib-person' !== $post_type && 'mlib-movie' !== $post_type ) {
			return;
		}

		if ( (
				'mlib-movie' === $post_type &&
				false === current_user_can( 'edit_posts' )
			) || (
				'mlib-person' === $post_type
				&& false === current_user_can( 'edit_posts' )
			) ) {
			wp_die(
				esc_html_e(
					'You do not have permissions to edit posts.',
					'movie-library'
				)
			);
		}

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		if ( true === $is_autosave || true === $is_revision ) {
			return;
		}

		// Verifies the nonce.
		if ( false === isset( $_POST['mlib-media_metadata_img_nonce'] ) ||
			false === wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['mlib-media_metadata_img_nonce'] ) ),
				'save_mlib-media_metadata_img'
			)
		) {
			wp_die(
				esc_html( __( 'Invalid request', 'movie-library' ) ),
				'',
				array(
					'response' => 401,
				)
			);
		}

		if ( true === isset( $_POST['movie_library_video_gallery'] ) ) {
			$attachments = sanitize_text_field(
				wp_unslash(
					$_POST['movie_library_video_gallery']
				)
			);

			$attachments = explode( ',', $attachments );

			$last_item = array_pop( $attachments );
			if ( '' !== $last_item ) {
				array_push( $attachments, $last_item );
			}

			$filtered_attachments = array();

			foreach ( $attachments as $attachment_id ) {
				if ( '' !== $attachment_id ) {
					$filtered_attachments[] = intval( $attachment_id );
				}
			}

			$attachments_in_json = wp_slash( wp_json_encode( $filtered_attachments ) );

			update_post_meta(
				$post_id,
				self::$attachment_id_key,
				$attachments_in_json
			);
		}
	}

	/**
	 * Registers the Metabox
	 *
	 * @return void
	 */
	public static function register() {
		new MLib_Media_Video_Metabox();
	}
}
