<?php
/**
 * Movie_Manager: Class for Custom Movie manager User Role.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\User_Roles;

/**
 * Movie_Manager User Role class.
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\User_Roles\Base
 */
class Movie_Manager extends Base {

	/**
	 * The unique name for the role
	 *
	 * @var string
	 */
	protected const ROLE = 'movie-manager';

	/**
	 * Returns the Display name for the custom role
	 *
	 * @return string
	 */
	protected function get_display_name() {
		return __( 'Movie Manager', 'movie-library' );
	}

	/**
	 * Returns the Capabilities for the custom role
	 *
	 * @return array
	 */
	protected function get_capabilities() {
		$capabilities = array();
		$post_types   = array( 'mlib-movie', 'mlib-person' );

		foreach ( $post_types as $post_type ) {
			$post_type_object = get_post_type_object( $post_type );

			if ( false === isset( $post_type_object ) ) {
				continue;
			}

			$post_type_caps = (array) $post_type_object->cap;
			$capabilities   = array_merge(
				$capabilities,
				array_values( $post_type_caps )
			);
		}

		$taxonomies = array(
			'mlib-movie-genre',
			'mlib-movie-label',
			'mlib-movie-language',
			'mlib-movie-production-company',
			'mlib-movie-tag',
			'_mlib-movie-person',
			'mlib-person-career',
		);

		foreach ( $taxonomies as $tax ) {
			$tax_object = get_taxonomy( $tax );
			if ( false === $tax_object ) {
				continue;
			}

			$tax_caps     = (array) $tax_object->cap;
			$capabilities = array_merge(
				$capabilities,
				array_values( $tax_caps )
			);
		}

		$capabilities = array_merge(
			$capabilities,
			array( 'read', 'upload_files' )
		);

		$capabilities = array_unique( $capabilities );
		return $capabilities;
	}

	/**
	 * Initializes the Movie_Manager class
	 *
	 * @return void
	 */
	public static function add_role() {
		new Movie_Manager();
	}

	/**
	 * Removes the custom role
	 *
	 * @return void
	 */
	public static function remove_role() {
		remove_role( static::ROLE );
	}
}
