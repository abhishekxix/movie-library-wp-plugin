<?php
/**
 * Movie_Library: The main MovieLibrary plugin class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc;

use Movie_Library\Inc\Post_Types\Movie;
use Movie_Library\Inc\Post_Types\Person;
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
	}

	/**
	 * Fires on the deactivation hook
	 *
	 * @return void
	 */
	public function deactivation_function() {
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

		add_action(
			'init',
			array( $this, 'load_text_domain' )
		);

		register_activation_hook(
			MLIB_PLUGIN_FILE,
			array( $this, 'activation_function' )
		);

		register_deactivation_hook(
			MLIB_PLUGIN_FILE,
			array( $this, 'deactivation_function' )
		);
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
