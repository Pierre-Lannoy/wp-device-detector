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
	 * Initialize a parser and return it.
	 *
	 * @param string $ua    Optional. The user-agent string.
	 * @return \UDD\DeviceDetector  The parser object.
	 * @since    1.0.0
	 */
	public static function new( $ua = '' ) {
		if ( '' === $ua ) {
			$ua = filter_input( INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING );
		}
		$id = Cache::id( $ua );
		if ( array_key_exists( $id, self::$cache ) ) {
			Logger::debug( 'Internal cache hit.' );
			return self::$cache[ $id ];
		}
		$cache_key = '/Plugin/Parsers/' . $id;
		$parser    = Cache::get_global( $cache_key );
		if ( isset( $parser ) && is_object( $parser ) && $parser instanceof \UDD\DeviceDetector ) {
			Logger::debug( 'Transient cache hit.' );
			self::$cache[ $id ] = $parser;
			return self::$cache[ $id ];
		}
		Logger::debug( 'Cache miss.' );
		DeviceParserAbstract::setVersionTruncation( \UDD\Parser\Device\DeviceParserAbstract::VERSION_TRUNCATION_NONE );
		$parser = new \UDD\DeviceDetector( $ua );
		$parser->parse();
		Cache::set_global( $cache_key, $parser, 'infinite' );
		self::$cache[ $id ] = $parser;
		return self::$cache[ $id ];
	}

}
