<?php
/**
 * Device types handling
 *
 * Handles all available device types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

/**
 * Define the device types functionality.
 *
 * Handles all available device types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class DeviceTypes {

	/**
	 * The list of available devices.
	 *
	 * @since  1.0.0
	 * @var    array    $devices    Maintains the devices definitions.
	 */
	public static $devices = [ 'camera','car-browser','console','featurephone','phablet','portable-media-player','smartphone','smart-display','tablet','tv','other' ];

	/**
	 * The list of available devices names.
	 *
	 * @since  1.0.0
	 * @var    array    $device_names    Maintains the devices names.
	 */
	public static $device_names = [];

	/**
	 * Initialize the meta device and set its properties.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		self::$device_names['camera']                = esc_html__( 'Camera', 'device-detector' );
		self::$device_names['car-browser']           = esc_html__( 'Car browser', 'device-detector' );
		self::$device_names['console']               = esc_html__( 'Game console', 'device-detector' );
		self::$device_names['featurephone']          = esc_html__( 'Feature phone', 'device-detector' );
		self::$device_names['phablet']               = esc_html__( 'Phablet', 'device-detector' );
		self::$device_names['portable-media-player'] = esc_html__( 'Portable media player', 'device-detector' );
		self::$device_names['smartphone']            = esc_html__( 'Smartphone', 'device-detector' );
		self::$device_names['smart-display']         = esc_html__( 'Smart display', 'device-detector' );
		self::$device_names['tablet']                = esc_html__( 'Tablet', 'device-detector' );
		self::$device_names['tv']                    = esc_html__( 'TV', 'device-detector' );
		self::$device_names['other']                 = esc_html__( 'Other', 'device-detector' );
	}

}

DeviceTypes::init();
