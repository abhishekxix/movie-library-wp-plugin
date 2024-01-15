<?php
/**
 * Posts_Controller class
 *
 * @package Movie_Library
 * @since 0.1.0
 */

namespace Movie_Library\Inc\REST_API;

use stdClass;
use WP_REST_Controller;
use WP_REST_Response;
use WP_REST_Server;
use WP_Error;
use WP_Query;

/**
 * REST controller class for custom post type.
 *
 * @since 0.1.0
 */
final class Posts_Controller extends WP_REST_Controller {
	/**
	 * The base of this controller's route.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $post_type_slug;

	/**
	 * The base of this controller's route.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $schema_title;

	/**
	 * Constructor function
	 *
	 * @param string $rest_base The base of the REST URL.
	 * @param string $post_type_slug The slug of the post type.
	 */
	public function __construct( $rest_base, $post_type_slug ) {
		$this->namespace = MLIB_REST_NAMESPACE;

		$this->rest_base = $rest_base;

		$this->post_type_slug = $post_type_slug;

		$this->schema_title = "movie-library-{$this->post_type_slug}";
	}

	/**
	 * Registers the routes for the the controller.
	 *
	 * @since 0.1.0
	 *
	 * @see register_rest_route()
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array(
						$this,
						'get_items',
					),
					'permission_callback' => array(
						$this,
						'get_items_permissions_check',
					),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array(
						$this,
						'create_item',
					),
					'permission_callback' => array(
						$this,
						'create_item_permissions_check',
					),
					'args'                => $this->get_endpoint_args_for_item_schema(
						WP_REST_Server::CREATABLE
					),
				),
				'schema' => array(
					$this,
					'get_public_item_schema',
				),
			)
		);

		$args_for_get_item = array(
			'context'  => $this->get_context_param(
				array( 'default', 'view' )
			),
			'password' => array(
				'description' => esc_html__(
					'The password for the post if it is password protected.',
					'movie-library'
				),
				'type'        => 'string',
			),
		);

		register_rest_route(
			$this->namespace,
			(
				'/' .
				$this->rest_base .
				'/(?P<id>[\d]+)'
			),
			array(
				'args'   => array(
					'id' => array(
						'description' => esc_html__( 'ID for the post.', 'movie-library' ),
						'type'        => 'string',
					),
				),
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array(
						$this,
						'get_item',
					),
					'permission_callback' => array(
						$this,
						'get_item_permissions_check',
					),
					'args'                => $args_for_get_item,
				),
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array(
						$this,
						'update_item',
					),
					'permission_callback' => array(
						$this,
						'update_item_permissions_check',
					),
					'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
				),
				array(
					'methods'             => WP_REST_SERVER::DELETABLE,
					'callback'            => array(
						$this,
						'delete_item',
					),
					'permission_callback' => array(
						$this,
						'delete_item_permissions_check',
					),
					'args'                => array(
						'force' => array(
							'type'        => 'boolean',
							'default'     => false,
							'description' => esc_html__(
								'Whether to bypass Trash and force deletion.',
								'movie-library'
							),
						),
					),
				),
				'schema' => array(
					$this,
					'get_public_item_schema',
				),
			)
		);
	}

	/**
	 * Returns collection of items
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_items( $request ) {
		$query_param_mappings = array(
			'order'    => 'order',
			'page'     => 'paged',
			'search'   => 's',
			'per_page' => 'posts_per_page',
		);

		$registered_params = $this->get_collection_params();
		$query_args        = array();

		foreach ( $query_param_mappings as $rest_param => $wp_query_param ) {
			if ( true === isset(
				$registered_params[ $rest_param ]
			) ) {
				$query_args[ $wp_query_param ] = $request[ $rest_param ];
			}
		}

		// Initialize the date_query args.
		$query_args['date_query'] = array();

		if ( true === isset( $request['before'] ) ) {
			$query_args['date_query'][] = array(
				'before' => $request['before'],
				'column' => 'post_date',
			);
		}

		if ( true === isset( $request['after'] ) ) {
			$query_args['date_query'][] = array(
				'after'  => $request['after'],
				'column' => 'post_date',
			);
		}

		$query_args['post_type'] = $this->post_type_slug;

		$posts_query = new WP_Query( $query_args );

		$posts_query_result = $posts_query->posts;

		$posts = array();

		// Prepare the posts for response.
		if ( ! empty( $posts_query_result ) ) {
			foreach ( $posts_query_result as $post ) {
				// Skip the post if not published.
				if ( 'publish' !== $post->post_status ) {
					continue;
				}

				$data = $this->prepare_item_for_response( $post, $request );

				$posts[] = $this->prepare_response_for_collection( $data );
			}
		}

		$page        = (int) $query_args['paged'];
		$total_posts = $posts_query->found_posts;

		// Run the query to count the number of posts in case the a page greater than 1 has no posts.
		if ( $total_posts < 1 && $page > 1 ) {
			unset( $query_args['paged'] );

			$count_query = new WP_Query( $query_args );
			$total_posts = $count_query->found_posts;
		}

		$max_pages = ceil(
			$total_posts / (int) $posts_query->query_vars['posts_per_page']
		);

		if ( $page > $max_pages && $total_posts > 0 ) {
			return new WP_Error(
				'rest_post_invalid_page_number',
				esc_html__(
					'The page number requested is larger than the number of pages available.',
					'movie-library'
				),
				array( 'status' => 400 )
			);
		}

		$response = rest_ensure_response( $posts );

		// Add headers for pagination.
		$response->header( 'X-WP-Total', (int) $total_posts );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		$request_params = $request->get_query_params();
		$collection_url = rest_url(
			$this->namespace . '/' . $this->rest_base
		);
		$base           = add_query_arg(
			urlencode_deep( $request_params ),
			$collection_url
		);

		// Add links in the Link Header and handle the prev/next link correctly.
		if ( $page > 1 ) {
			$prev_page = $page - 1;

			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}

			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}

		// Add the next link only if there is a next page available.
		if ( $max_pages > $page ) {
			$next_page = $page + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );

			$response->link_header( 'next', $next_link );
		}

		return $response;
	}

	/**
	 * Checks permissions for getting collection of items
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return true|WP_Error
	 */
	public function get_items_permissions_check( $request ) {
		$post_type_obj = get_post_type_object( $this->post_type_slug );

		if ( 'edit' === $request['context'] &&
			false === current_user_can(
				$post_type_obj->cap->edit_posts
			)
		) {
			return new WP_Error(
				'rest_forbidden_context',
				esc_html__(
					'You are not allowed to edit these posts.',
					'movie-library'
				),
				array(
					'status' => rest_authorization_required_code(),
				)
			);
		}

		return true;
	}

	/**
	 * Returns params for Retrieve collection request.
	 *
	 * @return array The params for the request.
	 */
	public function get_collection_params() {
		$query_params = parent::get_collection_params();

		$query_params['context']['default'] = 'view';

		$query_params['after'] = array(
			'description' => esc_html__(
				'Limit response to posts published after a given date in the ISO8601 format.',
				'movie-library'
			),
			'type'        => 'string',
			'format'      => 'date-time',
		);

		$query_params['before'] = array(
			'description' => esc_html__(
				'Limit response to posts published before a given date in the ISO8601 format.',
				'movie-library'
			),
			'type'        => 'string',
			'format'      => 'date-time',
		);

		$query_params['order'] = array(
			'description' => esc_html__(
				'Order of the restult set',
				'movie-library'
			),
			'type'        => 'string',
			'enum'        => array( 'asc', 'desc' ),
			'default'     => 'desc',
		);

		return $query_params;
	}

	/**
	 * Creates an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return \WP_REST_Response
	 */
	public function create_item( $request ) {
		if ( ! empty( $request['id'] ) ) {
			return new WP_Error(
				'rest_post_exists',
				esc_html__(
					'Cannot create existing post.',
					'movie-library'
				),
				array( 'status' => 400 )
			);
		}

		$prepared_post = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $prepared_post ) ) {
			return $prepared_post;
		}

		$prepared_post->post_type = $this->post_type_slug;

		$post_id = wp_insert_post( wp_slash( (array) $prepared_post ), true, false );

		// Check for DB errors.
		if ( is_wp_error( $post_id ) ) {

			if ( 'db_insert_error' === $post_id->get_error_code() ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}

			return $post_id;
		}

		// Handle the insertion of post thumbnail.
		if ( isset( $request['thumbnail'] ) ) {
			$this->handle_thumbnail( $request['thumbnail'], $post_id );
		}

		$post_terms_updated = $this->handle_post_terms( $post_id, $request );

		if ( is_wp_error( $post_terms_updated ) ) {
			return $post_terms_updated;
		}

		$post = get_post( $post_id );

		$fields_update = $this->update_additional_fields_for_object( $post, $request );

		if ( is_wp_error( $fields_update ) ) {
			return $fields_update;
		}

		$request->set_param( 'context', 'edit' );

		$response = $this->prepare_item_for_response( $post, $request );
		$response = rest_ensure_response( $response );

		$response->set_status( 201 );

		// Add location header for the current post.
		$response->header(
			'Location',
			rest_url( $this->namespace . '/' . $this->rest_base . '/' . $post->ID )
		);

		return $response;
	}

	/**
	 * Checks permissions for creating an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return true|WP_Error
	 */
	public function create_item_permissions_check( $request ) {
		if ( ! empty( $request['id'] ) ) {
			return new WP_Error(
				'rest_post_exists',
				esc_html__(
					'Cannot create existing post.',
					'movie-library'
				),
				array( 'status' => 400 )
			);
		}

		$post_type_object = get_post_type_object( $this->post_type_slug );

		if ( ! empty(
			$request['author']
		) &&
			get_current_user_id() !== $request['author'] && ! current_user_can( $post_type_object->cap->edit_others_posts )
		) {
			return new WP_Error(
				'rest_cannot_edit_others',
				esc_html__(
					'Sorry, you are not allowed to create posts as this user.',
					'movie-library'
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		// Check if the user can create a post.
		if ( ! current_user_can(
			$post_type_object->cap->create_posts
		) ) {
			return new WP_Error(
				'rest_cannot_create',
				esc_html__(
					'Sorry, you are not allowed to create posts as this user.',
					'movie-library'
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}


	/**
	 * Returns an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_item( $request ) {
		$post = $this->get_post_if_exists( $request['id'] );

		if ( is_wp_error( $post ) ) {
			return $post;
		}

		$data = $this->prepare_item_for_response( $post, $request );

		$response = rest_ensure_response( $data );

		if ( is_post_type_viewable( get_post_type_object( $post->post_type ) ) ) {
			$response->link_header(
				'alternate',
				get_permalink( $post->ID ),
				array( 'type' => 'text/html' )
			);
		}

		return $response;
	}

	/**
	 * Checks permissions for getting a single item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return true|WP_Error
	 */
	public function get_item_permissions_check( $request ) {
		$post = $this->get_post_if_exists( $request['id'] );

		if ( is_wp_error( $post ) ) {
			return $post;
		}

		if ( 'edit' === $request['context']
			&& false === current_user_can( 'edit_post', $post )
		) {
			return new WP_Error(
				'rest_forbidden_context',
				esc_html__(
					'Sorry, you are not allowed to edit this post.',
					'movie-library',
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		if ( $post && ! empty( $request['password'] ) ) {
			if ( ! hash_equals( $post->post_password, $request['password'] ) ) {
				return new WP_Error(
					'rest_post_incorrect_password',
					esc_html__( 'Incorrect post password', 'movie-library' ),
					array( 'status' => 403 )
				);
			}
		}

		return true;
	}

	/**
	 * Updates an item
	 *
	 * @param \WP_REST_Request $request The request object.
	 *
	 * @return \WP_REST_Response
	 */
	public function update_item( $request ) {
		$original_post = $this->get_post_if_exists( $request['id'] );
		if ( is_wp_error( $original_post ) ) {
			return $original_post;
		}

		$prepared_post = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $prepared_post ) ) {
			return $prepared_post;
		}

		$post_status = '';

		// Assign the post status.
		if ( false === empty( $prepared_post->post_status ) ) {
			$post_status = $prepared_post->post_status;
		} else {
			$post_status = $original_post->post_status;
		}

		// Generate the unique slug for draft and pending posts.
		if ( ! empty( $prepared_post->post_name )
			&& in_array( $post_status, array( 'draft', 'pending' ), true )
		) {
			$prepared_post->post_name = wp_unique_post_slug(
				$prepared_post->post_name,
				$prepared_post->id,
				'publish',
				$prepared_post->post_type,
				$prepared_post->post_parent
			);
		}

		$post_id = wp_update_post( wp_slash( (array) $prepared_post ), true, false );

		if ( is_wp_error( $post_id ) ) {
			if ( 'db_update_error' === $post_id->get_error_code() ) {
				$post_id->add_data( array( 'status' => 500 ) );
			} else {
				$post_id->add_data( array( 'status' => 400 ) );
			}
			return $post_id;
		}

		// Handle change in post thumbnail.
		if ( isset( $request['thumbnail'] ) ) {
			$this->handle_thumbnail( $request['thumbnail'], $post_id );
		}

		// Handle any updates to the post terms.
		$post_terms_updated = $this->handle_post_terms( $post_id, $request );

		if ( is_wp_error( $post_terms_updated ) ) {
			return $post_terms_updated;
		}

		$post = get_post( $post_id );

		$fields_update = $this->update_additional_fields_for_object( $post, $request );

		if ( is_wp_error( $fields_update ) ) {
			return $fields_update;
		}

		$request->set_param( 'context', 'edit' );

		$response = $this->prepare_item_for_response( $post, $request );

		return rest_ensure_response( $response );
	}

	/**
	 * Checks permissions for updating an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return bool
	 */
	public function update_item_permissions_check( $request ) {
		$post = $this->get_post_if_exists( $request['id'] );

		if ( is_wp_error( $post ) ) {
			return $post;
		}

		$post_type_object = get_post_type_object( $this->post_type_slug );

		if ( $post && false === current_user_can( 'edit_post', $post->ID ) ) {
			return new WP_Error(
				'rest_cannot_edit',
				esc_html__(
					'Sorry, you are not allowed to edit this post.',
					'movie-library'
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		if (
			false === empty( $request['author'] )
			&& get_current_user_id() === $request['author']
			&& false === current_user_can( $post_type_object->cap->edit_others_posts )
		) {
			return new WP_Error(
				'rest_cannot_edit_others',
				esc_html__(
					'Sorry, you are not allowed to update posts as this user.',
					'movie-library'
				),
				rest_authorization_required_code()
			);
		}

		return true;
	}

	/**
	 * Deletes an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return \WP_REST_Response
	 */
	public function delete_item( $request ) {
		$post = $this->get_post_if_exists( $request['id'] );
		if ( is_wp_error( $post ) ) {
			return $post;
		}

		$id = $post->ID;

		$force = boolval( $request['force'] );

		if ( false === current_user_can( 'delete_post', $id ) ) {
			return new WP_Error(
				'rest_user_cannot_delete_post',
				esc_html__(
					'Sorry, you are not allowed to delete this post.',
					'movie-library'
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$request->set_param( 'context', 'edit' );

		// Check if trash is available.
		$supports_trash = ( EMPTY_TRASH_DAYS > 0 );

		$response = new WP_REST_Response();

		$result = null;

		if ( $force ) {
			// Handle forced deletion.
			$before_deletion = $this->prepare_item_for_response( $post, $request );
			$result          = wp_delete_post( $id, true );

			$response->set_data(
				array(
					'deleted'         => true,
					'before_deletion' => $before_deletion->get_data(),
				)
			);
		} else {
			// Handle post trashing.
			if ( false === $supports_trash ) {
				return new WP_Error(
					'rest_trash_not_supported',
					sprintf(
						/* translators: %s: force=true */
						esc_html__(
							"The post does not support trashing. Set '%s' to delete.",
							'movie-library'
						),
						'force=true'
					),
					array( 'status' => 501 )
				);
			}

			// Raise an error if already trashed.
			if ( 'trash' === $post->post_status ) {
				return new WP_Error(
					'rest_already_trashed',
					esc_html__(
						'The post has already been deleted.',
						'movie-library'
					),
					array( 'status' => 410 )
				);
			}

			// Finally, trash the post.
			$result   = wp_trash_post( $id );
			$post     = get_post( $id );
			$response = $this->prepare_item_for_response( $post, $request );
		}

		// If there was no deletion.
		if ( ! $result ) {
			return new WP_Error(
				'rest_cannot_delete',
				esc_html__(
					'The post cannot be deleted.',
					'movie-library'
				),
				array( 'status' => 500 )
			);
		}

		return $response;
	}

	/**
	 * Checks permissions for deleting an item
	 *
	 * @param \WP_REST_Request $request The request object for the endpoint.
	 *
	 * @return false|WP_Error
	 */
	public function delete_item_permissions_check( $request ) {
		$existing_post = $this->get_post_if_exists( $request['id'] );
		if ( is_wp_error( $existing_post ) ) {
			return $existing_post;
		}

		if ( $existing_post && false === current_user_can( 'delete_post', $existing_post->ID ) ) {
			return new WP_Error(
				'rest_user_cannot_delete_post',
				esc_html__(
					'Sorry, you are not allowed to delete this post.',
					'movie-library'
				),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	/**
	 * Prepares one item for create or update operation.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return object|WP_Error The prepared item, or WP_Error object on failure.
	 */
	protected function prepare_item_for_database( $request ) {
		$prepared_post  = new stdClass();
		$current_status = '';

		// Get the post if there is an id param provided.
		if ( isset( $request['id'] ) ) {

			$existing_post = $this->get_post_if_exists( $request['id'] );
			if ( is_wp_error( $existing_post ) ) {
				return $existing_post;
			}

			$prepared_post->ID = $existing_post->ID;
			$current_status    = $existing_post->post_status;
		}

		/**
		 * Set the post properties one by one.
		 * For each property:
		 *    - Check if the property is set and adheres to the validation logic.
		 *    - Set the property if it does.
		 */

		if ( true === isset( $request['title'] ) && is_string( $request['title'] ) ) {
			$prepared_post->post_title = $request['title'];
		}

		if ( true === isset( $request['content'] )
			&& is_string( $request['content'] )
		) {
			$prepared_post->post_content = $request['content'];
		}

		if ( true === isset( $request['excerpt'] )
			&& is_string( $request['excerpt'] )
		) {
			$prepared_post->post_excerpt = $request['excerpt'];
		}

		if ( empty( $request['id'] ) ) {
			// For create operation.
			$prepared_post->post_type = $this->post_type_slug;
		} else {
			// For update operation.
			$prepared_post->post_type = get_post_type( $request['id'] );
		}

		$post_type_object = get_post_type_object( $prepared_post->post_type );

		if (
			isset( $request['status'] ) && (
				! $current_status
				|| $current_status !== $request['status']
			)
		) {

			// Check if the user can publish posts and alow only if capability is there.
			if (
				true === in_array(
					$request['status'],
					array( 'private', 'publish', 'future' ),
					true
				)
				&& false === current_user_can(
					$post_type_object->cap->publish_posts
				)
			) {
				return new WP_Error(
					'rest_cannot_publish',
					esc_html__(
						'Sorry, you are not allowed to publish posts in this post type.',
						'movie-library'
					),
					array( 'status' => rest_authorization_required_code() )
				);
			}

			// Set the post status if user has capability to do so.
			$prepared_post->post_status = $request['status'];
		}

		if ( ! empty( $request['date'] ) ) {

			// Handle the case where post date is not set.
			$current_date = isset( $prepared_post->ID )
				? get_post( $prepared_post->ID )->post_date
				: false;

			$date_array = rest_get_date_with_gmt( $request['date'] );

			// Set new date for the post.
			if ( ! empty( $date_array )
				&& $current_date !== $date_array[0]
			) {
				$prepared_post->post_date     = $date_array[0];
				$prepared_post->post_date_gmt = $date_array[1];
				$prepared_post->edit_date     = true;
			}
		} else {
			// Post date null if not provided.
			$prepared_post->post_date     = null;
			$prepared_post->post_date_gmt = null;
		}

		if ( isset( $request['slug'] ) ) {
			$prepared_post->post_name = $request['slug'];
		}

		if ( ! empty( $request['author'] ) ) {
			$post_author = (int) $request['author'];

			if ( get_current_user_id() !== $post_author ) {
				$user_object = get_userdata( $post_author );

				if ( ! $user_object ) {
					return new WP_Error(
						'rest_invalid_author',
						esc_html__(
							'Invalid author ID.',
							'movie-library'
						),
						array( 'status' => 400 )
					);
				}
			}

			// Assign the post author if author var is valid.
			$prepared_post->post_author = $post_author;
		}

		if ( isset( $request['comment_status'] ) ) {
			$prepared_post->comment_status = $request['comment_status'];
		}

		return $prepared_post;
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed           $item    WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function prepare_item_for_response( $item, $request ) {
		$post = $item;

		$fields = $this->get_fields_for_response( $request );

		$data = array();

		/**
		 * Check if each field is included in rest and set it if it is.
		 */
		if ( rest_is_field_included( 'id', $fields ) ) {
			$data['id'] = $post->ID;
		}

		if ( rest_is_field_included( 'date', $fields ) ) {
			$data['date'] = mysql_to_rfc3339( $post->post_date );
		}

		if ( rest_is_field_included( 'slug', $fields ) ) {
			$data['slug'] = $post->post_name;
		}

		if ( rest_is_field_included( 'status', $fields ) ) {
			$data['status'] = $post->post_status;
		}

		if ( rest_is_field_included( 'link', $fields ) ) {
			$data['link'] = get_permalink( $post->ID );
		}

		if ( rest_is_field_included( 'title', $fields ) ) {
			$data['title'] = $post->post_title;
		}

		if ( rest_is_field_included( 'content', $fields ) ) {
			$data['content'] = $post->post_content;
		}

		if ( rest_is_field_included( 'excerpt', $fields ) ) {
			$data['excerpt'] = $post->post_excerpt;
		}

		if ( rest_is_field_included( 'author', $fields ) ) {
			$data['author'] = (int) $post->post_author;
		}

		if ( rest_is_field_included( 'thumbnail', $fields ) ) {
			$data['thumbnail'] = (int) get_post_thumbnail_id( $post->ID );
		}

		if ( rest_is_field_included( 'comment_status', $fields ) ) {
			$data['comment_status'] = $post->comment_status;
		}

		// Add the post terms to response.
		$taxonomies = get_object_taxonomies( $this->post_type_slug, 'objects' );

		if ( is_wp_error( $taxonomies ) ) {
			return $taxonomies;
		}

		$taxonomies = wp_list_filter(
			$taxonomies,
			array( 'show_in_rest' => true )
		);

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$base = ! empty( $taxonomy->rest_base ) ? $taxonomy->rest_base : $taxonomy->name;

				// Add the terms if the taxonomy is included in response.
				if ( rest_is_field_included( $base, $fields ) ) {
					$terms = get_the_terms( $post, $taxonomy->name );

					if ( is_wp_error( $terms ) || empty( $terms ) ) {
						continue;
					}

					$data[ $base ] = $terms ? array_values( wp_list_pluck( $terms, 'term_id' ) ) : array();
				}
			}
		}

		// Set the context if context param is not empty.
		$context = ! empty( $request['context'] ) ? $request['context'] : 'view';
		$data    = $this->add_additional_fields_to_object( $data, $request );
		$data    = $this->filter_response_by_context( $data, $context );

		$response = rest_ensure_response( $data );

		return $response;
	}


	/**
	 * Returns the schema for the resource conforming to JSON Schema
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}

		// Define the schema.
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => $this->schema_title,
			'type'       => 'object',

			'properties' => array(
				'date'           => array(
					'description' => esc_html__(
						'Date of publishing in the site\'s timezone.',
						'movie-library'
					),
					'type'        => array(
						'string',
						'null',
					),
					'format'      => 'date-time',
					'context'     => array(
						'view',
						'edit',
						'embed',
					),
				),
				'id'             => array(
					'description' => esc_html__(
						'Unique ID of the post.',
						'movie-library'
					),
					'type'        => 'integer',
					'context'     => array(
						'view',
						'embed',
						'edit',
					),
					'readonly'    => true,
				),
				'link'           => array(
					'description' => esc_html__( 'URL to the post.', 'movie-library' ),
					'type'        => 'string',
					'format'      => 'uri',
					'context'     => array(
						'view',
						'edit',
						'embed',
					),
					'readonly'    => true,
				),
				'slug'           => array(
					'description' => esc_html__(
						'The slug of the post.',
						'movie-library'
					),
					'type'        => 'string',
					'context'     => array( 'view', 'edit', 'embed' ),
					'arg_options' => array(
						'sanitize_callback' => array(
							$this,
							'sanitize_slug',
						),
					),
				),
				'status'         => array(
					'description' => esc_html__(
						'A named status for the post.',
						'movie-library'
					),
					'type'        => 'string',
					'enum'        => array_keys(
						get_post_stati(
							array( 'internal' => false )
						)
					),
					'context'     => array( 'view', 'edit' ),
				),
				'title'          => array(
					'description' => esc_html__(
						'Post title',
						'movie-library'
					),
					'type'        => 'string',
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'content'        => array(
					'description' => esc_html__(
						'The post content.',
						'movie-library'
					),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'author'         => array(
					'description' => esc_html__(
						'The ID of the post author',
						'movie-library'
					),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'excerpt'        => array(
					'description' => esc_html__(
						'The post excerpt',
						'movie-library'
					),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'thumbnail'      => array(
					'description' => esc_html__(
						'The ID of the featured media.',
						'movie-library'
					),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit', 'embed' ),
				),
				'comment_status' => array(
					'description' => esc_html__(
						'Whether or not the comments are open.',
						'movie-library'
					),
					'type'        => 'string',
					'enum'        => array( 'open', 'closed' ),
					'context'     => array( 'view', 'edit' ),
				),
			),
		);

		// Add Taxonomies to schema if show_in_rest is set to true.
		$relevant_taxonomies = wp_list_filter(
			get_object_taxonomies(
				$this->post_type_slug,
				'objects'
			),
			array( 'show_in_rest' => true )
		);

		if ( ! empty( $relevant_taxonomies ) ) {
			foreach ( $relevant_taxonomies as $tax ) {
				$tax_base = ! empty( $tax->rest_base ) ? $tax->rest_base : $tax->name;

				$schema['properties'][ $tax_base ] = array(
					'description' => sprintf(
						/* translators: %s: Taxonomy name. */
						esc_html__(
							'The terms assigned in the %s taxonomy.',
							'movie-library'
						),
						$tax->name
					),
					'type'        => 'array',
					'items'       => array(
						'type' => 'integer',
					),
					'context'     => array( 'view', 'edit' ),
				);
			}
		}

		$this->schema = $schema;

		return $this->add_additional_fields_schema( $this->schema );
	}

	/**
	 * Determines the thumbnail based on a request param.
	 *
	 * @since 0.1.0
	 *
	 * @param int $thumbnail Thumbnail ID.
	 * @param int $post_id        Post ID.
	 *
	 * @return bool|WP_Error Whether the post thumbnail was successfully deleted, otherwise WP_Error.
	 */
	protected function handle_thumbnail( $thumbnail, $post_id ) {

		$thumbnail = (int) $thumbnail;
		if ( $thumbnail ) {
			$result = set_post_thumbnail( $post_id, $thumbnail );
			if ( $result ) {
				return true;
			} else {
				return new WP_Error(
					'rest_invalid_thumbnail',
					esc_html__(
						'Invalid thumbnail ID.',
						'movie-library'
					),
					array( 'status' => 400 )
				);
			}
		} else {
			return delete_post_thumbnail( $post_id );
		}
	}

	/**
	 * Gets the post, if the ID is valid.
	 *
	 * @since 0.1.0
	 *
	 * @param int $id Supplied ID.
	 *
	 * @return WP_Post|WP_Error Post object if ID is valid, WP_Error otherwise.
	 */
	protected function get_post_if_exists( $id ) {
		$invalid_id_error = new WP_Error(
			'rest_post_invalid_id',
			esc_html__(
				'Invalid post ID.',
				'movie-library'
			),
			array( 'status' => 404 )
		);

		if ( (int) $id <= 0 ) {
			return $invalid_id_error;
		}

		$post = get_post( (int) $id );
		if ( empty( $post )
			|| empty( $post->ID )
			|| $this->post_type_slug !== $post->post_type
		) {
			return $invalid_id_error;
		}

		return $post;
	}

	/**
	 * Updates the post's terms from a REST request.
	 *
	 * @since 0.1.0
	 *
	 * @param int             $post_id The post ID to update the terms form.
	 * @param WP_REST_Request $request The request object with post and terms data.
	 *
	 * @return null|WP_Error WP_Error on an error assigning any of the terms, otherwise null.
	 */
	protected function handle_post_terms( $post_id, $request ) {
		$taxonomies = wp_list_filter( get_object_taxonomies( $this->post_type_slug, 'objects' ), array( 'show_in_rest' => true ) );

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$base = ! empty( $taxonomy->rest_base ) ? $taxonomy->rest_base : $taxonomy->name;

				if ( ! isset( $request[ $base ] ) ) {
					continue;
				}

				$result = wp_set_post_terms( $post_id, $request[ $base ], $taxonomy->name );

				if ( is_wp_error( $result ) ) {
					return $result;
				}
			}
		}
	}
}
