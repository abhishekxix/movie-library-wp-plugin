<?php
/**
 * Movie_Block: Movie block class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Block_Editor\Blocks\Movie_Block;

/**
 * Movie_Block class to provide render callback for the block.
 *
 * @since 0.1.0
 */
class Movie_Block {
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

		$movie_id = 0;
		// Check if movie id is valid integer and not 0.
		if ( isset( $attributes['movie'] ) &&
			is_int( $attributes['movie'] ) &&
			$attributes['movie'] > 0
		) {
			$movie_id = $attributes['movie'];
		}

		if ( 0 === $movie_id ) :
			?>
			<p>
				<?php
				esc_html_e( 'Invalid Movie ID', 'movie-library' );
				?>
			</p>
			<?php
			return ob_get_clean();
		endif;

		$movie = get_post( $movie_id );
		?>
		<div  <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
			<?php
			$release_date = get_post_meta(
				$movie_id,
				'mlib-movie-meta-basic-release-date',
				true
			);

			if ( empty( $release_date ) ) {
				$release_date = '';
			}

			$actors = get_post_meta(
				$movie_id,
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

			$directors = get_post_meta(
				$movie_id,
				'mlib-movie-meta-crew-director',
				true
			);

			$director_names = array();

			if ( ! empty( $directors ) ) {
				// Check if directors are in a JSON array.
				if ( '[' === $directors[0] ) {
					$directors = json_decode( $directors, true );
				} else {
					$directors = array();
				}
				$count = 0;

				if ( ! empty( $directors ) ) {
					foreach ( $directors as $director ) {
						if ( 2 === $count ) {
							// Only include first 2 directors.
							break;
						}
						$curr_director = get_post( $director, OBJECT, 'display' );

						// Check for existence of post.
						if ( ! empty( $curr_director ) ) {
							$director_names[] = $curr_director->post_title;
						}

						++$count;
					}

					if ( ! empty( $director_names ) ) {
						$director_names = implode( ', ', $director_names );
					}
				}
			} else {
				$director_names = '';
			}
			?>
			<div class="movie-library-single-movie">
				<a href="<?php the_permalink( $movie ); ?>">
					<?php
					if ( has_post_thumbnail( $movie_id ) ) :
						// phpcs:ignore
						echo get_the_post_thumbnail( $movie, 'post-thumbnail' );
					else :
						?>
						<img src="">
						<?php
					endif;
					?>

					<p>
						<?php
						esc_html_e( 'Title: ', 'movie-library' );
						// phpcs:ignore
						echo get_the_title($movie);
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
						echo esc_html( $director_names )
						?>
					</p>

					<p>
						<?php
						esc_html_e( 'Actors: ', 'movie-library' );
						echo esc_html( $actor_names )
						?>
					</p>
				</a>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
