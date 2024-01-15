<?php
/**
 * Base class for Custom User Role.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\User_Roles;

/**
 * Custom User Role base class.
 *
 * @since 0.1.0
 * @see add_role() for more details.
 * @link https://developer.wordpress.org/reference/functions/add_role/
 */
abstract class Base {

	/**
	 * The unique name for the role
	 *
	 * @var string
	 */
	protected const ROLE = '';

	/**
	 * Constructor function
	 */
	protected function __construct() {
		$this->add_custom_role();
	}

	/**
	 * Adds custom role
	 *
	 * @return void
	 */
	public function add_custom_role() {
		$display_name = $this->get_display_name();
		$capabilities = $this->get_capabilities();

		$admin_role = get_role( 'administrator' );

		if ( true === isset( $admin_role ) ) {
			foreach ( $capabilities as $cap ) {
				$admin_role->add_cap( $cap );
			}
		}

		$capabilities = array_fill_keys( $capabilities, true );

		add_role( static::ROLE, $display_name, $capabilities );
	}

	/**
	 * Returns the Display name for the custom role
	 *
	 * @return string
	 */
	abstract protected function get_display_name();

	/**
	 * Returns the Capabilities for the custom role
	 *
	 * @return array
	 */
	abstract protected function get_capabilities();
}
