<?php
/**
 * Base: The Rewrite rules abstract base class.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Rewrite_API;

/**
 * Base class for adding Rewrite rules for custom post type
 */
abstract class Base {

	/**
	 * The permastruct name
	 *
	 * @var string
	 */
	protected const PERMASTRUCT_NAME = '';

	/**
	 * The post type slug
	 *
	 * @var string
	 */
	protected const POST_TYPE_SLUG = '';

	/**
	 * The custom tag for the taxonomy
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_TAG = '';

	/**
	 * The taxonomy slug
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_SLUG = '';

	/**
	 * The base of the url
	 *
	 * @var string
	 */
	protected const URL_BASE = '';

	/**
	 * The term to substitute in case no terms are found
	 *
	 * @var string
	 */
	protected const DEFAULT_TERM = '';

	/**
	 * Constructor function
	 */
	public function __construct() {
		add_action(
			'init',
			array( $this, 'add_permastruct' ),
			11
		);

		add_filter(
			'post_type_link',
			array( $this, 'filter_post_type_link' ),
			10,
			2
		);
	}

	/**
	 * Adds the permalink structure for the post type
	 *
	 * @return void
	 */
	public function add_permastruct() {
		global $wp_rewrite;

		$ps_args = $wp_rewrite->extra_permastructs[ static::PERMASTRUCT_NAME ];

		remove_permastruct( static::PERMASTRUCT_NAME );

		unset( $ps_args['struct'] );
		$ps_args['with_front'] = false;

		$post_type_slug = static::POST_TYPE_SLUG;
		$tax_slug       = static::CUSTOM_TAXONOMY_SLUG;

		// Adds the tag for the taxonomy. For instance %genre-taxonomy% or %career-taxonomy%.
		add_rewrite_tag(
			static::CUSTOM_TAXONOMY_TAG,
			'([^ /]+)',
			"post_type={$post_type_slug}&{$tax_slug}="
		);

		$tax_tag  = static::CUSTOM_TAXONOMY_TAG;
		$url_base = static::URL_BASE;

		// Adds the permastructure. For instance /movie/%genre-taxononmy%/%postname%-%post_id%.
		add_permastruct(
			static::PERMASTRUCT_NAME,
			"/{$url_base}/{$tax_tag}/%postname%-%post_id%",
			$ps_args
		);
	}

	/**
	 * Filters the permalink based on the permastruct
	 *
	 * @param string   $post_link The permalink for the post.
	 * @param \WP_Post $post The post object.
	 * @return string
	 */
	public function filter_post_type_link( $post_link, $post ) {
		if ( static::POST_TYPE_SLUG !== $post->post_type ) {
			return $post_link;
		}

		$terms     = wp_get_post_terms(
			$post->ID,
			static::CUSTOM_TAXONOMY_SLUG
		);
		$term_slug = '';

		if ( false === is_wp_error( $terms ) && false === empty( $terms ) ) {
			// Select the first term in the terms list.
			$terms = wp_list_sort(
				$terms,
				array( 'term_id' => 'ASC' )
			);

			if ( false === empty( $terms ) && is_object( $terms[0] ) ) {
				$term_slug = $terms[0]->slug;
			}
		} else {
			$term_slug = static::DEFAULT_TERM;
		}

		// Replace the tags for their values.
		$post_link = str_replace(
			array( static::CUSTOM_TAXONOMY_TAG, '%postname%', '%post_id%' ),
			array( $term_slug, $post->post_name, $post->ID ),
			$post_link
		);

		return $post_link;
	}
}
