<?php
/**
 * Device detection handling
 *
 * Handles all device detection operations and caching.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

use UDD\DeviceDetector;
use UDD\Parser\Device\DeviceParserAbstract;
use PODeviceDetector\System\Cache;
use PODeviceDetector\System\Logger;
use PODeviceDetector\API\Device;

/**
 * Define the device detection functionality.
 *
 * Handles all device detection operations and caching.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Detector {

	/**
	 * The list of cached parser object.
	 *
	 * @since  1.0.0
	 * @var    array    $cache    Maintains the cached objects (for the session).
	 */
	public static $cache = [];

	/**
	 * Initialize a device and return it.
	 *
	 * @param string $ua    Optional. The user-agent string.
	 * @return \PODeviceDetector\API\Device  The device object.
	 * @since    1.0.0
	 */
	public static function new( $ua = '' ) {
		if ( '' === $ua ) {
			$ua = filter_input( INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING );
		}
		$id        = Cache::id( $ua );
		$cache_key = '/Data/Devices/' . $id;
		if ( array_key_exists( $id, self::$cache ) ) {
			Logger::debug( 'Internal cache hit.' );
			return self::$cache[ $id ];
		}
		$device = Cache::get_global( $cache_key );
		if ( isset( $device ) && is_object( $device ) && $device instanceof \PODeviceDetector\API\Device ) {
			Logger::debug( 'Transient cache hit.' );
			self::$cache[ $id ] = $device;
			return self::$cache[ $id ];
		}
		Logger::debug( 'Cache miss.' );
		DeviceParserAbstract::setVersionTruncation( \UDD\Parser\Device\DeviceParserAbstract::VERSION_TRUNCATION_NONE );
		$parser = new \UDD\DeviceDetector( $ua );
		$parser->parse();
		$device = new Device( $parser );
		Cache::set_global( $cache_key, $device, 'infinite' );
		self::$cache[ $id ] = $device;
		return self::$cache[ $id ];
	}

}
