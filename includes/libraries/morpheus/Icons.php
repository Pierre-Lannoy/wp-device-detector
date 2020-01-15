<?php
/**
 * Wrapper for Flag-Icon-CSS library.
 *
 * Handles all flags operations.
 *
 * @package Feather
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace Morpheus;

use PODeviceDetector\System\Cache;

/**
 * Wraps the Flag-Icon-CSS functionality.
 *
 * Handles all flags operations.
 *
 * @package Feather
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Icons {

	/**
	 * Already loaded raw icons.
	 *
	 * @since  1.0.0
	 * @var    array $icons Already loaded raw flags.
	 */
	private static $icons = [];

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Get a raw (SVG) icon.
	 *
	 * @param string  $name Optional. The name of the flag.
	 * @param boolean $squared Optional. The flag must be squared.
	 *
	 * @return  string  The raw value of the SVG flag.
	 * @since   1.0.0
	 */
	public static function get_raw( $name = '-', $type = '' ) {
		$fname    = $type . '_' . $name;
		$filename = __DIR__ . '/resources/' . $type . '/' . $name . '.png';
		// phpcs:ignore
		$id = Cache::id( serialize( [ 'name' => $name, 'type' => $type ] ), 'morpheus/' );
		if ( Cache::is_memory() ) {
			$flag = Cache::get_shared( $id );
			if ( isset( $flag ) ) {
				return $flag;
			}
		} else {
			if ( array_key_exists( $fname, self::$icons ) ) {
				return self::$icons[ $fname ];
			}
		}
		if ( ! file_exists( $filename ) ) {
			return ( '-' === $name ? '' : self::get_raw() );
		}
		if ( Cache::is_memory() ) {
			// phpcs:ignore
			Cache::set_shared( $id, file_get_contents( $filename ), 'infinite' );
		} else {
			// phpcs:ignore
			self::$icons[ $fname ] = file_get_contents( $filename );
		}

		return ( self::get_raw( $name ) );
	}

	/**
	 * Returns a base64 png resource for the icon.
	 *
	 * @param string $name Optional. The name of the brand.
	 *
	 * @return string The png resource as a base64.
	 * @since 1.0.0
	 */
	public static function get_brand_base64( $name = 'fr' ) {

		// TODO: sanitize $name


		// phpcs:ignore
		return 'data:image/png;base64,' . base64_encode( self::get_raw( $name, 'brand' ) );
	}

	/**
	 * Returns a base64 png resource for the icon.
	 *
	 * @param string $name Optional. The name of the browser.
	 *
	 * @return string The png resource as a base64.
	 * @since 1.0.0
	 */
	public static function get_browser_base64( $name = 'fr' ) {
		// phpcs:ignore
		return 'data:image/png;base64,' . base64_encode( self::get_raw( $name, 'browser' ) );
	}

	/**
	 * Returns a base64 png resource for the icon.
	 *
	 * @param string $name Optional. The name of the os.
	 *
	 * @return string The png resource as a base64.
	 * @since 1.0.0
	 */
	public static function get_os_base64( $name = 'fr' ) {
		// phpcs:ignore
		return 'data:image/png;base64,' . base64_encode( self::get_raw( $name, 'os' ) );
	}
}