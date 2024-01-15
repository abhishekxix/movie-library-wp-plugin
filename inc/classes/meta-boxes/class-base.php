<?php
/**
 * Base: A custom meta box base class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes;

use WP_Post;

/**
 * Custom Metabox abstract base class
 *
 * A class representing a custom meta box.
 *
 * @since 0.1.0
 * @see add_meta_box() for more information.
 * @link https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/
 */
abstract class Base {
	/**
	 * Metabox ID
	 *
	 * @since 0.1.0
	 */
	protected const ID = '';

	/**
	 * Metabox TITLE
	 *
	 * @since 0.1.0
	 */
	protected const TITLE = '';

	/**
	 * Metabox SCREENS
	 *
	 * @since 0.1.0
	 */
	protected const SCREENS = array();

	/**
	 * Metabox CONTEXT
	 *
	 * @since 0.1.0
	 */
	protected const CONTEXT = 'side';

	/**
	 * Metabox PRIORITY
	 *
	 * @since 0.1.0
	 */
	protected const PRIORITY = 'core';

	/**
	 * Constructor function.
	 */
	protected function __construct() {
		add_action(
			'add_meta_boxes',
			array( $this, 'register_meta_box' )
		);

		add_action(
			'save_post',
			array( $this, 'save_metadata' )
		);
	}

	/**
	 * Adds the metabox.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public function register_meta_box() {
		foreach ( static::SCREENS as $screen ) {
			add_meta_box(
				static::ID,
				static::TITLE,
				array( $this, 'render_meta_box' ),
				$screen,
				static::CONTEXT,
				static::PRIORITY
			);
		}
	}

	/**
	 * Abstract method to pass as callback to add_meta_box
	 *
	 * Must be implemented by child class.
	 *
	 * @param WP_Post $post WP_Post object passed to the callback.
	 * @return void
	 * @since 0.1.0
	 */
	abstract public function render_meta_box( $post );

	/**
	 * Abstract method to save the metadata.
	 *
	 * Must be implemented by child class.
	 *
	 * @param int $post_id  The post ID.
	 * @return void
	 * @since 0.1.0
	 */
	abstract public function save_metadata( $post_id );
}
