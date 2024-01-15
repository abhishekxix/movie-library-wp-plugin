<?php
/**
 * Basic_Metabox: Basic Movie Metabox class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes\Movie;

use DateTime;
use Movie_Library\Inc\Meta_Boxes\Base;
use WP_Post;

/**
 * Basic_Metabox class
 *
 * A class representing the Basic metabox in mlib-movie
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Meta_Boxes\Base
 */
class Basic_Metabox extends Base {
	/**
	 * Metabox ID
	 *
	 * @since 0.1.0
	 */
	protected const ID = 'mlib-movie-meta-basic';

	/**
	 * Metabox TITLE
	 *
	 * @since 0.1.0
	 */
	protected const TITLE = 'Basic';

	/**
	 * Metabox SCREENS
	 *
	 * @since 0.1.0
	 */
	protected const SCREENS = array( 'mlib-movie' );

	/**
	 * Rating meta key
	 *
	 * @var string $rating_meta_key
	 */
	public static $rating_meta_key = 'mlib-movie-meta-basic-rating';

	/**
	 * Runtime meta key
	 *
	 * @var string $runtime_meta_key
	 */
	public static $runtime_meta_key = 'mlib-movie-meta-basic-runtime';

	/**
	 * Release date meta key
	 *
	 * @var string $release_date_meta_key
	 */
	public static $release_date_meta_key = 'mlib-movie-meta-basic-release-date';

	/**
	 * Content rating meta key
	 *
	 * @var string $content_rating_meta_key
	 */
	public static $content_rating_meta_key = 'mlib-movie-meta-basic-content-rating';

	/**
	 * Allowed values for Content Rating.
	 *
	 * @var array $allowed_content_ratings
	 */
	public static $allowed_content_ratings = array(
		'G',
		'PG',
		'PG-13',
		'R',
		'NC-17',
		'U/A',
		'',
	);

	/**
	 * Renders the html of the Metabox
	 *
	 * @param WP_Post $post Post object passed to the callback.
	 * @since 0.1.0
	 * @return void
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field(
			'save_mlib-movie_metadata',
			'mlib-movie_metadata_nonce'
		);

		$rating = floatval(
			get_post_meta(
				$post->ID,
				self::$rating_meta_key,
				true
			)
		);

		$runtime = get_post_meta(
			$post->ID,
			self::$runtime_meta_key,
			true
		);

		$release_date = get_post_meta(
			$post->ID,
			self::$release_date_meta_key,
			true
		);

		$content_rating = get_post_meta(
			$post->ID,
			self::$content_rating_meta_key,
			true
		);

		?>

		<div class="custom_metabox_input_row">
			<label
				for="<?php echo esc_attr( self::$rating_meta_key ); ?>">
				<?php esc_html_e( 'Rating(0-10):', 'movie-library' ); ?>
			</label>

			<br>

			<input
				type="number"
				id="<?php echo esc_attr( self::$rating_meta_key ); ?>"
				name="<?php echo esc_attr( self::$rating_meta_key ); ?>"
				min="0"
				max="10"
				value="<?php echo esc_attr( $rating ); ?>"
				step="0.1"
				pattern="^\d*(\.\d{0,1})?$">

		</div>

		<div class="custom_metabox_input_row">
			<label
				for="<?php echo esc_attr( self::$runtime_meta_key ); ?>">
				<?php esc_html_e( 'Runtime:', 'movie-library' ); ?>
			</label>

			<br>

			<input
				type="number"
				id="<?php echo esc_attr( self::$runtime_meta_key ); ?>"
				name="<?php echo esc_attr( self::$runtime_meta_key ); ?>"
				min="0"
				value="<?php echo esc_attr( $runtime ); ?>"
				pattern="[1-9][0-9]*">

		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$release_date_meta_key ); ?>">
				<?php esc_html_e( 'Release date:', 'movie-library' ); ?>
			</label>

			<br>

			<input
				type="date"
				id="<?php echo esc_attr( self::$release_date_meta_key ); ?>"
				name="<?php echo esc_attr( self::$release_date_meta_key ); ?>"
				value="<?php echo esc_attr( $release_date ); ?>">

		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$content_rating_meta_key ); ?>">
				<?php esc_html_e( 'Content Rating:', 'movie-library' ); ?>
			</label>

			<br>

			<select
				class="movie-library_select2"
				name="<?php echo esc_attr( self::$content_rating_meta_key ); ?>"
				id="<?php echo esc_attr( self::$content_rating_meta_key ); ?>">

				<option>
					<?php esc_html_e( 'Select a rating...', 'movie-library' ); ?>
				</option>

				<?php
				foreach ( self::$allowed_content_ratings as $allowed_rating ) {
					?>
					<option value="<?php echo esc_attr( $allowed_rating ); ?>" 
						<?php selected( $content_rating, $allowed_rating ); ?>
					>
						<?php echo esc_html( $allowed_rating ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</div>
		<?php
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
			wp_die( esc_html( __( 'You do not have permissions to edit posts.', 'movie-library' ) ) );
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
		if ( false === isset( $_POST['mlib-movie_metadata_nonce'] ) ||
			false === wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['mlib-movie_metadata_nonce'] ) ),
				'save_mlib-movie_metadata'
			)
		) {
			wp_die(
				esc_html_e( 'Invalid request', 'movie-library' ),
				'',
				array(
					'response' => 401,
				)
			);
		}

		// Updates the Rating meta.
		if ( true === isset( $_POST[ self::$rating_meta_key ] ) ) {
			$rating = sanitize_text_field(
				wp_unslash(
					$_POST[ self::$rating_meta_key ]
				)
			);
			if ( false === self::is_rating_valid( $rating ) ) {
				return;
			}

			$rating = floatval( $rating );

			if ( 0 > $rating || 10 < $rating ) {
				return;
			}

			update_post_meta( $post_id, self::$rating_meta_key, $rating );
		}

		// Updates the Runtime meta.
		if ( true === isset( $_POST[ self::$runtime_meta_key ] ) ) {
			$runtime = sanitize_text_field(
				wp_unslash(
					$_POST[ self::$runtime_meta_key ]
				)
			);

			if ( false === self::is_runtime_valid( $runtime ) ) {
				return;
			}

			$runtime = intval( $runtime );

			if ( 0 > $runtime ) {
				return;
			}

			update_post_meta( $post_id, self::$runtime_meta_key, $runtime );
		}

		if ( true === isset( $_POST[ self::$release_date_meta_key ] ) ) {
			$release_date = preg_replace(
				'([^0-9\-])',
				'',
				sanitize_text_field(
					wp_unslash( $_POST[ self::$release_date_meta_key ] )
				)
			);

			if ( false === self::is_release_date_valid( $release_date ) ) {
				return;
			}

			update_post_meta( $post_id, self::$release_date_meta_key, $release_date );
		}

		if ( true === isset( $_POST[ self::$content_rating_meta_key ] ) ) {
			$content_rating = sanitize_text_field(
				wp_unslash(
					$_POST[ self::$content_rating_meta_key ]
				)
			);

			if ( false === self::is_content_rating_valid( $content_rating ) ) {
				return;
			}

			update_post_meta( $post_id, self::$content_rating_meta_key, $content_rating );
		}
	}

	/**
	 * Tests if the rating string provided by the user is valid.
	 *
	 * @param string $rating The value of rating provided by user.
	 * @return boolean
	 */
	private static function is_rating_valid( $rating ) {
		if ( false === is_numeric( $rating ) ) {
			return false;
		}

		return 1 === preg_match( '/^\d+(\.\d{1})?$/', $rating );
	}

	/**
	 * Validates runtime meta value.
	 *
	 * @param string $runtime The running time of the movie.
	 * @return boolean
	 * @since 0.1.0
	 */
	private static function is_runtime_valid( $runtime ) {
		if ( false === is_numeric( $runtime ) ) {
			return false;
		}

		return 1 === preg_match( '/^\d+$/', $runtime );
	}

	/**
	 * Validates the release date meta.
	 *
	 * @param string $release_date The date of release.
	 * @return boolean
	 * @since 0.1.0
	 */
	private static function is_release_date_valid( $release_date ) {
		$date = DateTime::createFromFormat( 'Y-m-d', $release_date );

		return $date && $date->format( 'Y-m-d' ) === $release_date;
	}

	/**
	 * Validates the content rating.
	 *
	 * @param string $content_rating The content rating of the movie.
	 * @return boolean
	 */
	private static function is_content_rating_valid( $content_rating ) {
		return true === in_array(
			$content_rating,
			self::$allowed_content_ratings,
			true
		);
	}

	/**
	 * Registers the Metabox
	 *
	 * @return void
	 */
	public static function register() {
		new Basic_Metabox();
	}
}
