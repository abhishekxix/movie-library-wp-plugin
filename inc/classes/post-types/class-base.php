<?php
/**
 * Base class for Custom Post Type.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Post_Types;

/**
 * Custom Post Type base class.
 *
 * @since 0.1.0
 * @see register_post_type() for more details.
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
abstract class Base {
	/**
	 * Post type slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'custom-post';

	/**
	 * Constructor function.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action(
			'init',
			array(
				$this,
				'register_custom_post_type',
			)
		);
	}

	/**
	 * Registers the custom post type.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public function register_custom_post_type() {
		$args = $this->get_cpt_args();

		// phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
		register_post_type( static::SLUG, $args );
		$this->register_cpt_meta();
	}

	/**
	 * Returns the arguments for post type registration.
	 *
	 * @return array
	 */
	abstract protected function get_cpt_args();

	/**
	 * Registers the CPT metadata
	 *
	 * Call the register_post_meta function to register metadata for use in REST API and similar use cases.
	 *
	 * @return void
	 *
	 * @see \register_post_meta()
	 */
	public function register_cpt_meta() {
		$meta_keys = $this->get_meta_keys();

		if ( ! empty( $meta_keys ) ) {
			foreach ( $meta_keys as $meta_key ) {
				register_post_meta(
					static::SLUG,
					$meta_key,
					array(
						'single'       => true,
						'show_in_rest' => true,
					)
				);
			}
		}
	}

	/**
	 * Returns the meta keys to register for the CPT
	 *
	 * @return array
	 */
	public function get_meta_keys() {
		return array();
	}
}
