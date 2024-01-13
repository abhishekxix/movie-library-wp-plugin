<?php
/**
 * Base: Custom Taxonomy base class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies;

/**
 * Custom Taxonomy base class
 *
 * @since 0.1.0
 * @see register_taxonomy() for more details.
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
abstract class Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'custom-taxonomy';

	/**
	 * Constructor function
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action(
			'init',
			array(
				$this,
				'register_custom_taxonomy',
			)
		);
	}

	/**
	 * Registers the custom taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public function register_custom_taxonomy() {
		$args                    = $this->get_custom_taxonomy_args();
		$associated_object_types = $this->get_associated_object_types();

		register_taxonomy(
			static::SLUG,
			$associated_object_types,
			$args
		);
	}

	/**
	 * Returns the arguments for custom taxonomy registration.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	abstract protected function get_custom_taxonomy_args();

	/**
	 * Returns the associated object types for the custom taxonomy registration.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	abstract protected function get_associated_object_types();
}
