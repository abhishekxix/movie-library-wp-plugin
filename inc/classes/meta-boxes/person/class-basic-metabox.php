<?php
/**
 * Basic_Metabox: Basic Person Metabox class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes\Person;

use DateTime;
use Movie_Library\Inc\Meta_Boxes\Base;
use WP_Post;

/**
 * Basic_Metabox class
 *
 * A class representing the Basic metabox in mlib-person
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
	protected const ID = 'mlib-person-meta-basic';

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
	protected const SCREENS = array( 'mlib-person' );

	/**
	 * Full name meta key
	 *
	 * @var string $full_name_meta_key
	 */
	public static $full_name_meta_key = 'mlib-person-meta-full-name';

	/**
	 * Birth date meta key
	 *
	 * @var string $birth_date_meta_key
	 */
	public static $birth_date_meta_key = 'mlib-person-meta-basic-birth-date';

	/**
	 * Birth place meta key
	 *
	 * @var string $birth_place_meta_key
	 */
	public static $birth_place_meta_key = 'mlib-person-meta-basic-birth-place';

	/**
	 * Social media link meta key
	 *
	 * @var string $social_meta_key
	 */
	public static $social_meta_key = 'mlib-person-meta-social';

	/**
	 * Twitter link meta key.
	 *
	 * @var string $twitter_meta_key
	 */
	public static $twitter_meta_key = 'mlib-person-meta-social-twitter';

	/**
	 * Facebook link meta key.
	 *
	 * @var string $facebook_meta_key
	 */
	public static $facebook_meta_key = 'mlib-person-meta-social-facebook';

	/**
	 * Instagram link meta key
	 *
	 * @var string $instagram_meta_key
	 */
	public static $instagram_meta_key = 'mlib-person-meta-social-instagram';

	/**
	 * Website link meta key
	 *
	 * @var string $website_meta_key
	 */
	public static $website_meta_key = 'mlib-person-meta-social-web';

	/**
	 * Renders the html of the Metabox
	 *
	 * @param WP_Post $post Post object passed to the callback.
	 * @since 0.1.0
	 * @return void
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( 'save_mlib-person_metadata', 'mlib-person_metadata_nonce' );

		$full_name = get_post_meta(
			$post->ID,
			self::$full_name_meta_key,
			true
		);

		$birth_date = get_post_meta(
			$post->ID,
			self::$birth_date_meta_key,
			true
		);

		$birth_place = get_post_meta(
			$post->ID,
			self::$birth_place_meta_key,
			true
		);

		$social_twitter = get_post_meta(
			$post->ID,
			self::$twitter_meta_key,
			true
		);

		$social_facebook = get_post_meta(
			$post->ID,
			self::$facebook_meta_key,
			true
		);

		$social_instagram = get_post_meta(
			$post->ID,
			self::$instagram_meta_key,
			true
		);

		$social_web = get_post_meta(
			$post->ID,
			self::$website_meta_key,
			true
		);
		?>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$full_name_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Full Name:',
					'movie-library'
				);
				?>
			</label>

			<br>

			<input
				type="text"
				id="<?php echo esc_attr( self::$full_name_meta_key ); ?>"
				name="<?php echo esc_attr( self::$full_name_meta_key ); ?>"
				value="<?php echo esc_attr( $full_name ); ?>">
		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$birth_date_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Birth Date:',
					'movie-library'
				);
				?>
			</label><br>
			<input 
				type="date"
				id="<?php echo esc_attr( self::$birth_date_meta_key ); ?>"
				name="<?php echo esc_attr( self::$birth_date_meta_key ); ?>"
				value="<?php echo esc_attr( $birth_date ); ?>"
			>
		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$birth_place_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Birth Place:',
					'movie-library'
				)
				?>
			</label>
			<br>
			<textarea 
				id="<?php echo esc_attr( self::$birth_place_meta_key ); ?>"
				name="<?php echo esc_attr( self::$birth_place_meta_key ); ?>"
			><?php echo esc_textarea( $birth_place ); ?></textarea>
		</div>

		<hr>
		<strong><?php esc_html_e( 'Social', 'movie-library' ); ?></strong>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$twitter_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Twitter Link:',
					'movie-library'
				);
				?>
			</label>
			<br>
			<input 
				type="url" 
				id="<?php echo esc_attr( self::$twitter_meta_key ); ?>"
				name="<?php echo esc_attr( self::$twitter_meta_key ); ?>"
				value="<?php echo esc_attr( $social_twitter ); ?>" 
			>
		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$facebook_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Facebook Link:',
					'movie-library'
				);
				?>
			</label>
			<br>
			<input 
				type="url" 
				id="<?php echo esc_attr( self::$facebook_meta_key ); ?>"
				name="<?php echo esc_attr( self::$facebook_meta_key ); ?>"
				value="<?php echo esc_attr( $social_facebook ); ?>" 
			>
		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$instagram_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Instagram Link:',
					'movie-library'
				);
				?>
			</label>
			<br>
			<input 
				type="url" 
				id="<?php echo esc_attr( self::$instagram_meta_key ); ?>"
				name="<?php echo esc_attr( self::$instagram_meta_key ); ?>"
				value="<?php echo esc_attr( $social_instagram ); ?>" 
			>
		</div>

		<div class="custom_metabox_input_row">
			<label 
				for="<?php echo esc_attr( self::$website_meta_key ); ?>"
			>
				<?php
				esc_html_e(
					'Website Link:',
					'movie-library'
				);
				?>
			</label>
			<br>
			<input 
				type="url" 
				id="<?php echo esc_attr( self::$website_meta_key ); ?>"
				name="<?php echo esc_attr( self::$website_meta_key ); ?>"
				value="<?php echo esc_attr( $social_web ); ?>" 
			>
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
			wp_die( esc_textarea( __( 'You do not have permissions to edit posts.', 'movie-library' ) ) );
		}

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		if ( true === $is_autosave || true === $is_revision ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		if ( 'mlib-person' !== $post_type ) {
			return;
		}

		// Verifies the nonce.
		if ( false === isset( $_POST['mlib-person_metadata_nonce'] ) ||
			false === wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['mlib-person_metadata_nonce'] ) ),
				'save_mlib-person_metadata'
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

		// Updates the full name meta.
		if ( true === isset( $_POST[ self::$full_name_meta_key ] ) ) {
			$full_name = sanitize_text_field(
				wp_unslash(
					$_POST[ self::$full_name_meta_key ]
				)
			);
			$full_name = trim( $full_name );
			if ( false === self::is_full_name_valid( $full_name ) ) {
				return;
			}

			update_post_meta( $post_id, self::$full_name_meta_key, $full_name );
		}

		// Updates the birth date meta.
		if ( true === isset( $_POST[ self::$birth_date_meta_key ] ) ) {
			$release_date = preg_replace(
				'([^0-9\-])',
				'',
				sanitize_text_field(
					wp_unslash( $_POST[ self::$birth_date_meta_key ] )
				)
			);

			if ( false === self::is_birth_date_valid( $release_date ) ) {
				return;
			}

			update_post_meta( $post_id, self::$birth_date_meta_key, $release_date );
		}

		// Updates birth place meta.
		if ( true === isset( $_POST[ self::$birth_place_meta_key ] ) ) {
			$birth_place = sanitize_textarea_field(
				wp_unslash(
					$_POST[ self::$birth_place_meta_key ]
				)
			);

			update_post_meta( $post_id, self::$birth_place_meta_key, $birth_place );
		}

		// Updates social URL metas.

		if ( true === isset( $_POST[ self::$twitter_meta_key ] ) ) {
			self::save_url_meta( $post_id, self::$twitter_meta_key );

		}

		if ( true === isset( $_POST[ self::$facebook_meta_key ] ) ) {
			self::save_url_meta( $post_id, self::$facebook_meta_key );

		}

		if ( true === isset( $_POST[ self::$instagram_meta_key ] ) ) {
			self::save_url_meta( $post_id, self::$instagram_meta_key );
		}

		if ( true === isset( $_POST[ self::$website_meta_key ] ) ) {
			self::save_url_meta( $post_id, self::$website_meta_key );
		}
	}

	/**
	 * Tests if the full name string provided by the user is valid.
	 *
	 * @param string $full_name The value of rating provided by user.
	 * @return boolean
	 * @since 0.1.0
	 */
	private static function is_full_name_valid( $full_name ) {
		return 1 === preg_match( '/^([A-Z]|\ |[a-z]|\.)+$/', $full_name );
	}

	/**
	 * Validates the birth date meta.
	 *
	 * @param string $birth_date The date of release.
	 * @return boolean
	 * @since 0.1.0
	 */
	private static function is_birth_date_valid( $birth_date ) {
		$date = DateTime::createFromFormat( 'Y-m-d', $birth_date );

		return $date && $date->format( 'Y-m-d' ) === $birth_date;
	}

	/**
	 * Saves the URL meta data.
	 *
	 * @param int    $post_id ID of the person.
	 * @param string $meta_key URL meta key.
	 * @return void
	 * @since 0.1.0
	 */
	private static function save_url_meta( int $post_id, string $meta_key ) {
		$url = esc_url_raw(
			wp_unslash(
				// phpcs:ignore
				$_POST[ $meta_key ]
			),
			array( 'http', 'https' )
		);

		update_post_meta( $post_id, $meta_key, $url );
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
