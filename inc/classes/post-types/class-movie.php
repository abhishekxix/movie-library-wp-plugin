<?php
/**
 * Movie: Movie custom post type
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Post_Types;

/**
 * Movie post type class.
 *
 * Represents the following post type:
 *
 *       Movie (mlib-movie)
 *       - Supports: title, editor, excerpt, thumbnail, author, comment
 *       - Movie information mapping with post fields.
 *       - Title (Post Title)
 *       - Description / Synopsis (Post Excerpt)
 *       - Plot (Post Content)
 *       - Movie Poster (Featured Image)
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Post_Types\Base
 * */
class Movie extends Base {
	/**
	 * Post type slug.
	 *
	 * @since 0.1.0
	 */
	protected const SLUG = 'mlib-movie';

	/**
	 * Returns the arguments for post type registration.
	 *
	 * @return array
	 */
	protected function get_cpt_args() {
		$labels = $this->get_cpt_labels();

		$args = array(
			'label'           => __(
				'Movies',
				'movie-library'
			),
			'labels'          => $labels,
			'supports'        => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'author',
				'comments',
				'custom-fields',
			),
			'show_in_rest'    => true,
			'public'          => true,
			'description'     => __(
				'A Custom Post type that represents a movie',
				'movie-library'
			),
			'menu_icon'       => 'dashicons-video-alt',
			'menu_position'   => 5,
			'has_archive'     => true,
			'capability_type' => 'mlib-movie',
			'map_meta_cap'    => true,
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
				'Movies',
				'Post type general name',
				'movie-library'
			),
			'singular_name'            => _x(
				'Movie',
				'Post type singular name',
				'movie-library'
			),
			'add_new'                  => _x(
				'Add New',
				'movie',
				'movie-library'
			),
			'add_new_item'             => __(
				'Add New Movie',
				'movie-library'
			),
			'edit_item'                => __(
				'Edit Movie',
				'movie-library'
			),
			'new_item'                 => __(
				'New Movie',
				'movie-library'
			),
			'view_item'                => __(
				'View Movie',
				'movie-library'
			),
			'view_items'               => __(
				'View Movies',
				'movie-library'
			),
			'search_items'             => __(
				'Search Movies',
				'movie-library'
			),
			'not_found'                => __(
				'No movies found',
				'movie-library'
			),
			'not_found_in_trash'       => __(
				'No movies found in trash',
				'movie-library'
			),
			'all_items'                => __(
				'All Movies',
				'movie-library'
			),
			'archives'                 => __(
				'Movie Archives',
				'movie-library'
			),
			'attributes'               => __(
				'Movie Attributes',
				'movie-library'
			),
			'insert_into_item'         => __(
				'Insert into movie',
				'movie-library'
			),
			'uploaded_to_this_item'    => __(
				'Uploaded to this movie',
				'movie-library'
			),
			'featured_image'           => __(
				'Movie Poster',
				'movie-library'
			),
			'set_featured_image'       => __(
				'Set Movie Poster',
				'movie-library'
			),
			'remove_featured_image'    => __(
				'Remove Movie Poster',
				'movie-library'
			),
			'use_featured_image'       => __(
				'Use as Movie Poster',
				'movie-library'
			),
			'filter_items_list'        => __(
				'Filter movies list',
				'movie-library'
			),
			'items_list_navigation'    => __(
				'Movies list navigation',
				'movie-library'
			),
			'items_list'               => __(
				'Movies list',
				'movie-library'
			),
			'item_published'           => __(
				'Movie published',
				'movie-library'
			),
			'item_published_privately' => __(
				'Movie published privately',
				'movie-library'
			),
			'item_reverted_to_draft'   => __(
				'Movie reverted to draft',
				'movie-library'
			),
			'item_scheduled'           => __(
				'Movie scheduled',
				'movie-library'
			),
			'item_updated'             => __(
				'Movie udpated',
				'movie-library'
			),
			'item_link'                => __(
				'Movie link',
				'movie-library'
			),
			'item_link_description'    => __(
				'A link to a movie',
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
			'mlib-movie-meta-basic-rating',
			'mlib-movie-meta-basic-runtime',
			'mlib-movie-meta-basic-release-date',
			'mlib-movie-meta-basic-content-rating',
			'mlib-movie-meta-crew-director',
			'mlib-movie-meta-crew-producer',
			'mlib-movie-meta-crew-writer',
			'mlib-movie-meta-crew-actor',
			'mlib-movie-meta-carousel-poster',
			'mlib-media-meta-img',
			'mlib-media-meta-video',
		);
	}

	/**
	 * Registers the Movie Post Type.
	 *
	 * @return void
	 */
	public static function register_cpt() {
		new Movie();
	}
}
