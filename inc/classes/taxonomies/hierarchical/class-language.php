<?php
/**
 * Language: Language Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Language custom taxonomy
 *
 * It is a hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Language extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie-language';

	/**
	 * Returns the arguments for custom taxonomy registration.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	protected function get_custom_taxonomy_args() {
		$labels = $this->get_taxonomy_labels();

		$args = array(
			'labels'            => $labels,
			'description'       => __(
				'A Custom Taxonomy that represents a Movie Language',
				'movie-library'
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'capabilities'      => array(
				'manage_terms' => 'manage_' . self::SLUG,
				'edit_terms'   => 'edit_' . self::SLUG,
				'delete_terms' => 'delete_' . self::SLUG,
				'assign_terms' => 'edit_mlib-movies',
			),
		);

		return $args;
	}

	/**
	 * Returns the Taxonomy labels.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	private function get_taxonomy_labels() {
		$labels = array(
			'name'                  => _x(
				'Languages',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'         => _x(
				'Language',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'          => __(
				'Search Languages',
				'movie-library'
			),
			'all_items'             => __(
				'All Languages',
				'movie-library'
			),
			'parent_item'           => __(
				'Parent Language',
				'movie-library'
			),
			'parent_item_colon'     => __(
				'Parent Language:',
				'movie-library'
			),
			'edit_item'             => __(
				'Edit Language',
				'movie-library'
			),
			'view_item'             => __(
				'View Language',
				'movie-library'
			),
			'update_item'           => __(
				'Update Language',
				'movie-library'
			),
			'add_new_item'          => __(
				'Add New Language',
				'movie-library'
			),
			'new_item_name'         => __(
				'New Language Name',
				'movie-library'
			),
			'not_found'             => __(
				'No languages found.',
				'movie-library'
			),
			'no_terms'              => __(
				'No languages',
				'movie-library'
			),
			'filter_by_item'        => __(
				'Filter by Language',
				'movie-library'
			),
			'items_list_navigation' => __(
				'Languages list navigation',
				'movie-library'
			),
			'items_list'            => __(
				'Languages list',
				'movie-library'
			),
			'most_used'             => __(
				'Most Used languages',
				'movie-library'
			),
			'back_to_items'         => __(
				'&larr; Back to languages',
				'movie-library'
			),
			'item_link'             => __(
				'Language Link',
				'movie-library'
			),
			'item_link_description' => __(
				'A link to a Language',
				'movie-library'
			),
		);

		return $labels;
	}

	/**
	 * Returns the associated object types for the custom taxonomy registration.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	protected function get_associated_object_types() {
		$associated_object_types = array( 'mlib-movie' );
		return $associated_object_types;
	}

	/**
	 * Registers the Language Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Language();
	}
}
