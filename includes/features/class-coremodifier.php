<?php
/**
 * Device core modification handling
 *
 * Handles all core modification operations.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

use PODeviceDetector\System\Option;
use PODeviceDetector\System\Logger;
use PODeviceDetector\API\Device;

/**
 * Define the core modification functionality.
 *
 * Handles all core modification operations.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class CoreModifier {

	/**
	 * @since    1.0.0
	 */
	public static function wp_is_mobile( $is_mobile ) {
		return Device::get()->class_is_mobile;
	}

	/**
	 * Static initialization.
	 *
	 * @since  1.0.0
	 */
	public static function init() {
		if ( Option::site_get( 'wp_is_mobile' ) ) {
			add_filter( 'wp_is_mobile', [ 'PODeviceDetector\Plugin\Feature\CoreModifier', 'wp_is_mobile' ] );
			Logger::debug( 'Filter hooked: wp_is_mobile.');
		}
	}

}
