<?php
/**
 * Person_Rules: The Rewrite rules class for Person post type.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Rewrite_API;

/**
 * Person_Rules class for adding Rewrite rules for mlib-person post type
 */
class Person_Rules extends Base {

	/**
	 * The permastruct name
	 *
	 * @var string
	 */
	protected const PERMASTRUCT_NAME = 'mlib-person';

	/**
	 * The post type slug
	 *
	 * @var string
	 */
	protected const POST_TYPE_SLUG = 'mlib-person';

	/**
	 * The custom tag for the taxonomy
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_TAG = '%career-taxonomy%';

	/**
	 * The taxonomy slug
	 *
	 * @var string
	 */
	protected const CUSTOM_TAXONOMY_SLUG = 'mlib-person-career';

	/**
	 * The base of the url
	 *
	 * @var string
	 */
	protected const URL_BASE = 'person';

	/**
	 * The term to substitute in case no terms are found
	 *
	 * @var string
	 */
	protected const DEFAULT_TERM = 'no-career';

	/**
	 * Initializes the Rewrite rules class
	 *
	 * @return void
	 * */
	public static function add_rules() {
		new Person_Rules();
	}
}
