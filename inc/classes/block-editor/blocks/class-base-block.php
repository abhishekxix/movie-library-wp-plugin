<?php
/**
 * Base_Block: Abstract Base block class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor\Blocks;

/**
 * Base_Block class to provide render callback for the block.
 *
 * @since 0.1.0
 */
abstract class Base_Block {
	/**
	 * This function is called when the block is being rendered on the front end of the site
	 *
	 * @param array     $attributes     The array of attributes for this block.
	 * @param string    $content        Rendered block output. ie. <InnerBlocks.Content />.
	 * @param \WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
	 *
	 * @return string
	 */
	abstract public function render_callback( $attributes, $content, $block_instance );
}
