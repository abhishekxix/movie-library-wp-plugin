<?php
/**
 * Options_Page: A class to register the settings page for the plugin
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Settings;

/**
 * Class for registering a new settings page under Settings.
 *
 * @since 0.1.0
 */
class Options_Page {

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'settings_submenu_page' ) );
		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}

	/**
	 * Registers a new settings page under Settings.
	 *
	 * @since 0.1.0
	 */
	public function settings_submenu_page() {
		add_options_page(
			__( 'Movie Library', 'movie-library' ),
			__( 'Movie Library', 'movie-library' ),
			'manage_options',
			'movie-library-settings',
			array( $this, 'settings_page_content' )
		);
	}

	/**
	 * Initialize the settings.
	 *
	 * @since 0.1.0
	 */
	public function settings_init() {
		register_setting(
			'movie-library-options',
			'movie_library_cleanup_on_delete',
			array(
				'type'        => 'boolean',
				'description' => __( 'Determines whether or not plugin content will be cleaned up on deletion.', 'movie-library' ),
				'default'     => false,
			)
		);

		register_setting(
			'movie-library-options',
			'movie_library_tmdb_api_key',
			array(
				'type'        => 'string',
				'description' => __( 'API key for TMDB', 'movie-library' ),
				'default'     => '',
			)
		);

		add_settings_section(
			'movie-library-on-delete',
			__( 'Behaviour on Deletion', 'movie-library' ),
			array( $this, 'on_delete_section_cb' ),
			'movie-library-settings'
		);

		add_settings_section(
			'movie-library-tmdb-api-key',
			__( 'TMDB API key', 'movie-library' ),
			array( $this, 'tmdb_api_section_cb' ),
			'movie-library-settings'
		);

		add_settings_field(
			'movie-library-on-delete-field',
			__( 'Delete All Content on Plugin Deletion', 'movie-library' ),
			array( $this, 'on_delete_field_cb' ),
			'movie-library-settings',
			'movie-library-on-delete'
		);

		add_settings_field(
			'movie-library-tmdb-api-key-field',
			__( 'API key for TMDB.', 'movie-library' ),
			array( $this, 'tmdb_api_key_field_cb' ),
			'movie-library-settings',
			'movie-library-tmdb-api-key'
		);
	}

	/**
	 * Renders on_delete section content
	 *
	 * @since 0.1.0
	 */
	public function on_delete_section_cb() {
		?>
		<p>
			<?php
			esc_html_e(
				'Choose the behaviour when the plugin is deleted:',
				'movie-library'
			);
			?>
		</p>
		<?php
	}

	/**
	 * Renders tmdb_api_key section content
	 *
	 * @since 0.1.0
	 */
	public function tmdb_api_section_cb() {
		?>
		<p>
			<?php
			esc_html_e(
				'Enter the API key for TMDB to display dashboard widgets.',
				'movie-library'
			);
			?>
		</p>
		<?php
	}

	/**
	 * Renders the on_delete field
	 *
	 * @since 0.1.0
	 */
	public function on_delete_field_cb() {
		$enable_cleanup_on_delete = get_option( 'movie_library_cleanup_on_delete', false );
		?>
		<input 
			type="checkbox" 
			name="movie_library_cleanup_on_delete"
			id="movie_library_cleanup_on_delete"
			value="1"
			<?php checked( $enable_cleanup_on_delete, true ); ?>
		>
		<label for="movie_library_cleanup_on_delete"><?php esc_html_e( 'Delete all content on plugin deletion', 'movie-library' ); ?></label>
		<?php
	}

	/**
	 * Renders the api key field
	 *
	 * @since 0.1.0
	 */
	public function tmdb_api_key_field_cb() {
		$tmdb_api_key = get_option( 'movie_library_tmdb_api_key', '' );
		?>
		<input 
			type="password" 
			name="movie_library_tmdb_api_key"
			id="movie_library_tmdb_api_key"
			value="<?php echo esc_attr( $tmdb_api_key ); ?>"
		>
		<br>
		<label for="movie_library_tmdb_api_key">
			<?php
			esc_html_e(
				'Enter the API key provided by TMDB to show the widgets in dashboard.',
				'movie-library'
			);
			?>
		</label>
		<?php
	}

	/**
	 * Settings page display callback.
	 *
	 * @since 0.1.0
	 */
	public function settings_page_content() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'movie-library-options' );
				do_settings_sections( 'movie-library-settings' );
				wp_nonce_field( 'movie-library-options-options' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Registers the options page
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register() {
		new Options_Page();
	}
}
