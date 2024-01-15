<?php
/**
 * Block_Editor: Block editor class to register blocks
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor;

use Movie_Library\Inc\Block_Editor\Blocks\Movie_Block\Movie_Block;
use Movie_Library\Inc\Block_Editor\Blocks\Movies_Block\Movies_Block;

use Movie_Library\Inc\Block_Editor\Blocks\Person_Block\Person_Block;
use Movie_Library\Inc\Block_Editor\Blocks\Persons_Block\Persons_Block;

/**
 * Block_Editor class to register blocks
 * Registers the blocks for the movie-library plugin.
 *
 * @since 0.1.0
 */
final class Block_Editor {
	/**
	 * Constructor function
	 *
	 * This function is kept private so that this class can only be instantiated using the static `init` method.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	/**
	 * Registers the Gutenberg blocks for the plugin
	 *
	 * @return void
	 */
	public function register_blocks() {
		register_block_type(
			MLIB_EDITOR_ASSETS_DIR . '/blocks/movies-block',
			array(
				'render_callback' => array( new Movies_Block(), 'render_callback' ),
			)
		);

		register_block_type(
			MLIB_EDITOR_ASSETS_DIR . '/blocks/movie-block',
			array(
				'render_callback' => array( new Movie_Block(), 'render_callback' ),
			)
		);

		register_block_type(
			MLIB_EDITOR_ASSETS_DIR . '/blocks/persons-block',
			array(
				'render_callback' => array( new Persons_Block(), 'render_callback' ),
			)
		);

		register_block_type(
			MLIB_EDITOR_ASSETS_DIR . '/blocks/person-block',
			array(
				'render_callback' => array( new Person_Block(), 'render_callback' ),
			)
		);
	}

	/**
	 * Initializes the Block editor assets
	 *
	 * @return void
	 */
	public static function init() {
		new Block_Editor();
	}
}
