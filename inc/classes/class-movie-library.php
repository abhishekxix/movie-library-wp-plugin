<?php
/**
 * Movie_Library: The main MovieLibrary plugin class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc;

use Movie_Library\Inc\Dashboard_Widgets\Top_Rated;
use Movie_Library\Inc\Dashboard_Widgets\Upcoming;
use Movie_Library\Inc\Dashboard_Widgets\Upcoming_TMDB;
use Movie_Library\Inc\Database_API\Movie_Meta;
use Movie_Library\Inc\Database_API\Person_Meta;
use Movie_Library\Inc\Post_Types\Movie;
use Movie_Library\Inc\Post_Types\Person;
use Movie_Library\Inc\REST_API\Posts_Controller;
use Movie_Library\Inc\Rewrite_API\Movie_Rules;
use Movie_Library\Inc\Rewrite_API\Person_Rules;
use Movie_Library\Inc\Taxonomies\Hierarchical\Genre;
use Movie_Library\Inc\Taxonomies\Hierarchical\Label;
use Movie_Library\Inc\Taxonomies\Hierarchical\Language;
use Movie_Library\Inc\Taxonomies\Hierarchical\Person_Career;
use Movie_Library\Inc\Taxonomies\Hierarchical\Production_Company;
use Movie_Library\Inc\Taxonomies\Non_Hierarchical\Movie_Person;
use Movie_Library\Inc\Taxonomies\Non_Hierarchical\Movie_Tag;
use Movie_Library\Inc\Settings\Options_Page;
use Movie_Library\Inc\Shortcodes\Movie_Shortcode;
use Movie_Library\Inc\Shortcodes\Person_Shortcode;
use Movie_Library\Inc\User_Roles\Movie_Manager;

/**
 * Movie_Library Main class.
 *
 * This class handles the main functionality of the movie-library plugin. It acts as an entry point to the code for the plugin.
 *
 * @since 0.1.0
 */
final class Movie_Library {
	/**
	 * Single instance of the plugin.
	 *
	 * @since 0.1.0
	 * @var Movie_Library $instance The single instance of the class.
	 */
	private static $instance = null;


	/**
	 * Fires on the activation hook
	 *
	 * @return void
	 */
	public function activation_function() {
		/**
		 * We need to register post types at activation hook because they are being registered at `init` by default.
		 * `init` won't be run after activation hook because of redirection.
		 */
		$movie_cpt = new Movie();
		$movie_cpt->register_custom_post_type();
		$person_cpt = new Person();
		$person_cpt->register_custom_post_type();

		// Movie Post type taxonomies.
		$genre_taxonomy = new Genre();
		$genre_taxonomy->register_custom_taxonomy();

		$label_taxonomy = new Label();
		$label_taxonomy->register_custom_taxonomy();

		$language_taxonomy = new Language();
		$language_taxonomy->register_custom_taxonomy();

		$production_company_taxonomy = new Production_Company();
		$production_company_taxonomy->register_custom_taxonomy();

		$movie_person_taxonomy = new Movie_Person();
		$movie_person_taxonomy->register_custom_taxonomy();

		$movie_tag_taxonomy = new Movie_Tag();
		$movie_tag_taxonomy->register_custom_taxonomy();

		// Person Post type taxonomies.
		$person_career_taxonomy = new Person_Career();
		$person_career_taxonomy->register_custom_taxonomy();

		$this->register_custom_roles();
		$this->perform_db_changes();

		/**
		 * We have to setup rewrite rules at activation also because by default they need to be flushed.
		 */
		$movie_rules = new Movie_Rules();
		$movie_rules->add_permastruct();
		$person_rules = new Person_Rules();
		$person_rules->add_permastruct();

		flush_rewrite_rules();
	}

	/**
	 * Fires on the deactivation hook
	 *
	 * @return void
	 */
	public function deactivation_function() {
		$this->delete_custom_roles();
		flush_rewrite_rules();
	}

	/**
	 * Registers the Custom Post Types defined by the movie-library Plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function register_custom_post_types() {
		Movie::register_cpt();
		Person::register_cpt();
	}

	/**
	 * Registers the Custom Taxonomies defined by the movie-library Plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function register_custom_taxonomies() {
		// Movie Post type taxonomies.
		Genre::register_taxonomy();
		Label::register_taxonomy();
		Language::register_taxonomy();
		Production_Company::register_taxonomy();
		Movie_Tag::register_taxonomy();
		Movie_Person::register_taxonomy();

		// Person Post type taxonomies.
		Person_Career::register_taxonomy();
	}

	/**
	 * Register the custom metaboxes.
	 *
	 * @return void
	 */
	private function register_custom_metaboxes() {
		Meta_Boxes\Movie\Basic_Metabox::register();
		Meta_Boxes\Movie\Crew_Metabox::register();
		Meta_Boxes\Movie\MLib_Movie_Carousel_Metabox::register();
		Meta_Boxes\Person\Basic_Metabox::register();
		Meta_Boxes\Photo\MLib_Media_Image_Metabox::register();
		Meta_Boxes\Video\MLib_Media_Video_Metabox::register();
	}

	/**
	 * Registers the settings sub menu.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	private function register_admin_menus() {
		Options_Page::register();
	}

	/**
	 * Registers the Shortcodes defined by the movie-library Plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	private function register_shortcodes() {
		Movie_Shortcode::add_shortcode();
		Person_Shortcode::add_shortcode();
	}


	/**
	 * Adds the dashboard widgets
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function add_dashboard_widgets() {
		Top_Rated::add_widget_to_dashboard();
		Upcoming::add_widget_to_dashboard();
		Upcoming_TMDB::add_widget_to_dashboard();
	}

	/**
	 * Registers the custom roles
	 *
	 * @return void
	 */
	private function register_custom_roles() {
		Movie_Manager::add_role();
	}

	/**
	 * Deletes the custom roles
	 *
	 * @return void
	 */
	private function delete_custom_roles() {
		Movie_Manager::remove_role();
	}

	/**
	 * Sets up the custom rewrite rules for the plugin
	 *
	 * @return void
	 */
	private function setup_rewrite_rules() {
		Movie_Rules::add_rules();
		Person_Rules::add_rules();
	}

	/**
	 * Performs the changes in the Database as required.
	 *
	 * @return void
	 */
	private function perform_db_changes() {
		Movie_Meta::add_table();
		Person_Meta::add_table();
	}

	/**
	 * Register the custom tables to $wpdb for metadata functions.
	 *
	 * @return void
	 */
	public function register_db_names() {
		Movie_Meta::register_meta_table_name();
		Person_Meta::register_meta_table_name();
	}

	/**
	 * Loads the styles and scripts in admin.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function enqueue_scripts_and_styles() {
		wp_enqueue_style(
			'select2-css',
			'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
			array(),
			'4.1.0-rc.0'
		);
		wp_enqueue_script(
			'select2-js',
			'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
			array( 'jquery' ),
			'4.1.0-rc.0',
			false
		);

		wp_enqueue_script(
			'select2-init',
			MLIB_ASSETS_URI . '/js/select2-init.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);

		wp_enqueue_script(
			'mlib-movie-carousel-metabox',
			MLIB_ASSETS_URI . '/js/movie-carousel-metabox.js',
			array( 'jquery' ),
			'0.1.0',
			array(
				'in_footer' => true,
			)
		);

		wp_enqueue_script(
			'mlib-image-gallery-metabox',
			MLIB_ASSETS_URI . '/js/image-gallery-metabox.js',
			array( 'jquery' ),
			'0.1.0',
			array(
				'in_footer' => true,
			)
		);

		wp_enqueue_script(
			'mlib-video-gallery-metabox',
			MLIB_ASSETS_URI . '/js/video-gallery-metabox.js',
			array( 'jquery' ),
			'0.1.0',
			array(
				'in_footer' => true,
			)
		);
	}

	/**
	 * Loads the styles and scripts in frontend.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function enqueue_frontend_scripts_and_styles() {
		wp_enqueue_style(
			'movie-library_custom_css',
			MLIB_ASSETS_URI . '/css/styles.css',
			array(),
			'1.0.0'
		);
	}

	/**
	 * Initializes the Custom REST endpoints.
	 *
	 * @return void
	 */
	public function initialize_rest_api() {
		$movie_controller  = new Posts_Controller( 'mlib-movie', 'mlib-movie' );
		$person_controller = new Posts_Controller( 'mlib-person', 'mlib-person' );

		$movie_controller->register_routes();
		$person_controller->register_routes();
	}


	/**
	 * Starts the instance.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function start() {
		$this->register_custom_post_types();
		$this->register_custom_taxonomies();
		$this->register_custom_metaboxes();
		$this->register_admin_menus();
		$this->register_shortcodes();
		$this->add_dashboard_widgets();
		$this->setup_rewrite_rules();

		add_action(
			'init',
			array( $this, 'load_text_domain' )
		);

		add_action(
			'admin_enqueue_scripts',
			array( $this, 'enqueue_scripts_and_styles' )
		);

		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_frontend_scripts_and_styles' )
		);

		register_activation_hook(
			MLIB_PLUGIN_FILE,
			array( $this, 'activation_function' )
		);

		register_deactivation_hook(
			MLIB_PLUGIN_FILE,
			array( $this, 'deactivation_function' )
		);

		add_action( 'init', array( $this, 'register_db_names' ) );

		add_action( 'rest_api_init', array( $this, 'initialize_rest_api' ) );
	}

	/**
	 * Loads the plugin's text domain.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'movie-library', false, MLIB_PLUGIN_DIR . '/languages' );
	}

	/**
	 * Initializes the MovieLibrary plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function init() {
		if ( null !== self::$instance ) {
			return;
		}
		self::$instance = new Movie_Library();
		self::$instance->start();
	}
}
