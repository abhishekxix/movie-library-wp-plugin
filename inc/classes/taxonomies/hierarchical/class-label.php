<?php
/**
 * Label: Label Taxonomy class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Taxonomies\Hierarchical;

use Movie_Library\Inc\Taxonomies\Base;

/**
 * Label custom taxonomy
 *
 * It is a hierarchical taxonomy.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Taxonomies\Base
 */
class Label extends Base {
	/**
	 * Taxonomy slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie-label';

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
				'A Custom Taxonomy that represents a Movie Label',
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
				'Labels',
				'taxonomy general name',
				'movie-library'
			),
			'singular_name'         => _x(
				'Label',
				'taxonomy singular name',
				'movie-library'
			),
			'search_items'          => __(
				'Search Labels',
				'movie-library'
			),
			'all_items'             => __(
				'All Labels',
				'movie-library'
			),
			'parent_item'           => __(
				'Parent Label',
				'movie-library'
			),
			'parent_item_colon'     => __(
				'Parent Label:',
				'movie-library'
			),
			'edit_item'             => __(
				'Edit Label',
				'movie-library'
			),
			'view_item'             => __(
				'View Label',
				'movie-library'
			),
			'update_item'           => __(
				'Update Label',
				'movie-library'
			),
			'add_new_item'          => __(
				'Add New Label',
				'movie-library'
			),
			'new_item_name'         => __(
				'New Label Name',
				'movie-library'
			),
			'not_found'             => __(
				'No labels found.',
				'movie-library'
			),
			'no_terms'              => __(
				'No labels',
				'movie-library'
			),
			'filter_by_item'        => __(
				'Filter by Label',
				'movie-library'
			),
			'items_list_navigation' => __(
				'Labels list navigation',
				'movie-library'
			),
			'items_list'            => __(
				'Labels list',
				'movie-library'
			),
			'most_used'             => __(
				'Most Used labels',
				'movie-library'
			),
			'back_to_items'         => __(
				'&larr; Back to labels',
				'movie-library'
			),
			'item_link'             => __(
				'Label Link',
				'movie-library'
			),
			'item_link_description' => __(
				'A link to a Label',
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
	 * Registers the Label Taxonomy.
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function register_taxonomy() {
		new Label();
	}
}
