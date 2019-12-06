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
class CSSModifier {

	/**
	 * @since    1.0.0
	 */
	public static function body_class( $classes ) {
		return $classes;
	}

	/**
	 * Static initialization.
	 *
	 * @since  1.0.0
	 */
	public static function init() {
		if ( true ) {
			add_filter( 'body_class', [ 'PODeviceDetector\Plugin\Feature\CSSModifier', 'body_class' ] );
			Logger::debug( 'Filter hooked: body_class.');
		}
	}

}
