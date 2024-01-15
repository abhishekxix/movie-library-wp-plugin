<?php
/**
 * Production_Company: Production_Company Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Production Company custom taxonomy
 *
 * It is a hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Production_Company extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie-production-company';

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
				'A Custom Taxonomy that represents a Movie Production Company',
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
				'Production Companies',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'         => _x(
				'Production Company',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'          => __(
				'Search Production Companies',
				'movie-library'
			),
			'all_items'             => __(
				'All Production Companies',
				'movie-library'
			),
			'parent_item'           => __(
				'Parent Production Company',
				'movie-library'
			),
			'parent_item_colon'     => __(
				'Parent Production Company:',
				'movie-library'
			),
			'edit_item'             => __(
				'Edit Production Company',
				'movie-library'
			),
			'view_item'             => __(
				'View Production Company',
				'movie-library'
			),
			'update_item'           => __(
				'Update Production Company',
				'movie-library'
			),
			'add_new_item'          => __(
				'Add New Production Company',
				'movie-library'
			),
			'new_item_name'         => __(
				'New Production Company Name',
				'movie-library'
			),
			'not_found'             => __(
				'No production companies found.',
				'movie-library'
			),
			'no_terms'              => __(
				'No production companies',
				'movie-library'
			),
			'filter_by_item'        => __(
				'Filter by Production Company',
				'movie-library'
			),
			'items_list_navigation' => __(
				'Production Companies list navigation',
				'movie-library'
			),
			'items_list'            => __(
				'Production Companies list',
				'movie-library'
			),
			'most_used'             => __(
				'Most Used production companies',
				'movie-library'
			),
			'back_to_items'         => __(
				'&larr; Back to production companies',
				'movie-library'
			),
			'item_link'             => __(
				'Production Company Link',
				'movie-library'
			),
			'item_link_description' => __(
				'A link to a Production Company',
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
	 * Registers the Production_Company Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Production_Company();
	}
}
