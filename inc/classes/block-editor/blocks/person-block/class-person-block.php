<?php
/**
 * Person_Block: Person block class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor\Blocks\Person_Block;

/**
 * Person_Block class to provide render callback for the block.
 *
 * @since 0.1.0
 */
class Person_Block {
	/**
	 * This function is called when the block is being rendered on the front end of the site
	 *
	 * @param array     $attributes     The array of attributes for this block.
	 * @param string    $content        Rendered block output. ie. <InnerBlocks.Content />.
	 * @param \WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
	 *
	 * @return string
	 */
	public function render_callback( $attributes, $content, $block_instance ) {
		ob_start();

		$person_id = 0;
		// Check if person id is valid integer and not 0.
		if ( isset( $attributes['person'] ) &&
			is_int( $attributes['person'] ) &&
			$attributes['person'] > 0
		) {
			$person_id = $attributes['person'];
		}

		if ( 0 === $person_id ) :
			?>
			<p>
				<?php
				esc_html_e( 'Invalid Person ID', 'movie-library' );
				?>
			</p>
			<?php
			return ob_get_clean();
		endif;

		$person       = get_post( $person_id );
		$career_names = '';

		$person_career_terms = wp_get_post_terms(
			$person_id,
			'mlib-person-career'
		);

		if ( ! is_wp_error( $person_career_terms ) &&
			! empty( $person_career_terms )
		) {
			$person_career_names = wp_list_pluck(
				$person_career_terms,
				'name',
			);

			$career_names = implode( ', ', $person_career_names );
		}
		?>
		<div  <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
			<div class="movie-library-single-person">
				<a href="<?php the_permalink( $person ); ?>">
					<?php
					if ( has_post_thumbnail( $person_id ) ) :
						// phpcs:ignore
						echo get_the_post_thumbnail( $person, 'post-thumbnail' );
					else :
						?>
						<img src="">
						<?php
					endif;
					?>

					<p>
						<?php
						esc_html_e( 'Name: ', 'movie-library' );
						// phpcs:ignore
						echo get_the_title($person);
						?>
					</p>

					<p>
						<?php
						esc_html_e( 'Career: ', 'movie-library' );
						echo esc_html( $career_names )
						?>
					</p>
				</a>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
