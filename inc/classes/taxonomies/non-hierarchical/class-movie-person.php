<?php
/**
 * Movie_Person: Movie_Person Hidden Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Non_Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Movie_Person custom taxonomy
 *
 * It is a non-hierarchical hidden taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Movie_Person extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = '_mlib-movie-person';

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
				'A Custom Taxonomy that represents a Movie Person',
				'movie-library'
			),
			'public'            => false,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => false,
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
			'name'                       => _x(
				'Persons',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'              => _x(
				'Person',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'               => __(
				'Search Persons',
				'movie-library'
			),
			'popular_items'              => __(
				'Popular Persons',
				'movie-library'
			),
			'all_items'                  => __(
				'All Persons',
				'movie-library'
			),
			'edit_item'                  => __(
				'Edit Person',
				'movie-library'
			),
			'view_item'                  => __(
				'View Person',
				'movie-library'
			),
			'update_item'                => __(
				'Update Person',
				'movie-library'
			),
			'add_new_item'               => __(
				'Add New Person',
				'movie-library'
			),
			'new_item_name'              => __(
				'New Person Name',
				'movie-library'
			),
			'separate_items_with_commas' => __(
				'Separate persons with commas',
				'movie-library'
			),
			'add_or_remove_items'        => __(
				'Add or remove persons',
				'movie-library'
			),
			'choose_from_most_used'      => __(
				'Choose from the most used persons',
				'movie-library'
			),
			'not_found'                  => __(
				'No persons found.',
				'movie-library'
			),
			'no_terms'                   => __(
				'No persons',
				'movie-library'
			),
			'filter_by_item'             => __(
				'Filter by Person',
				'movie-library'
			),
			'items_list_navigation'      => __(
				'Persons list navigation',
				'movie-library'
			),
			'items_list'                 => __(
				'Persons list',
				'movie-library'
			),
			'most_used'                  => __(
				'Most Used Persons',
				'movie-library'
			),
			'back_to_items'              => __(
				'&larr; Back to persons',
				'movie-library'
			),
			'item_link'                  => __(
				'Person Link',
				'movie-library'
			),
			'item_link_description'      => __(
				'A link to a Person',
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
	 * Registers the Movie_Person Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Movie_Person();
	}
}
