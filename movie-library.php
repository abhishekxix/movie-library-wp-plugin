<?php
/**
 * Movie Library main plugin file.
 *
 * @package Movie_Library
 */

/**
 * Plugin Name:     Movie Library
 * Description:     Transform your WordPress website into a Movie Library.
 * Author:          Abhishek Singh
 * Author URI:      https://abhishekxix.com
 * Text Domain:     movie-library
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Movie_Library
 */

define( 'MLIB_REST_NAMESPACE', 'movie-library/v1' );

/**
 * The Plugin file for Movie Library Plugin
 *
 * @var string $MLIB_PLUGIN_FILE
 */
define( 'MLIB_PLUGIN_FILE', __FILE__ );

/**
 * The Plugin directory for Movie Library Plugin
 *
 * @var string $MLIB_PLUGIN_DIR
 */
define( 'MLIB_PLUGIN_DIR', __DIR__ );

/**
 * The URI for the Assets
 *
 * @var string $MLIB_ASSETS_URI
 */
define(
	'MLIB_ASSETS_URI',
	plugins_url( '/assets', MLIB_PLUGIN_FILE )
);

/**
 * The Directory for the Assets
 *
 * @var string $MLIB_ASSETS_DIR
 */
define(
	'MLIB_ASSETS_DIR',
	MLIB_PLUGIN_DIR . '/assets'
);

/**
 * The Directory for the Block editor assets
 *
 * @var string $MLIB_EDITOR_ASSETS_DIR
 */
define(
	'MLIB_EDITOR_ASSETS_DIR',
	MLIB_PLUGIN_DIR . '/assets/build/block-editor'
);

require_once __DIR__ . '/inc/helpers/class-autoloader.php';
use Movie_Library\Inc\Helpers\AutoLoader;
use Movie_Library\Inc\Movie_Library;

$autoloader = new AutoLoader();
$autoloader->register();
$autoloader->add_namespace(
	'Movie_Library\Inc',
	__DIR__ . '/inc/classes'
);

Movie_Library::init();
