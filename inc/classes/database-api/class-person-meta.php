<?php
/**
 * Person_Meta: A metadata handler class using custom DB tables for mlib-person
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Database_API;

/**
 * Person_Meta: A class for dealing with metadata for mlib-person post type.
 */
class Person_Meta {

	/**
	 * Adds database table for the mlib-personmeta
	 *
	 * @return void
	 */
	public static function add_table() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix . 'mlib_personmeta';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
			`mlib_person_id` bigint(20) NOT NULL DEFAULT '0',
			`meta_key` varchar(255) DEFAULT NULL,
			`meta_value` longtext,
			PRIMARY KEY (`meta_id`),
			KEY `mlib_person_id` (`mlib_person_id`),
			KEY `meta_key` (`meta_key`) 
			) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		self::register_meta_table_name();
	}

	/**
	 * Returns the metadata value
	 *
	 * @param int     $person_id The ID of the post.
	 * @param string  $meta_key The key for the metadata.
	 * @param boolean $single Whether or not to get a single value instead of an array.
	 * @return mixed An array of values if `$single` is false.
	 *               The value of the meta field if `$single` is true.
	 *               False for an invalid `$person_id` (non-numeric, zero, or negative value),
	 *               or if `$meta_type` is not specified.
	 *               An empty string if a valid but non-existing person_id ID is passed.
	 */
	public static function get_person_meta( $person_id, $meta_key, $single = false ) {
		return get_metadata(
			'mlib_person',
			$person_id,
			$meta_key,
			$single
		);
	}

	/**
	 * Adds the specified meta.
	 *
	 * @param int     $person_id Person ID.
	 * @param string  $meta_key The key for the metadata.
	 * @param mixed   $meta_value The value for metadata.
	 * @param boolean $unique Whether or not the same key should be added.
	 * @return int|false Meta ID on success, false on failure.
	 */
	public static function add_person_meta( $person_id, $meta_key, $meta_value, $unique = false ) {
		$the_person_id = wp_is_post_revision( $person_id );
		if ( $the_person_id ) {
			$person_id = $the_person_id;
		}

		return add_metadata(
			'mlib_person',
			$person_id,
			$meta_key,
			$meta_value,
			$unique
		);
	}

	/**
	 * Deletes the metadata for the person.
	 *
	 * @param int    $person_id Person ID.
	 * @param string $meta_key The key for the metadata.
	 * @param mixed  $meta_value The value for metadata for which the row will be removed.
	 * @return bool True on success, false on failure.
	 */
	public static function delete_person_meta( $person_id, $meta_key, $meta_value = '' ) {
		$the_person_id = wp_is_post_revision( $person_id );
		if ( $the_person_id ) {
			$person_id = $the_person_id;
		}

		return delete_metadata(
			'mlib_person',
			$person_id,
			$meta_key,
			$meta_value
		);
	}

	/**
	 * Updates the Metadata for the person
	 *
	 * @param int    $person_id Person ID.
	 * @param string $meta_key The key for the metadata.
	 * @param mixed  $meta_value The value for metadata.
	 * @param string $prev_value The previous value that will be checked for update.
	 * @return int|bool Meta ID if the key didn't exist, false on failure or if the value passed is the same as in the DB.
	 */
	public static function update_person_meta( $person_id, $meta_key, $meta_value, $prev_value = '' ) {
		$the_person_id = wp_is_post_revision( $person_id );
		if ( $the_person_id ) {
			$person_id = $the_person_id;
		}

		return update_metadata(
			'mlib_person',
			$person_id,
			$meta_key,
			$meta_value,
			$prev_value
		);
	}

	/**
	 * Registers the meta table name to $wpdb object
	 *
	 * @return void
	 */
	public static function register_meta_table_name() {
		global $wpdb;

		$meta_name        = 'mlib_personmeta';
		$wpdb->$meta_name = $wpdb->prefix . 'mlib_personmeta';
	}
}
