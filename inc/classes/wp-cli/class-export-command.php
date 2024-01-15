<?php
/**
 * Export_Command: A custom WP CLI command to posts as CSV
 *
 * @package Movie_Library
 */

namespace Movie_Library\Inc\WP_CLI;

use WP_CLI;

/**
 * Export CPT data for 'movie-library'.
 *
 * ## EXAMPLES
 *
 *     # Export movie data.
 *     $ wp mlb-export movies
 *
 *     Starting export for "mlib-movie"
 *
 *     Warning: Using default directory "/Users/{your_username}/Local Sites/movie-library/app/public/"
 *
 *     Warning: Using defualt file name "/Users/{your_username}/Local Sites/movie-library/app/public/"
 *
 *     Full path of the file is "/Users/{your_username}/Local Sites/movie-library/app/public//movie-library-mlib-movie-export.csv"
 *
 *     Success: Imported "34" records
 *
 *
 *     # Export person data.
 *     $ wp mlb-export persons
 *
 *     Starting export for "mlib-person"
 *
 *     Warning: Using default directory "/Users/{your_username}/Local Sites/movie-library/app/public/"
 *
 *     Warning: Using defualt file name "/Users/{your_username}/Local Sites/movie-library/app/public/"
 *
 *     Full path of the file is "/Users/{your_username}/Local Sites/movie-library/app/public//movie-library-mlib-person-export.csv"
 *
 *     Success: Imported "16" records
 */
class Export_Command {

	/**
	 * Export 'mlib-movie' posts
	 *
	 * ## OPTIONS
	 *
	 * [--destination=<destination>]
	 * : Absolute path to a directory where the data should be exported.
	 *
	 * [--file-name=<file-name>]
	 * : Name of the file to export the data to
	 *
	 * @param array $args The positional arguments passed to the CLI command.
	 * @param array $assoc_args The associative arguments passed to the CLI command.
	 *
	 * @return void
	 */
	public function movies( $args, $assoc_args ) {
		$this->export_data( $assoc_args, 'mlib-movie' );
	}

	/**
	 * Export 'mlib-person' posts
	 *
	 * ## OPTIONS
	 *
	 * [--destination=<destination>]
	 * : Absolute path to a directory where the data should be exported.
	 *
	 * [--file-name=<file-name>]
	 * : Name of the file to export the data to
	 *
	 * @param array $args The positional arguments passed to the CLI command.
	 * @param array $assoc_args The associative arguments passed to the CLI command.
	 *
	 * @return void
	 */
	public function persons( $args, $assoc_args ) {
		$this->export_data( $assoc_args, 'mlib-person' );
	}

	/**
	 * Returns the parsed file path.
	 *
	 * @param array  $assoc_args The associative args.
	 * @param string $post_type The post type slug.
	 *
	 * @return string
	 */
	private function parse_file_path( $assoc_args, $post_type ) {
		$default_path = array(
			'destination' => ABSPATH,
			'file-name'   => "movie-library-{$post_type}-export.csv",
		);

		$path = array();

		if ( isset( $assoc_args['destination'] ) && file_exists( $assoc_args['destination'] ) ) {
			$path['destination'] = $assoc_args['destination'];
			WP_CLI::line(
				sprintf(
					/* translators: %s is the path of the directory. */
					esc_html__(
						'Using user provided directory "%s"',
						'movie-library'
					),
					$path['destination']
				)
			);
		} else {
			$path['destination'] = $default_path['destination'];
			WP_CLI::warning(
				sprintf(
					/* translators: %s is the path of the directory. */
					esc_html__(
						'Using default directory "%s"',
						'movie-library'
					),
					$path['destination']
				)
			);
		}

		if ( isset( $assoc_args['file-name'] )
			&& is_string( $assoc_args['file-name'] )
			&& '' !== $assoc_args['file-name']
		) {
			$path['file-name'] = $assoc_args['file-name'];

			WP_CLI::line(
				sprintf(
					/* translators: %s is the file name. */
					esc_html__(
						'Using user provided file name "%s"',
						'movie-library'
					),
					$path['file-name']
				)
			);
		} else {
			$path['file-name'] = $default_path['file-name'];

			WP_CLI::warning(
				sprintf(
					/* translators: %s is the file name. */
					esc_html__(
						'Using defualt file name "%s"',
						'movie-library'
					),
					$path['file-name']
				)
			);
		}

		WP_CLI::line(
			sprintf(
				/* translators: %s is the file name. */
				esc_html__(
					'Full path of the file is "%s"',
					'movie-library'
				),
				$path['destination'] . '/' . $path['file-name']
			)
		);

		return $path['destination'] . '/' . $path['file-name'];
	}

	/**
	 * Exports the data of a post type.
	 *
	 * @param array  $assoc_args Associative args passed to the commands.
	 * @param string $post_type Post type slug.
	 *
	 * @return void
	 */
	private function export_data( $assoc_args, $post_type ) {
		WP_CLI::line(
			sprintf(
				/* translators: %s is the post type slug. */
				esc_html__(
					'Starting export for "%s"',
					'movie-library'
				),
				$post_type
			)
		);
		$path = $this->parse_file_path( $assoc_args, $post_type );

		$posts = get_posts(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => -1,
			)
		);

		// Initialize the rows and headers of the CSV output.
		$rows    = array();
		$headers = array(
			'title',
			'content',
			'excerpt',
			'thumbnail',
		);

		$taxonomies = get_object_taxonomies( $post_type );

		// Add the headers for each taxonomy linked to the post type.
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax ) {
				$headers[] = $tax;
			}
		}

		// Set up headers for the post meta keys.
		$meta_fields = array();

		if ( 'mlib-movie' === $post_type ) {
			$meta_fields[] = 'mlib-movie-meta-basic-rating';
			$meta_fields[] = 'mlib-movie-meta-basic-runtime';
			$meta_fields[] = 'mlib-movie-meta-basic-release-date';
			$meta_fields[] = 'mlib-movie-meta-basic-content-rating';
			$meta_fields[] = 'mlib-movie-meta-crew-director';
			$meta_fields[] = 'mlib-movie-meta-crew-producer';
			$meta_fields[] = 'mlib-movie-meta-crew-writer';
			$meta_fields[] = 'mlib-movie-meta-crew-actor';
			$meta_fields[] = 'mlib-movie-meta-carousel-poster';
		} elseif ( 'mlib-person' === $post_type ) {
			$meta_fields[] = 'mlib-person-meta-full-name';
			$meta_fields[] = 'mlib-person-meta-basic-birth-date';
			$meta_fields[] = 'mlib-person-meta-basic-birth-place';
			$meta_fields[] = 'mlib-person-meta-social-twitter';
			$meta_fields[] = 'mlib-person-meta-social-facebook';
			$meta_fields[] = 'mlib-person-meta-social-instagram';
			$meta_fields[] = 'mlib-person-meta-social-web';
		}

		$meta_fields[] = 'mlib-media-meta-img';
		$meta_fields[] = 'mlib-media-meta-video';

		foreach ( $meta_fields as $meta_field ) {
			$headers[] = $meta_field;
		}

		// Add the data of each post as a row.
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$post_row = array();

				$post_row['title']     = $post->post_title;
				$post_row['content']   = $post->post_content;
				$post_row['excerpt']   = $post->post_excerpt;
				$post_row['thumbnail'] = get_the_post_thumbnail_url() ? get_the_post_thumbnail() : '';

				foreach ( $taxonomies as $tax ) {
					$terms = wp_get_post_terms( $post->ID, $tax );
					if ( is_wp_error( $terms ) || empty( $terms ) ) {
						continue;
					}

					$terms = wp_list_pluck( $terms, 'slug' );

					$post_row[ $tax ] = implode( ',', $terms );
				}

				foreach ( $meta_fields as $meta_field ) {
					$post_row[ $meta_field ] = get_post_meta( $post->ID, $meta_field, true );
				}

				$rows[] = $post_row;

			}
		}

		//phpcs:ignore
		$file = fopen( $path, 'w' );

		\WP_CLI\Utils\write_csv( $file, $rows, $headers );

		//phpcs:ignore
		fclose( $file );

		WP_CLI::success(
			sprintf(
				esc_html(
					/* translators: %d is the number of posts. */
					_n(
						'Imported "%d" record',
						'Imported "%d" records',
						2,
						'movie-library'
					)
				),
				number_format_i18n( count( $rows ) )
			)
		);
	}
}

WP_CLI::add_command( 'mlb-export', Export_Command::class );
