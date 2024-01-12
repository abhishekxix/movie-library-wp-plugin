<?php
/**
 * Movie_Library: The main MovieLibrary plugin class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc;

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
	 * Starts the instance.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function start() {
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
