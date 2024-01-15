<?php
/**
 * Upcoming_TMDB: Upcoming Movies widget.
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Dashboard_Widgets;

/**
 * Upcoming Movies TMDB widget class
 *
 * @since 0.1.0
 * @see Movie_Library\Inc\Dashboard_Widgets\Base for more information.
 */
class Upcoming_TMDB extends Base {
	/**
	 * Widget ID
	 *
	 * @var string
	 */
	protected const ID = 'movie-library-upcoming-movies-dashboard-widget';

	/**
	 * TMDB API Endpoint
	 *
	 * @var string
	 */
	protected const ENDPOINT = '/upcoming';

	/**
	 * Key of the metadata to show next to the movie title
	 *
	 * @var string
	 */
	protected const MOVIE_META_KEY = 'release_date';

	/**
	 * TMDB API Base
	 *
	 * @var string
	 */
	private const TMDB_API_BASE = 'https://api.themoviedb.org/3/movie';

	/**
	 * Transient expiration time in seconds
	 *
	 * @var string
	 */
	protected const TRANSIENT_EXPIRATION_TIME = 60 * 60 * 4;

	/**
	 * Returns the name of the widget.
	 *
	 * @return string
	 */
	protected function get_widget_name() {
		return __( 'Upcoming movies (TMDB)', 'movie-library' );
	}

	/**
	 * Initializes the widget class.
	 *
	 * @return void
	 */
	public static function add_widget_to_dashboard() {
		new Upcoming_TMDB();
	}

	/**
	 * Returns an array of pairs with movie title and movie meta.
	 *
	 * @return array
	 */
	protected function get_movies_list() {
		$api_key = get_option( 'movie_library_tmdb_api_key', '' );

		if ( '' === $api_key ) :
			?>
			<strong>
			<?php
			esc_html_e(
				'Please provide a TMDB API key in the Movie Library settings.',
				'movie-library'
			);
			?>
			</strong>
			<?php
			return array();
		endif;

		$transient_key = static::ID . '_movies_list';

		$movies_list = get_transient( $transient_key );

		if ( true === empty( $movies_list ) ) {
			$api_url = self::TMDB_API_BASE . static::ENDPOINT;

			$api_url = add_query_arg(
				'api_key',
				$api_key,
				$api_url
			);

			$api_args = array(
				'redirection' => 10,
				'httpversion' => '1.1',
				'timeout'     => 30,

			);

			$response      = wp_remote_get( $api_url, $api_args );
			$response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $response_code ) :
				?>
				<pre>
				<?php
				esc_html_e(
					'Request failed.',
					'movie-library'
				);
				?>
				</pre>
				<?php
				return;
			endif;

			$response_body = json_decode(
				wp_remote_retrieve_body( $response ),
				true
			);

			$results = true === is_array(
				$response_body['results']
			) ? $response_body['results'] : array();

			$movies_list = array();
			foreach ( $results as $result ) {
				$movies_list[] = array(
					'title'                => $result['title'],
					static::MOVIE_META_KEY => $result[ static::MOVIE_META_KEY ],
				);
			}

			set_transient(
				$transient_key,
				$movies_list,
				static::TRANSIENT_EXPIRATION_TIME
			);
		}

		return $movies_list;
	}
}
