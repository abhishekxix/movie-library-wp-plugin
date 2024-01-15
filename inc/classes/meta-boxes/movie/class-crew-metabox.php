<?php
/**
 * Crew_Metabox: Crew Metabox class
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\Meta_Boxes\Movie;

use Movie_Library\Inc\Meta_Boxes\Base;
use WP_Post;
use WP_Query;

/**
 * Crew_Metabox class
 *
 * A class representing the Crew metabox in mlib-movie
 *
 * @since 0.1.0
 * @see use Movie_Library\Inc\Meta_Boxes\Base;
 */
class Crew_Metabox extends Base {
	/**
	 * Metabox ID
	 *
	 * @since 0.1.0
	 */
	protected const ID = 'mlib-movie-meta-crew';

	/**
	 * Metabox TITLE
	 *
	 * @since 0.1.0
	 */
	protected const TITLE = 'Crew';

	/**
	 * Metabox SCREENS
	 *
	 * @since 0.1.0
	 */
	protected const SCREENS = array( 'mlib-movie' );

	/**
	 * Director meta key
	 *
	 * @var string $director_meta_key
	 */
	public static $director_meta_key = 'mlib-movie-meta-crew-director';

	/**
	 * Producer meta key
	 *
	 * @var string $producer_meta_key
	 */
	public static $producer_meta_key = 'mlib-movie-meta-crew-producer';

	/**
	 * Writer meta key
	 *
	 * @var string $writer_meta_key
	 */
	public static $writer_meta_key = 'mlib-movie-meta-crew-writer';

	/**
	 * Actor meta key
	 *
	 * @var string $actor_meta_key
	 */
	public static $actor_meta_key = 'mlib-movie-meta-crew-actor';

	/**
	 * Movie person terms
	 *
	 * @var array
	 */
	public $movie_person_terms = array();

	/**
	 * Renders the html of the Metabox
	 *
	 * @param WP_Post $post Post object passed to the callback.
	 * @since 0.1.0
	 * @return void
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( 'save_mlib-movie_crew_metadata', 'mlib-movie_crew_metadata_nonce' );
		self::render_crew_selector_by_type(
			__( 'Director', 'movie-library' ),
			self::$director_meta_key,
			$post->ID
		);
		self::render_crew_selector_by_type(
			__( 'Producer', 'movie-library' ),
			self::$producer_meta_key,
			$post->ID
		);
		self::render_crew_selector_by_type(
			__( 'Writer', 'movie-library' ),
			self::$writer_meta_key,
			$post->ID
		);
		self::render_crew_selector_by_type(
			__( 'Actor', 'movie-library' ),
			self::$actor_meta_key,
			$post->ID
		);
	}

	/**
	 * Get crew members by type of career
	 *
	 * @param string $career_type Crew career type.
	 * @param string $meta_key The meta key for the type of box.
	 * @param int    $post_id The id of the mlib-movie post.
	 * @since 0.1.0
	 */
	private static function render_crew_selector_by_type(
		$career_type,
		$meta_key,
		$post_id
	) {
		$linked_people = get_post_meta( $post_id, $meta_key, true );

		$linked_people = json_decode( $linked_people );
		if ( false === is_array( $linked_people ) ) {
			$linked_people = array();
		}
		$linked_people = array_map( 'intval', $linked_people );

		$query_args = array(
			'post_type'      => 'mlib-person',
			'posts_per_page' => -1,
			'cache_results'  => true,
			// phpcs:ignore
			'tax_query'      => array(
				array(
					'taxonomy' => 'mlib-person-career',
					'field'    => 'name',
					'terms'    => $career_type,
				),
			),
		);

		$crew_query = new WP_Query( $query_args );
		?>
		<div class="custom_metabox_input_row">
			<label for="<?php echo esc_attr( $meta_key ); ?>"><?php echo esc_html( $career_type ); ?>:</label>
			<select 
				name="<?php echo esc_attr( $meta_key ); ?>[]"
				id="<?php echo esc_attr( $meta_key ); ?>"
				class="movie-library_select2"
				multiple="multiple"
			>
			<?php
			if ( $crew_query->have_posts() ) {
				while ( $crew_query->have_posts() ) {
					$crew_query->the_post();
					?>
					<option 
					value="<?php echo esc_attr( get_the_ID() ); ?>"
					<?php
					if ( true === in_array( get_the_ID(), $linked_people ?? array(), true ) ) {
						echo 'selected';
					}
					?>
					>
						<?php echo esc_html( get_the_title() ); ?>
					</option>
					<?php
				}
			}

			?>
			</select>
		</div>
		<?php

		wp_reset_postdata();
	}

	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 * @return void
	 * @since 0.1.0
	 */
	public function save_metadata( $post_id ) {
		if ( true === empty( $_POST ) ) {
			return;
		}

		if ( false === current_user_can( 'edit_posts' ) ) {
			wp_die(
				esc_html_e(
					'You do not have permissions to edit posts.',
					'movie-library'
				)
			);
		}

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		if ( true === $is_autosave || true === $is_revision ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		if ( 'mlib-movie' !== $post_type ) {
			return;
		}

		// Verifies the nonce.
		if ( false === isset( $_POST['mlib-movie_crew_metadata_nonce'] ) ||
		false === wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['mlib-movie_crew_metadata_nonce'] ) ),
			'save_mlib-movie_crew_metadata'
		)
		) {
			wp_die(
				esc_html( __( 'Invalid request', 'movie-library' ) ),
				'',
				array(
					'response' => 401,
				)
			);
		}

		if ( true === isset( $_POST[ self::$director_meta_key ] ) &&
			true === is_array( $_POST[ self::$director_meta_key ] )
		) {
			self::save_crew_meta( $post_id, self::$director_meta_key, $this->movie_person_terms );
		}

		if ( true === isset( $_POST[ self::$producer_meta_key ] ) &&
			true === is_array( $_POST[ self::$producer_meta_key ] )
		) {
			self::save_crew_meta( $post_id, self::$producer_meta_key, $this->movie_person_terms );
		}

		if ( true === isset( $_POST[ self::$writer_meta_key ] ) &&
			true === is_array( $_POST[ self::$writer_meta_key ] )
		) {
			self::save_crew_meta( $post_id, self::$writer_meta_key, $this->movie_person_terms );
		}

		if ( true === isset( $_POST[ self::$actor_meta_key ] ) &&
			true === is_array( $_POST[ self::$actor_meta_key ] )
		) {
			self::save_crew_meta( $post_id, self::$actor_meta_key, $this->movie_person_terms );
		}
	}

	/**
	 * Save crew meta data
	 *
	 * @param integer $post_id ID of the movie.
	 * @param string  $meta_key Type of crew meta to update.
	 * @param array   $movie_person_terms Terms of movie person.
	 * @return void
	 * @since 0.1.0
	 */
	private static function save_crew_meta(
		$post_id,
		$meta_key,
		&$movie_person_terms
	) {
		$meta_value = self::sanitize_crew_ids(
			// phpcs:ignore 
			wp_unslash( $_POST[ $meta_key ] )
		);

		foreach ( $meta_value as $person_id ) {
			$person    = get_post( $person_id );
			$term_slug = $person->post_name . '-' . $person_id;

			if ( null === term_exists( $term_slug, '_mlib-movie-person' ) ) {
				wp_insert_term(
					$person->post_title,
					'_mlib-movie-person',
					array(
						'slug' => $term_slug,
					)
				);
			}

			array_push(
				$movie_person_terms,
				$term_slug
			);

			wp_set_post_terms(
				$post_id,
				$movie_person_terms,
				'_mlib-movie-person',
				false
			);
		}

		update_post_meta(
			$post_id,
			$meta_key,
			wp_slash(
				wp_json_encode(
					$meta_value
				)
			)
		);
	}

	/**
	 * Sanitizes an array of Person ids.
	 *
	 * @param array $crew_ids IDs of the mlib-person post types.
	 * @return array
	 * @since 0.1.0
	 */
	private static function sanitize_crew_ids( $crew_ids ) {
		$sanitized_array = array();

		foreach ( $crew_ids as $item ) {
			$post_id = absint( $item );

			if ( $post_id && get_post( $post_id ) ) {
				$sanitized_array[] = $post_id;
			}
		}

		return $sanitized_array;
	}

	/**
	 * Registers the Metabox
	 *
	 * @return void
	 */
	public static function register() {
		new Crew_Metabox();
	}
}
