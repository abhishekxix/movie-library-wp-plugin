<?php
/**
 * Genre: Genre Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Genre custom taxonomy
 *
 * It is a hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Genre extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie-genre';

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
				'A Custom Taxonomy that represents a Movie Genre',
				'movie-library'
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
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
				'Genres',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'         => _x(
				'Genre',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'          => __(
				'Search Genres',
				'movie-library'
			),
			'all_items'             => __(
				'All Genres',
				'movie-library'
			),
			'parent_item'           => __(
				'Parent Genre',
				'movie-library'
			),
			'parent_item_colon'     => __(
				'Parent Genre:',
				'movie-library'
			),
			'edit_item'             => __(
				'Edit Genre',
				'movie-library'
			),
			'view_item'             => __(
				'View Genre',
				'movie-library'
			),
			'update_item'           => __(
				'Update Genre',
				'movie-library'
			),
			'add_new_item'          => __(
				'Add New Genre',
				'movie-library'
			),
			'new_item_name'         => __(
				'New Genre Name',
				'movie-library'
			),
			'not_found'             => __(
				'No genres found.',
				'movie-library'
			),
			'no_terms'              => __(
				'No genres',
				'movie-library'
			),
			'filter_by_item'        => __(
				'Filter by Genre',
				'movie-library'
			),
			'items_list_navigation' => __(
				'Genres list navigation',
				'movie-library'
			),
			'items_list'            => __(
				'Genres list',
				'movie-library'
			),
			'most_used'             => __(
				'Most Used Genres',
				'movie-library'
			),
			'back_to_items'         => __(
				'&larr; Back to genres',
				'movie-library'
			),
			'item_link'             => __(
				'Genre Link',
				'movie-library'
			),
			'item_link_description' => __(
				'A link to a Genre',
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
	 * Registers the Genre Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Genre();
	}
}
