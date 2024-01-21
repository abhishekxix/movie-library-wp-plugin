<?php //phpcs:ignore

define( 'MLIB_REST_NAMESPACE', 'movie-library/v1' );

/**
 * The Plugin file for Movie Library Plugin
 *
 * @var string $MLIB_PLUGIN_FILE
 */
define( 'MLIB_PLUGIN_FILE', __DIR__ . '/movie-library.php' );

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
	'https://mlib.local'
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
