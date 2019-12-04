<?php
/**
 * Main API functions.
 *
 * @package API
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

use PODeviceDetector\Plugin\Feature\Detector;

if ( ! function_exists( 'podd_class_is_bot' ) ) {
	/**
	 * Returns if the class is identified as a bot.
	 *
	 * @@param string $user_agent   Optional. The user-agent string. If not provided,
	 *                              the HTTP_USER_AGENT of the current request is used.
	 * @return boolean  True if it's a bot, false otherwise.
	 * @since   1.0.0
	 */
	function podd_class_is_bot( $user_agent = '' ) {
		return PODeviceDetector\Plugin\Feature\Detector::new( $user_agent )->isBot();
	}
}

if ( ! function_exists( 'podd_class_is_desktop' ) ) {
	/**
	 * Returns if the class is identified as a desktop.
	 *
	 * @@param string $user_agent   Optional. The user-agent string. If not provided,
	 *                              the HTTP_USER_AGENT of the current request is used.
	 * @return boolean  True if it's a desktop, false otherwise.
	 * @since   1.0.0
	 */
	function podd_class_is_desktop( $user_agent = '' ) {
		return PODeviceDetector\Plugin\Feature\Detector::new( $user_agent )->isDesktop();
	}
}

if ( ! function_exists( 'podd_class_is_mobile' ) ) {
	/**
	 * Returns if the class is identified as a mobile.
	 *
	 * @@param string $user_agent   Optional. The user-agent string. If not provided,
	 *                              the HTTP_USER_AGENT of the current request is used.
	 * @return boolean  True if it's a mobile, false otherwise.
	 * @since   1.0.0
	 */
	function podd_class_is_mobile( $user_agent = '' ) {
		return PODeviceDetector\Plugin\Feature\Detector::new( $user_agent )->isMobile();
	}
}






/**
 * Class DeviceDetector
 *
 * Magic Device Type Methods
 * @method boolean isSmartphone()
 * @method boolean isFeaturePhone()
 * @method boolean isTablet()
 * @method boolean isPhablet()
 * @method boolean isConsole()
 * @method boolean isPortableMediaPlayer()
 * @method boolean isCarBrowser()
 * @method boolean isTV()
 * @method boolean isSmartDisplay()
 * @method boolean isCamera()
 * 
 *
 * Magic Client Type Methods
 * @method boolean isBrowser()
 * @method boolean isFeedReader()
 * @method boolean isMobileApp()
 * @method boolean isPIM()
 * @method boolean isLibrary()
 * @method boolean isMediaPlayer()
 *
 */