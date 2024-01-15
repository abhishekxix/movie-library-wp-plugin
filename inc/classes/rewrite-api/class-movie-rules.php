<?php
/**
 * Movie_Rules: The Rewrite rules class for Movie post type.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Rewrite_API;

/**
 * Movie_Rules class for adding Rewrite rules for mlib-movie post type
 */
class Movie_Rules extends Base {

	/**
	 * The permastruct name
	 *
	 * @var string
	 */
	protected const PERMASTRUCT_NAME = 'mlib-movie';

	/**
	 * The post type slug
	 *
	 * @var string
	 */
	protected const POST_TYPE_SLUG = 'mlib-movie';

	/**
	 * The custom tag for the taxonomy
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_TAG = '%genre-taxonomy%';

	/**
	 * The taxonomy slug
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_SLUG = 'mlib-movie-genre';

	/**
	 * The base of the url
	 *
	 * @var string
	 */
	protected const URL_BASE = 'movie';

	/**
	 * The term to substitute in case no terms are found
	 *
	 * @var string
	 */
	protected const DEFAULT_TERM = 'generic';

	/**
	 * Initializes the Rewrite rules class
	 *
	 * @return void
	 * */
	public static function add_rules() {
		new Movie_Rules();
	}
}
