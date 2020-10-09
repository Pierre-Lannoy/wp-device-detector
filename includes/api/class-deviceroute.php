<?php
/**
 * DecaLog logger read handler
 *
 * Handles all logger reads.
 *
 * @package API
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   2.0.0
 */

namespace PODeviceDetector\API;

use PODeviceDetector\System\Logger;
use PODeviceDetector\Plugin\Feature\Detector;

/**
 * Define the item operations functionality.
 *
 * Handles all item operations.
 *
 * @package API
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   2.0.0
 */
class DeviceRoute extends \WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since  2.0.0
	 */
	public function register_routes() {
		$this->register_route_describe();
	}

	/**
	 * Register the routes for livelog.
	 *
	 * @since  2.0.0
	 */
	public function register_route_describe() {
		register_rest_route(
			PODD_REST_NAMESPACE,
			'describe',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'get_describe' ],
					'permission_callback' => [ $this, 'get_describe_permissions_check' ],
					'args'                => array_merge( $this->arg_schema_describe() ),
					'schema'              => [ $this, 'get_schema' ],
				],
			]
		);
	}

	/**
	 * Get the query params for livelog.
	 *
	 * @return array    The schema fragment.
	 * @since  2.0.0
	 */
	public function arg_schema_describe() {
		return [
			'ua' => [
				'description'       => 'The User-Agent from which to extract informations.',
				'type'              => 'string',
				'required'          => true,
				'default'           => '-',
				'sanitize_callback' => 'sanitize_text_field',
			],
		];
	}

	/**
	 * Check if a given request has access to get livelogs
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_Error|bool
	 */
	public function get_describe_permissions_check( $request ) {
		if ( ! is_user_logged_in() ) {
			Logger::warning( 'Unauthenticated API call.', 401 );
			return new \WP_Error( 'rest_not_logged_in', 'You must be logged in to access live logs.', [ 'status' => 401 ] );
		}
		return true;
	}

	/**
	 * Get a collection of items
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function get_describe( $request ) {
		try {
			$device = Detector::new( $request['ua'] );
		} catch ( \Throwable $t ) {
			Logger::error( sprintf( 'Unable to analyze user-agent "%s".', $request['ua'] ), 500 );
			return new \WP_Error( 'rest_internal_server_error', 'Unable to analyze this User-Agent.', [ 'status' => 500 ] );
		}
		return new \WP_REST_Response( $device->get_as_full_array(), 200 );
	}

}