<?php
/**
 * Person_Shortcode: A shortcode class representing a list of Persons.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Shortcodes;

use WP_Query;

/**
 * The [person] shortcode class
 *
 * @see Movie_Library\Inc\Shortcodes\Base
 * @since 0.1.0
 */
class Person_Shortcode extends Base {
	/**
	 * Tag name.
	 *
	 * @since 0.1.0
	 */
	protected const TAG = 'person';

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
				'career' => '',
			),
			$atts,
			'person',
		);

		// Prepares the args for query.
		$query_args = array(
			'post_type'      => 'mlib-person',
			'posts_per_page' => -1,
			//phpcs:ignore
			'tax_query'      => array(),
		);

		if ( false === empty( $atts['career'] ) ) {
			$term_value = $atts['career'];
			$field      = (
				is_numeric( $term_value ) ?
				'term-id' : (
					false !== strpos( $atts['career'], '-' ) ?
					'slug' :
					'name'
				)
			);

			$query_args['tax_query'][] = array(
				'taxonomy' => 'mlib-person-career',
				'field'    => $field,
				'terms'    => sanitize_title(
					wp_unslash(
						$atts['career']
					)
				),
			);
		}

		// Query fired.
		$person_query = new WP_Query( $query_args );

		if ( $person_query->have_posts() ) {
			$content .= '<ul class="person_shortcode_list">';
			while ( $person_query->have_posts() ) {
				$person_query->the_post();

				// Setup data.
				$person_name     = get_the_title();
				$profile_picture = get_the_post_thumbnail_url();
				$career_terms    = get_the_terms( get_the_ID(), 'mlib-person-career' );

				$career = array();

				foreach ( $career_terms as $career_term ) {
					$career[] = $career_term->name;
				}

				$profile_picture    = esc_attr( $profile_picture );
				$translated_strings = array(
					esc_html__( 'Name:', 'movie-library' ),
					esc_html__( 'Career:', 'movie-library' ),
				);

				$career = true === isset( $career ) ? implode( ', ', $career ) : 'N/A';

				// Start rendering.
				$content .= <<<SHORTCODE_CONTENT
					<li>
						<strong>{$translated_strings[0]}</strong> {$person_name} <br>
						<img src="{$profile_picture}">
						<strong>{$translated_strings[1]}</strong> {$career} <br>
					</li>
				SHORTCODE_CONTENT;
			}
			$content .= '</ul>';
		}
		return $content;
	}

	/**
	 * Adds the [person] shortcode
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function add_shortcode() {
		new Person_Shortcode();
	}
}
