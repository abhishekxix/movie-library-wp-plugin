<?php //phpcs:ignore
/**
 * Base: A custom shortcode base class.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Shortcodes;

/**
 * Custom Shortcode abstract base class
 *
 * A class representing a custom shortcode.
 *
 * @since 0.1.0
 * @see add_shortcode() for more information.
 * @link https://developer.wordpress.org/reference/functions/add_shortcode/
 */
abstract class Base {
	/**
	 * Tag name.
	 *
	 * @since 0.1.0
	 */
	protected const TAG = 'mlib-shortcode';

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {
		wp_enqueue_style(
			'movie-library_custom_css',
			plugins_url() . '/movie-library/assets/css/styles.css',
			array(),
			'1.0.0'
		);

		add_action(
			'init',
			array( $this, 'custom_shortcode_init' )
		);
	}

	/**
	 * Adds the shortcode.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public function custom_shortcode_init() {
		add_shortcode(
			static::TAG,
			array( $this, 'shortcode_callback' )
		);
	}

	/**
	 * Accepts a title and will display a box.
	 *
	 * @param array  $atts    Shortcode attributes. Default empty.
	 * @param string $content Shortcode content. Default null.
	 * @param string $tag     Shortcode tag (name). Default empty.
	 * @return string Shortcode output.
	 * @since 0.1.0
	 */
	abstract public function shortcode_callback(
		$atts = array(),
		$content = null,
		$tag = ''
	);
}
