<?php
/**
 * Movie_Tag: Movie_Tag Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Non_Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Movie_Tag custom taxonomy
 *
 * It is a non-hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Movie_Tag extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie-tag';

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
				'A Custom Taxonomy that represents a Movie Tag',
				'movie-library'
			),
			'public'            => true,
			'hierarchical'      => false,
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
			'name'                       => _x(
				'Tags',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'              => _x(
				'Tag',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'               => __(
				'Search Tags',
				'movie-library'
			),
			'popular_items'              => __(
				'Popular Tags',
				'movie-library'
			),
			'all_items'                  => __(
				'All Tags',
				'movie-library'
			),
			'edit_item'                  => __(
				'Edit Tag',
				'movie-library'
			),
			'view_item'                  => __(
				'View Tag',
				'movie-library'
			),
			'update_item'                => __(
				'Update Tag',
				'movie-library'
			),
			'add_new_item'               => __(
				'Add New Tag',
				'movie-library'
			),
			'new_item_name'              => __(
				'New Tag Name',
				'movie-library'
			),
			'separate_items_with_commas' => __(
				'Separate tags with commas',
				'movie-library'
			),
			'add_or_remove_items'        => __(
				'Add or remove tags',
				'movie-library'
			),
			'choose_from_most_used'      => __(
				'Choose from the most used tags',
				'movie-library'
			),
			'not_found'                  => __(
				'No tags found.',
				'movie-library'
			),
			'no_terms'                   => __(
				'No tags',
				'movie-library'
			),
			'filter_by_item'             => __(
				'Filter by Tag',
				'movie-library'
			),
			'items_list_navigation'      => __(
				'Tags list navigation',
				'movie-library'
			),
			'items_list'                 => __(
				'Tags list',
				'movie-library'
			),
			'most_used'                  => __(
				'Most Used Tags',
				'movie-library'
			),
			'back_to_items'              => __(
				'&larr; Back to tags',
				'movie-library'
			),
			'item_link'                  => __(
				'Tag Link',
				'movie-library'
			),
			'item_link_description'      => __(
				'A link to a Tag',
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
	 * Registers the Movie_Tag Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Movie_Tag();
	}
}
