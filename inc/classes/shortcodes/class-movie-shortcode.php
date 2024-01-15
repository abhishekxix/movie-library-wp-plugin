<?php
/**
 * Movie_Shortcode: A shortcode class representing a list of movies.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Shortcodes;

use WP_Query;

/**
 * The [movie] shortcode class
 *
 * @see Movie_Library\Inc\Shortcodes\Base
 * @since 0.1.0
 */
class Movie_Shortcode extends Base {
	/**
	 * Tag name.
	 *
	 * @since 0.1.0
	 */
	protected const TAG = 'movie';

	/**
	 * Shortcode callback to render the content.
	 *
	 * @param array       $atts Shortcode attributes.
	 * @param string|null $content Shortcode content.
	 * @param string      $tag Shortcode tag.
	 * @return string
	 */
	public function shortcode_callback(
		$atts = array(),
		$content = null,
		$tag = ''
	) {
		$content = '';
		$atts    = shortcode_atts(
			array(
				'person'   => '',
				'genre'    => '',
				'label'    => '',
				'language' => '',
			),
			$atts,
			'movie',
		);

		// Prepares the args for query.
		$query_args = array(
			'post_type'      => 'mlib-movie',
			'posts_per_page' => -1,
			//phpcs:ignore
			'tax_query'      => array(),
		);

		if ( false === empty( $atts['person'] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => '_mlib-movie-person',
				'field'    => false !== strpos( $atts['person'], '-' ) ? 'slug' : 'name',
				'terms'    => sanitize_title(
					wp_unslash( $atts['person'] ),
				),
			);
		}

		if ( false === empty( $atts['genre'] ) ) {
			$term_value = $atts['genre'];
			$field      = (
				is_numeric( $term_value ) ?
				'term-id' : (
					false !== strpos( $atts['genre'], '-' ) ?
					'slug' :
					'name'
				)
			);

			$query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-genre',
				'field'    => $field,
				'terms'    => sanitize_title(
					wp_unslash(
						$atts['genre']
					)
				),
			);
		}

		if ( false === empty( $atts['label'] ) ) {
			$term_value = $atts['label'];
			$field      = (
				is_numeric( $term_value ) ?
				'term-id' : (
					false !== strpos( $atts['label'], '-' ) ?
					'slug' :
					'name'
				)
			);

			$query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-label',
				'field'    => $field,
				'terms'    => sanitize_title(
					wp_unslash(
						$atts['label']
					)
				),
			);
		}

		if ( false === empty( $atts['language'] ) ) {
			$term_value = $atts['language'];
			$field      = (
				is_numeric( $term_value ) ?
				'term-id' : (
					false !== strpos( $atts['language'], '-' ) ?
					'slug' :
					'name'
				)
			);

			$query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-movie-language',
				'field'    => $field,
				'terms'    => sanitize_title(
					wp_unslash(
						$atts['language']
					)
				),
			);
		}

		// Query fired.
		$movie_query = new WP_Query( $query_args );

		if ( $movie_query->have_posts() ) {
			$content .= '<ul class="movie_shortcode_list">';
			while ( $movie_query->have_posts() ) {
				$movie_query->the_post();

				// Setup data.
				$movie_title  = get_the_title();
				$movie_poster = get_the_post_thumbnail_url();
				$release_date = get_post_meta( get_the_ID(), 'mlib-movie-meta-basic-release-date', true );
				$directors    = json_decode(
					get_post_meta(
						get_the_ID(),
						'mlib-movie-meta-crew-director',
						true
					)
				) ?? array();

				if ( false === $directors ) {
					$directors = array();
				}

				$directors      = array_map( 'intval', $directors );
				$director_names = array();

				foreach ( $directors as $director ) {
					$director_names[] = get_the_title( $director );
				}

				$actors = json_decode(
					get_post_meta(
						get_the_ID(),
						'mlib-movie-meta-crew-actor',
						true
					)
				) ?? array();
				if ( false === $actors ) {
					$actors = array();
				}

				$actors      = array_map( 'intval', $actors );
				$actor_names = array();
				foreach ( $actors as $actor ) {
					$actor_names[] = get_the_title( $actor );
					if ( count( $actor_names ) > 2 ) {
						break;
					}
				}

				$translated_text = array(
					esc_html__(
						'Title:',
						'movie-library'
					),
					esc_html__(
						'Release date:',
						'movie-library'
					),
					esc_html__(
						'Directors:',
						'movie-library'
					),
					esc_html__(
						'Actors:',
						'movie-library'
					),
				);

				$director_names = implode( ', ', $director_names );
				$actor_names    = implode( ', ', $actor_names );

				// Start rendering.
				$content .= <<<SHORTCODE_CONTENT
					<li>
						<strong>{$translated_text[0]}</strong> {$movie_title}
						<img src="{$movie_poster}"><br>
						<strong>{$translated_text[1]}</strong> {$release_date} <br>
						<strong>{$translated_text[2]}</strong> {$director_names} <br>
						<strong>{$translated_text[3]}</strong> {$actor_names} <br>
					</li>
				SHORTCODE_CONTENT;
			}
			$content .= '</ul>';
		}
		return $content;
	}

	/**
	 * Adds the [movie] shortcode
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function add_shortcode() {
		new Movie_Shortcode();
	}
}
