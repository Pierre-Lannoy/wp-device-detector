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
use PODeviceDetector\Plugin\Feature\Detector;

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
	 * The list of specifiers.
	 *
	 * @since  1.0.0
	 * @var    array    $specifiers    Maintains all css specifiers.
	 */
	public static $specifiers = [ 'class', 'device', 'client', 'os', 'brand', 'bot', 'capability' ];

	/**
	 * Get the label of a specifier.
	 *
	 * @param string $spec The specifier.
	 * @return string   The label, translated.
	 * @since    1.0.0
	 */
	public static function get_label( $spec ) {
		switch ( $spec ) {
			case 'class':
				return esc_html__( 'Class', 'device-detector' );
			case 'device':
				return esc_html__( 'Device', 'device-detector' );
			case 'client':
				return esc_html__( 'Client', 'device-detector' );
			case 'os':
				return esc_html__( 'Operating system', 'device-detector' );
			case 'brand':
				return esc_html__( 'Brand', 'device-detector' );
			case 'bot':
				return esc_html__( 'Bot', 'device-detector' );
			case 'capability':
				return esc_html__( 'Capabilities', 'device-detector' );
		}
	}

	/**
	 * Get the description of a specifier.
	 *
	 * @param string $spec The specifier.
	 * @return string   The description, translated.
	 * @since    1.0.0
	 */
	public static function get_description( $spec ) {
		switch ( $spec ) {
			case 'class':
				return esc_html__( 'Adds the class of the device.', 'device-detector' );
			case 'device':
				return esc_html__( 'Adds the type of the device.', 'device-detector' );
			case 'client':
				return esc_html__( 'Adds the client type, engine and name used on the device.', 'device-detector' );
			case 'os':
				return esc_html__( 'Adds the operating system running on the device.', 'device-detector' );
			case 'brand':
				return esc_html__( 'Adds the brand and model of the device.', 'device-detector' );
			case 'bot':
				return esc_html__( 'Adds the bot name.', 'device-detector' );
			case 'capability':
				return esc_html__( 'Adds the device capabilities.', 'device-detector' );
		}
	}

	/**
	 * Get example of all available selectors for a specifier.
	 *
	 * @param string $spec The specifier.
	 * @return string   The selectors, ready to print.
	 * @since    1.0.0
	 */
	public static function get_example( $spec ) {
		switch ( $spec ) {
			case 'class':
			case 'device':
			case 'os':
			case 'bot':
				$c  = Detector::get_identifier_array( $spec );
				$ex = [];
				natcasesort( $c );
				foreach ( $c as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( $spec, $item ) . '</code>';
				}
				$uk = '<code style="font-size: x-small">' . self::get_cssid( $spec, 'other' ) . '</code>';
				return sprintf( esc_html__( 'Available classes: %s. If not detected, the class will be %s.', 'device-detector'), implode( ' ', $ex ), $uk );
			case 'client':
				$c  = Detector::get_identifier_array( $spec );
				$ex = [];
				natcasesort( $c );
				foreach ( $c as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( $spec, $item ) . '</code>';
				}
				$uk = '<code style="font-size: x-small">' . self::get_cssid( $spec, 'other' ) . '</code>';
				$t  = sprintf( esc_html__( 'Available type classes: %s. If not detected, the class will be %s.', 'device-detector'), implode( ' ', $ex ), $uk );
				$c  = Detector::get_identifier_array( 'engine' );
				$ex = [];
				natcasesort( $c );
				foreach ( $c as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( 'client-engine', $item ) . '</code>';
				}
				$uk = '<code style="font-size: x-small">' . self::get_cssid( 'client-engine', 'other' ) . '</code>';
				$e  = sprintf( esc_html__( 'Available engine classes: %s. If not detected, the class will be %s.', 'device-detector'), implode( ' ', $ex ), $uk );
				$de = [];
				foreach ( [ 'browser', 'library', 'player', 'app', 'pim', 'reader', ] as $items ) {
					$de = array_merge( $de, Detector::get_identifier_array( $items ) );
				}
				$ex = [];
				natcasesort( $de );
				foreach ( $de as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( 'client-name', $item ) . '</code>';
				}
				$uk = '<code style="font-size: x-small">' . self::get_cssid( 'client-name', 'other' ) . '</code>';
				$d  = sprintf( esc_html__( 'Available name classes: %s. If not detected, the class will be %s.', 'device-detector'), implode( ' ', $ex ), $uk );
				return $t . '<br/>' . '<br/>' . $e . '<br/>' . '<br/>' . $d;
			case 'brand':
				$c  = Detector::get_identifier_array( $spec );
				$ex = [];
				natcasesort( $c );
				foreach ( $c as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( $spec, $item ) . '</code>';
				}
				$uk = '<code style="font-size: x-small">' . self::get_cssid( $spec, 'other' ) . '</code>';
				$ex = sprintf( esc_html__( 'Available classes: %s. If not detected, the class will be %s.', 'device-detector'), implode( ' ', $ex ), $uk );
				return $ex . '<br/>' . sprintf( esc_html__( 'If (and only if) model is detected an extra class is added. It may be be something like %s or %s.'), '<code style="font-size: x-small">class-model-ipad</code>', '<code style="font-size: x-small">class-model-iphone</code>' );
			case 'capability':
				$c  = [ 'touch-enabled', 'touch-disabled' ];
				$ex = [];
				natcasesort( $c );
				foreach ( $c as $item ) {
					$ex[] = '<code style="font-size: x-small">' . self::get_cssid( $spec, $item, false ) . '</code>';
				}
				return sprintf( esc_html__( 'Available classes: %s.', 'device-detector'), implode( ' ', $ex ) );
		}
	}

	/**
	 * Get the normalized ID.
	 *
	 * @param string $id The ID.
	 * @param boolean $filter Optional. Filter / clean the string.
	 * @return string   The normalized ID.
	 * @since    1.0.0
	 */
	private static function get_normalized_id( $id, $filter = true ) {
		$id = strtolower( $id );
		if ( $filter ) {
			$id = str_replace( [ '-', ' ', '/' , '.' , '_' , '!' , '^', '&' ], '', $id );
		}
		return $id;
	}

	/**
	 * Get the description of a specifier.
	 *
	 * @param string $spec The specifier.
	 * @param string|\PODeviceDetector\API\Device $spec The value.
	 * @param boolean $filter Optional. Filter / clean the string.
	 * @return string   The description, translated.
	 * @since    1.0.0
	 */
	public static function get_cssid( $spec, $value, $filter = true ) {
		switch ( $spec ) {
			case 'class':
				$pref = 'podd-class-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'device':
				$pref = 'podd-device-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'client':
				$pref = 'podd-client-type-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'client-engine':
				$pref = 'podd-client-engine-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'client-name':
				$pref = 'podd-client-name-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'os':
				$pref = 'podd-os-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'brand':
				$pref = 'podd-brand-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'brand-model':
				$pref = 'podd-model-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'bot':
				$pref = 'podd-bot-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			case 'capability':
				$pref = 'podd-capability-';
				if ( is_string( $value ) ) {
					return $pref . self::get_normalized_id( $value, $filter );
				}
				break;
			default:
				$pref = 'podd-xxx-';
		}
		return $pref . self::get_normalized_id( Detector::get_element( $spec, $value ), $filter );
	}

	/**
	 * @since    1.0.0
	 */
	public static function get_current_classes() {
		$result = [];
		if ( Option::site_get( 'css_class' ) ) {
			$result[] = self::get_cssid( 'class', Device::get() );
		}
		if ( Option::site_get( 'css_device' ) ) {
			$result[] = self::get_cssid( 'device', Device::get() );
		}
		if ( Option::site_get( 'css_client' ) ) {
			$result[] = self::get_cssid( 'client', Device::get() );
			$result[] = self::get_cssid( 'client-engine', Device::get() );
			$result[] = self::get_cssid( 'client-name', Device::get() );
		}
		if ( Option::site_get( 'css_os' ) ) {
			$result[] = self::get_cssid( 'os', Device::get() );
		}
		if ( Option::site_get( 'css_brand' ) ) {
			$result[] = self::get_cssid( 'brand', Device::get() );
			$model    = self::get_cssid( 'brand-model', Device::get() );
			if ( 'podd-model-' !== $model ) {
				$result[] = $model;
			}
		}
		if ( Option::site_get( 'css_bot' ) ) {
			$result[] = self::get_cssid( 'bot', Device::get() );
		}
		if ( Option::site_get( 'css_capability' ) ) {
			$result[] = self::get_cssid( 'capability', Device::get(), false );
		}
		return $result;
	}

	/**
	 * @since    1.0.0
	 */
	public static function body_class( $classes ) {
		return array_merge( $classes, self::get_current_classes() );
	}

	/**
	 * @since    1.0.0
	 */
	public static function admin_body_class( $classes ) {
		return $classes . ' ' . implode( ' ', self::get_current_classes() ) . ' ';
	}

	/**
	 * Static initialization.
	 *
	 * @since  1.0.0
	 */
	public static function init() {
		if ( Option::site_get( 'css_class' ) || Option::site_get( 'css_device' ) || Option::site_get( 'css_client' ) || Option::site_get( 'css_os' ) || Option::site_get( 'css_brand' ) || Option::site_get( 'css_bot' ) || Option::site_get( 'css_capability' ) ) {
			add_filter( 'body_class', [ 'PODeviceDetector\Plugin\Feature\CSSModifier', 'body_class' ] );
			Logger::debug( 'Filter hooked: body_class.');
			add_filter( 'admin_body_class', [ 'PODeviceDetector\Plugin\Feature\CSSModifier', 'admin_body_class' ] );
			Logger::debug( 'Filter hooked: admin_body_class.');
		}
	}

}
