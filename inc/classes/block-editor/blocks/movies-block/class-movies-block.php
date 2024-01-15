<?php
/**
 * Movies_Block: Movies block class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor\Blocks\Movies_Block;

use WP_Query;

/**
 * Movies_Block class to provide render callback for the block.
 *
 * @since 0.1.0
 */
class Movies_Block {
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
		$movies_query_args = array(
			'post_type'      => 'mlib-movie',
			'posts_per_page' => 5,
			// phpcs:ignore
			'meta_query'     => array(),
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
			$movies_query_args['posts_per_page'] = $attributes['count'];
		}

		// Name of the director to be displayed.
		$director_name = '';

		if ( isset( $attributes['director'] ) &&
			is_int( $attributes['director'] ) &&
			$attributes['director'] > 0
		) {

			// Use LIKE because the value of the meta key could be a JSON array.
			$movies_query_args['meta_query'][] = array(
				'key'     => 'mlib-movie-meta-crew-director',
				'value'   => $attributes['director'],
				'compare' => 'LIKE',
			);

			$director = get_post( $attributes['director'], OBJECT, 'display' );

			if ( ! empty( $director ) ) {
				$director_name = $director->post_title;
			}
		}

		// Prepare the tax_query.
		if ( isset( $attributes['genre'] ) &&
			is_int( $attributes['genre'] ) &&
			$attributes['genre'] > 0
		) {

			$movies_query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-genre',
				'terms'    => $attributes['genre'],
			);
		}

		if ( isset( $attributes['label'] ) &&
			is_int( $attributes['label'] ) &&
			$attributes['label'] > 0
		) {

			$movies_query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-label',
				'terms'    => $attributes['label'],
			);
		}

		if ( isset( $attributes['language'] ) &&
			is_int( $attributes['language'] ) &&
			$attributes['language'] > 0
		) {

			$movies_query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-language',
				'terms'    => $attributes['language'],
			);
		}

		$movies_query = new WP_Query( $movies_query_args );
		?>
			<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>

				<?php
				if ( $movies_query->have_posts() ) :
					?>
					<ul class="movie-library-movies-list">
						<?php
						while ( $movies_query->have_posts() ) :
							$movies_query->the_post();

							$release_date = get_post_meta(
								get_the_ID(),
								'mlib-movie-meta-basic-release-date',
								true
							);

							if ( empty( $release_date ) ) {
								$release_date = '';
							}

							$actors = get_post_meta(
								get_the_ID(),
								'mlib-movie-meta-crew-actor',
								true
							);

							$actor_names = array();

							if ( ! empty( $actors ) ) {
								// Check if actors are in a JSON array.
								if ( '[' === $actors[0] ) {
									$actors = json_decode( $actors, true );
								} else {
									$actors = array();
								}
								$count = 0;

								if ( ! empty( $actors ) ) {
									foreach ( $actors as $actor ) {
										if ( 2 === $count ) {
											// Only include first 2 actors.
											break;
										}
										$curr_actor = get_post( $actor, OBJECT, 'display' );

										// Check for existence of post.
										if ( ! empty( $curr_actor ) ) {
											$actor_names[] = $curr_actor->post_title;
										}

										++$count;
									}

									if ( ! empty( $actor_names ) ) {
										$actor_names = implode( ', ', $actor_names );
									}
								}
							} else {
								$actor_names = '';
							}

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
										esc_html_e( 'Title: ', 'movie-library' );
										the_title();
										?>
									</p>

									<p>
										<?php
										esc_html_e( 'Release Date: ', 'movie-library' );
										echo esc_html( $release_date )
										?>
									</p>

									<p>
										<?php
										esc_html_e( 'Director: ', 'movie-library' );
										echo esc_html( $director_name )
										?>
									</p>

									<p>
										<?php
										esc_html_e( 'Actors: ', 'movie-library' );
										echo esc_html( $actor_names )
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
