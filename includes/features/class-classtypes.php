<?php
/**
 * Class types handling
 *
 * Handles all available class types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

/**
 * Define the class types functionality.
 *
 * Handles all available class types.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class ClassTypes {

	/**
	 * The list of available classes.
	 *
	 * @since  1.0.0
	 * @var    array    $classes    Maintains the classes definitions.
	 */
	public static $classes = [ 'bot','desktop','mobile','other' ];

	/**
	 * The list of available classes names.
	 *
	 * @since  1.0.0
	 * @var    array    $class_names    Maintains the classes names.
	 */
	public static $class_names = [];

	/**
	 * Initialize the meta class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		self::$class_names['bot']     = esc_html__( 'Bot', 'device-detector' );
		self::$class_names['desktop'] = esc_html__( 'Desktop', 'device-detector' );
		self::$class_names['mobile']  = esc_html__( 'Mobile', 'device-detector' );
		self::$class_names['other']   = esc_html__( 'Other', 'device-detector' );
	}

}

ClassTypes::init();
