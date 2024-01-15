<?php
/**
 * Person_Career: Person_Career Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Person_Career custom taxonomy
 *
 * It is a hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Person_Career extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-person-career';

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
				'A Custom Taxonomy that represents a Movie Career',
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
				'assign_terms' => 'edit_mlib-persons',
			),
			'rewrite'           => array(
				'slug'       => 'career',
				'with_front' => false,
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
				'Careers',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'         => _x(
				'Career',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'          => __(
				'Search Careers',
				'movie-library'
			),
			'all_items'             => __(
				'All Careers',
				'movie-library'
			),
			'parent_item'           => __(
				'Parent Career',
				'movie-library'
			),
			'parent_item_colon'     => __(
				'Parent Career:',
				'movie-library'
			),
			'edit_item'             => __(
				'Edit Career',
				'movie-library'
			),
			'view_item'             => __(
				'View Career',
				'movie-library'
			),
			'update_item'           => __(
				'Update Career',
				'movie-library'
			),
			'add_new_item'          => __(
				'Add New Career',
				'movie-library'
			),
			'new_item_name'         => __(
				'New Career Name',
				'movie-library'
			),
			'not_found'             => __(
				'No careers found.',
				'movie-library'
			),
			'no_terms'              => __(
				'No careers',
				'movie-library'
			),
			'filter_by_item'        => __(
				'Filter by Career',
				'movie-library'
			),
			'items_list_navigation' => __(
				'Careers list navigation',
				'movie-library'
			),
			'items_list'            => __(
				'Careers list',
				'movie-library'
			),
			'most_used'             => __(
				'Most Used Careers',
				'movie-library'
			),
			'back_to_items'         => __(
				'&larr; Back to careers',
				'movie-library'
			),
			'item_link'             => __(
				'Career Link',
				'movie-library'
			),
			'item_link_description' => __(
				'A link to a Career',
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
		$associated_object_types = array( 'mlib-person' );
		return $associated_object_types;
	}

	/**
	 * Registers the Person_Career Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Person_Career();
	}
}
