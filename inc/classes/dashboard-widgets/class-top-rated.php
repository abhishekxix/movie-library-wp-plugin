<?php
/**
 * Top_Rated: Top_Rated Movies widget.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Dashboard_Widgets;

/**
 * Top_Rated Movies from own site widget class
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Dashboard_Widgets\Base for more information.
 */
class Top_Rated extends Base {
	/**
	 * Widget ID
	 *
	 * @var string
	 */
	protected const ID = 'movie-library-top-rated-movies-native-dashboard-widget';

	/**
	 * Key of the metadata to show next to the movie title
	 *
	 * @var string
	 */
	protected const MOVIE_META_KEY = 'mlib-movie-meta-basic-rating';

	/**
	 * Returns the name of the widget.
	 *
	 * @return string
	 */
	protected function get_widget_name() {
		return __( 'Top Rated movies', 'movie-library' );
	}

	/**
	 * Returns an array of pairs with movie title and movie meta.
	 *
	 * @return array
	 */
	protected function get_movies_list() {
		$query_args = array(
			'post_type'      => 'mlib-movie',
			'posts_per_page' => 20,
			//phpcs:ignore
			'tax_query' => array(
				array(
					'taxonomy' => 'mlib-movie-label',
					'field'    => 'slug',
					'terms'    => 'top-rated',
				),
			),
			//phpcs:ignore
			'meta_query'     => array(
				array(
					'key'     => static::MOVIE_META_KEY,
					'compare' => 'EXISTS',
				),
			),
			'orderby'        => array(
				static::MOVIE_META_KEY => 'DESC',
			),
		);

		$movies_list  = array();
		$query_result = get_posts( $query_args );

		if ( false === empty( $query_result ) ) {
			foreach ( $query_result as $single_movie ) {
				$movies_list[] = array(
					'title'                => get_the_title( $single_movie ),
					static::MOVIE_META_KEY => get_post_meta(
						$single_movie->ID,
						static::MOVIE_META_KEY,
						true
					),
				);
			}
		}

		return $movies_list;
	}

	/**
	 * Initializes the widget class.
	 *
	 * @return void
	 */
	public static function add_widget_to_dashboard() {
		new Top_Rated();
	}
}
