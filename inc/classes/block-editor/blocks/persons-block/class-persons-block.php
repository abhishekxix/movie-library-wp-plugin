<?php
/**
 * Persons_Block: Persons block class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor\Blocks\Persons_Block;

use WP_Query;

/**
 * Persons_Block class to provide render callback for the block.
 *
 * @since 0.1.0
 */
class Persons_Block {
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
		$persons_query_args = array(
			'post_type'      => 'mlib-person',
			'posts_per_page' => 5,
			// phpcs:ignore
			'tax_query'      => array(),
			'post_status'    => array( 'publish' ),
		);

		// Check if count is valid integer between 0 and 10.
		if ( isset( $attributes['count'] ) &&
			is_int( $attributes['count'] ) &&
			$attributes['count'] > 0 &&
			$attributes['count'] <= 10
		) {
			$persons_query_args['posts_per_page'] = $attributes['count'];
		}

		$career_name = '';

		// Prepare the tax_query.
		if ( isset( $attributes['career'] ) &&
			is_int( $attributes['career'] ) &&
			$attributes['career'] > 0
		) {

			$persons_query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-person-career',
				'terms'    => $attributes['career'],
			);

			$term_object = get_term(
				$attributes['career'],
				'mlib-person-career',
				OBJECT,
				'display'
			);

			if ( ! empty( $term_object ) && ! is_wp_error( $term_object ) ) {
				$career_name = $term_object->name;
			}
		}

		$persons_query = new WP_Query( $persons_query_args );
		?>
			<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>

				<?php
				if ( $persons_query->have_posts() ) :
					?>
					<ul class="movie-library-persons-list">
						<?php
						while ( $persons_query->have_posts() ) :
							$persons_query->the_post();
							?>
							<li>
								<a href="<?php the_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail();
									else :
										?>
										<img src="">
										<?php
									endif;
									?>

									<p>
										<?php
										esc_html_e( 'Name: ', 'movie-library' );
										the_title();
										?>
									</p>
									<p>
										<?php
										esc_html_e( 'Career: ', 'movie-library' );
										echo esc_html( $career_name )
										?>
									</p>
								</a>
							</li>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
					<?php
				endif;
				?>

			</div> 
		<?php
		return ob_get_clean();
	}
}
