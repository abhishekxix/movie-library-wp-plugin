<?php
/**
 * Person: Person custom post type
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Post_Types;

/**
 * Person post type class.
 *
 * Represents the following post type:
 *
 * Person (mlib-person)
 * - Supports: title, editor, excerpt, thumbnail, author
 * - Person information mapping with post fields.
 * - Name (Post Title)
 * - Biography (Post Content)
 * - Profile Picture (Featured Image)
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Post_Types\Base
 */
class Person extends Base {
	/**
	 * Post type slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-person';

	/**
	 * Returns the arguments for post type registration.
	 *
	 * @return array
	 */
	protected function get_cpt_args() {
		$labels = $this->get_cpt_labels();

		$args = array(
			'label'           => __(
				'Persons',
				'movie-library'
			),
			'labels'          => $labels,
			'supports'        => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'author',
				'custom-fields',
			),
			'show_in_rest'    => true,
			'public'          => true,
			'description'     => __(
				'A Custom Post type that represents a person',
				'movie-library'
			),
			'menu_icon'       => 'dashicons-businessperson',
			'menu_position'   => 5,
			'has_archive'     => true,
			'capability_type' => 'mlib-person',
			'map_meta_cap'    => true,
			'rewrite'         => array(
				'slug'       => 'mlib-person',
				'with_front' => false,
			),
		);

		return $args;
	}

	/**
	 * Returns the labels for post type registration.
	 *
	 * @return array
	 */
	private function get_cpt_labels() {
		$labels = array(
			'name'                     => _x(
				'Persons',
				'Post type general name',
				'movie-library'
			),
			'singular_name'            => _x(
				'Person',
				'Post type singular name',
				'movie-library'
			),
			'add_new'                  => _x(
				'Add New',
				'person',
				'movie-library'
			),
			'add_new_item'             => __(
				'Add New Person',
				'movie-library'
			),
			'edit_item'                => __(
				'Edit Person',
				'movie-library'
			),
			'new_item'                 => __(
				'New Person',
				'movie-library'
			),
			'view_item'                => __(
				'View Person',
				'movie-library'
			),
			'view_items'               => __(
				'View Persons',
				'movie-library'
			),
			'search_items'             => __(
				'Search Persons',
				'movie-library'
			),
			'not_found'                => __(
				'No Persons found',
				'movie-library'
			),
			'not_found_in_trash'       => __(
				'No Persons found in trash',
				'movie-library'
			),
			'all_items'                => __(
				'All Persons',
				'movie-library'
			),
			'archives'                 => __(
				'Person Archives',
				'movie-library'
			),
			'attributes'               => __(
				'Person Attributes',
				'movie-library'
			),
			'insert_into_item'         => __(
				'Insert into person',
				'movie-library'
			),
			'uploaded_to_this_item'    => __(
				'Uploaded to this person',
				'movie-library'
			),
			'featured_image'           => __(
				'Profile Picture',
				'movie-library'
			),
			'set_featured_image'       => __(
				'Set Profile Picture',
				'movie-library'
			),
			'remove_featured_image'    => __(
				'Remove Profile Picture',
				'movie-library'
			),
			'use_featured_image'       => __(
				'Use as Profile Picture',
				'movie-library'
			),
			'filter_items_list'        => __(
				'Filter Persons list',
				'movie-library'
			),
			'items_list_navigation'    => __(
				'Persons list navigation',
				'movie-library'
			),
			'items_list'               => __(
				'Persons list',
				'movie-library'
			),
			'item_published'           => __(
				'Person published',
				'movie-library'
			),
			'item_published_privately' => __(
				'Person published privately',
				'movie-library'
			),
			'item_reverted_to_draft'   => __(
				'Person reverted to draft',
				'movie-library'
			),
			'item_scheduled'           => __(
				'Person scheduled',
				'movie-library'
			),
			'item_updated'             => __(
				'Person udpated',
				'movie-library'
			),
			'item_link'                => __(
				'Person link',
				'movie-library'
			),
			'item_link_description'    => __(
				'A link to a person',
				'movie-library'
			),
		);

		return $labels;
	}

	/**
	 * Returns the meta keys to register for the CPT
	 *
	 * @return array
	 */
	public function get_meta_keys() {
		return array(
			'mlib-person-meta-full-name',
			'mlib-person-meta-basic-birth-date',
			'mlib-person-meta-basic-birth-place',
			'mlib-person-meta-social',
			'mlib-person-meta-social-twitter',
			'mlib-person-meta-social-facebook',
			'mlib-person-meta-social-instagram',
			'mlib-person-meta-social-web',
			'mlib-media-meta-img',
			'mlib-media-meta-video',
		);
	}

	/**
	 * Registers the Person Post Type.
	 *
	 * @return void
	 */
	public static function register_cpt() {
		new Person();
	}
}
