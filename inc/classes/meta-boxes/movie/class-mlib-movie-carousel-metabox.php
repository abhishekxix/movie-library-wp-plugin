<?php
/**
 * MLib_Movie_Carousel_Metabox: Image metabox for mlib-movie-meta-carousel-poster
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes\Movie;

use WP_Post;
use Movie_Library\Inc\Meta_Boxes\Base;

/**
 * MLib_Movie_Carousel_Metabox for metabox on Image.
 */
class MLib_Movie_Carousel_Metabox extends Base {
	/**
	 * Metabox ID
	 *
	 * @since 0.1.0
	 */
	protected const ID = 'mlib-movie-meta-carousel-poster';

	/**
	 * Metabox TITLE
	 *
	 * @since 0.1.0
	 */
	protected const TITLE = 'Carousel Poster';

	/**
	 * Metabox SCREENS
	 *
	 * @since 0.1.0
	 */
	protected const SCREENS = array( 'mlib-movie' );

	/**
	 * Attachment ID key
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public static $attachment_id_key = 'mlib-movie-meta-carousel-poster';

	/**
	 * Renders the html of the Metabox
	 *
	 * @param WP_Post $post Post object passed to the callback.
	 * @since 0.1.0
	 * @return void
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field(
			'save_mlib-media_metadata_carousel_poster',
			'mlib-media_metadata_carousel_poster_nonce'
		);
		$movie_library_carousel_poster_gallery = json_decode(
			get_post_meta(
				$post->ID,
				self::$attachment_id_key,
				true
			),
			true
		) ?? array();

		if ( is_int( $movie_library_carousel_poster_gallery ) ) {
			$movie_library_carousel_poster_gallery = array( $movie_library_carousel_poster_gallery );
		}
		?>
		<button id="movie-library_add_carousel_poster_btn"><?php esc_html_e( 'Add Image', 'movie-library' ); ?></button>
		<div id="movie-library_carousel_poster_container">
			<ul class="movie-library_carousel_posters">
				<?php
				$attachments       = $movie_library_carousel_poster_gallery ?? array();
				$delete_link_title = esc_attr__(
					'Delete carousel poster',
					'movie-library'
				);

				$delete_link_text = esc_html__(
					'Delete',
					'movie-library'
				);

				if ( $attachments ) {
					foreach ( $attachments as $attachment_id ) {
						$attachment_id    = esc_attr( $attachment_id );
						$attachment_image = wp_get_attachment_image(
							$attachment_id,
							array( 150, 150 )
						);

						$attachment_list_item = <<<ATTACHMENT_LIST_ITEM
							<li class="image ui-state-default" data-attachment_id="{$attachment_id}">
								{$attachment_image}
								
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

						echo wp_kses_post( $attachment_list_item );
					}
				}
				?>
			</ul>

			<input
				type="hidden"
				id="movie_library_carousel_poster_gallery"
				name="movie_library_carousel_poster_gallery"
				value="<?php echo esc_attr( implode( ',', $movie_library_carousel_poster_gallery ) ); ?>"
			>
		</div>
		<?php
		$modal_title       = esc_html__(
			'Add Images to Gallery',
			'movie-library'
		);
		$modal_button_text = esc_html__(
			'Add to Gallery',
			'movie-library'
		);
		$script_data       = <<<SCRIPT_DATA
				const mlbMovieCarouselPosterTranslatedStrings = {
					delete_link_title:		'{$delete_link_title}',
					delete_link_text:		'{$delete_link_text}',
					modal_title:			'{$modal_title}',
					modal_button_text:		'{$modal_button_text}'
				};
		SCRIPT_DATA;

		wp_add_inline_script(
			'mlb-movie-carousel-metabox',
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

		if ( false === current_user_can( 'edit_posts' ) ) {
			wp_die( esc_textarea( __( 'You do not have permissions to edit posts.', 'movie-library' ) ) );
		}

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		if ( true === $is_autosave || true === $is_revision ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		if ( 'mlib-movie' !== $post_type ) {
			return;
		}

		// Verifies the nonce.
		if ( false === isset( $_POST['mlib-media_metadata_carousel_poster_nonce'] ) ||
			false === wp_verify_nonce(
				sanitize_text_field(
					wp_unslash(
						$_POST['mlib-media_metadata_carousel_poster_nonce']
					)
				),
				'save_mlib-media_metadata_carousel_poster'
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

		if ( true === isset( $_POST['movie_library_carousel_poster_gallery'] ) ) {
			$attachments = sanitize_text_field(
				wp_unslash(
					$_POST['movie_library_carousel_poster_gallery']
				)
			);

			$attachments = explode( ',', trim( $attachments ) );
			$last_item   = array_pop( $attachments );
			if ( '' !== $last_item ) {
				array_push( $attachments, $last_item );
			}

			$updated_value = array_shift( $attachments );

			if ( null === $updated_value ) {
				delete_post_meta( $post_id, self::$attachment_id_key );
			} else {
				update_post_meta(
					$post_id,
					self::$attachment_id_key,
					intval( $updated_value )
				);
			}
		}
	}

	/**
	 * Registers the Metabox
	 *
	 * @return void
	 */
	public static function register() {
		new MLib_Movie_Carousel_Metabox();
	}
}
