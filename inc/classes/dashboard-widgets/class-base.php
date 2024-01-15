<?php
/**
 * Base: A Dashboard widget base class for movies list
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Dashboard_Widgets;

/**
 * Custom Dashboard widget abstract base class for movies list
 *
 * @since 0.1.0
 * @see wp_add_dashboard_widget() for more information.
 * @link https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/
 */
abstract class Base {
	/**
	 * Widget ID
	 *
	 * @var string
	 */
	protected const ID = '';


	/**
	 * Key of the metadata to show next to the movie title
	 *
	 * @var string
	 */
	protected const MOVIE_META_KEY = '';


	/**
	 * Constructor function.
	 */
	protected function __construct() {
		add_action(
			'wp_dashboard_setup',
			array( $this, 'add_dashboard_widget' )
		);
	}

	/**
	 * Adds the Dashboard widget.
	 *
	 * @return void
	 */
	public function add_dashboard_widget() {
		$widget_name = $this->get_widget_name();
		wp_add_dashboard_widget(
			static::ID,
			$widget_name,
			array( $this, 'widget_callback' )
		);
	}

	/**
	 * Renders the widget
	 *
	 * @return void
	 */
	public function widget_callback() {
		$movies_list = $this->get_movies_list();
		?>
		<ul class="movie-library-dashboard-list">
			<?php foreach ( $movies_list as $movie ) : ?>
				<li class="movie-library-row">
					<span><?php echo esc_html( $movie['title'] ); ?></span>
					<span>
						<?php
						echo esc_html(
							$movie[ static::MOVIE_META_KEY ]
						);
						?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php
	}

	/**
	 * Returns the name of the widget to register
	 *
	 * @return string
	 */
	abstract protected function get_widget_name();

	/**
	 * Returns an array of pairs with movie title and movie meta.
	 *
	 * @return array
	 */
	abstract protected function get_movies_list();
}
