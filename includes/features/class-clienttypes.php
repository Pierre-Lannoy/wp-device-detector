<?php
/**
 * Client types handling
 *
 * Handles all available client types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

/**
 * Define the client types functionality.
 *
 * Handles all available client types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class ClientTypes {

	/**
	 * The list of available clients.
	 *
	 * @since  1.0.0
	 * @var    array    $clients    Maintains the clients definitions.
	 */
	public static $clients = [ 'browser','feed-reader','library','media-player','mobile-app','pim','other' ];

	/**
	 * The list of available clients names.
	 *
	 * @since  1.0.0
	 * @var    array    $client_names    Maintains the clients names.
	 */
	public static $client_names = [];

	/**
	 * Initialize the meta client and set its properties.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		self::$client_names['browser']      = esc_html__( 'Browser', 'client-detector' );
		self::$client_names['feed-reader']  = esc_html__( 'Feed reader', 'client-detector' );
		self::$client_names['library']      = esc_html__( 'Library', 'client-detector' );
		self::$client_names['media-player'] = esc_html__( 'Media player', 'client-detector' );
		self::$client_names['mobile-app']   = esc_html__( 'Mobile application', 'client-detector' );
		self::$client_names['pim']          = esc_html__( 'Personal information manager', 'client-detector' );
		self::$client_names['other']        = esc_html__( 'Other', 'client-detector' );
	}

}

ClientTypes::init();
