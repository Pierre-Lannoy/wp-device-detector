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
		$cache_key = 'devices/' . $id;
		if ( array_key_exists( $id, self::$cache ) ) {
			return self::$cache[ $id ];
		}
		$device = Cache::get_global( $cache_key );
		if ( isset( $device ) && is_object( $device ) && $device instanceof \PODeviceDetector\API\Device ) {
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

	/**
	 * Get the description of a specifier.
	 *
	 * @param string $spec The specifier.
	 * @param string|\PODeviceDetector\API\Device $spec The value.
	 * @param boolean $filter Optional. Filter / clean the string.
	 * @return string   The description, translated.
	 * @since    1.0.0
	 */
	public static function get_element( $spec, $value ) {
		if ( is_object( $value ) && $value instanceof \PODeviceDetector\API\Device ) {
			switch ( $spec ) {
				case 'class':
					if ( $value->class_is_mobile ) {
						return 'mobile';
					} elseif ( $value->class_is_desktop ) {
						return 'desktop';
					} elseif ( $value->class_is_bot ) {
						return 'bot';
					} else {
						return 'other';
					}
				break;
				case 'device':
					if ( $value->device_is_camera ) {
						return 'camera';
					} elseif ( $value->device_is_car_browser ) {
						return 'car-browser';
					} elseif ( $value->device_is_console ) {
						return 'console';
					} elseif ( $value->device_is_featurephone ) {
						return 'feature-phone';
					} elseif ( $value->device_is_phablet ) {
						return 'phablet';
					} elseif ( $value->device_is_portable_media_player ) {
						return 'portable-media-player';
					} elseif ( $value->device_is_smartphone ) {
						return 'smartphone';
					} elseif ( $value->device_is_smart_display ) {
						return 'smart-display';
					} elseif ( $value->device_is_tablet ) {
						return 'tablet';
					} elseif ( $value->device_is_tv ) {
						return 'tv';
					} else {
						return 'other';
					}
					break;
				case 'client':
					if ( $value->client_is_browser ) {
						return 'browser';
					} elseif ( $value->client_is_feed_reader ) {
						return 'feed-reader';
					} elseif ( $value->client_is_library ) {
						return 'library';
					} elseif ( $value->client_is_media_player ) {
						return 'media-player';
					} elseif ( $value->client_is_mobile_app ) {
						return 'mobile-app';
					} elseif ( $value->client_is_pim ) {
						return 'pim';
					} else {
						return 'other';
					}
					break;
				case 'client-engine':
					if ( '' !== $value->client_engine ) {
						return $value->client_engine;
					} else {
						return 'other';
					}
					break;
				case 'client-name':
					if ( '' !== $value->client_name ) {
						return $value->client_name;
					} else {
						return 'other';
					}
					break;
				case 'os':
					if ( '' !== $value->os_name ) {
						return $value->os_name;
					} else {
						return 'other';
					}
					break;
				case 'brand':
					if ( '' !== $value->brand_name ) {
						return $value->brand_name;
					} else {
						return 'other';
					}
					break;
				case 'brand-model':
					if ( '' !== $value->model_name ) {
						return $value->model_name;
					} else {
						return '';
					}
					break;
				case 'bot':
					if ( ! $value->class_is_bot ) {
						return 'none';
					}
					if ( '' !== $value->bot_name ) {
						return $value->bot_name;
					} else {
						return 'other';
					}
					break;
				case 'capability':
					if ( $value->has_touch_enabled ) {
						return 'touch-enabled';
					} else {
						return 'touch-disabled';
					}
					break;
			}
		} else {
			return 'error';
		}
	}

	/**
	 * Get the definitions for a type.
	 *
	 * @param string $type    Optional. The type to get.
	 * @return array The requested definition.
	 * @since    1.0.0
	 */
	public static function get_identifier_array( $type = 'class' ) {
		switch ( $type ) {
			case 'class':
				$result = [ 'mobile', 'desktop', 'bot' ];
				break;
			case 'device':
				$result = [ 'smartphone', 'feature_phone', 'tablet', 'phablet', 'console', 'portable_media_player', 'car_browser', 'tv', 'smart_display', 'camera' ];
				break;
			case 'client':
				$result = [ 'browser', 'feed_reader', 'mobile_app', 'library', 'pim', 'media_player' ];
				break;
			case 'capability':
				$result = [ 'touch' ];
				break;
			case 'os':
				$result = \UDD\Parser\OperatingSystem::getAvailableOperatingSystems();
				break;
			case 'browser':
				$result = \UDD\Parser\Client\Browser::getAvailableBrowsers();
				break;
			case 'engine':
				$result = \UDD\Parser\Client\Browser\Engine::getAvailableEngines();
				break;
			case 'library':
				$result = \UDD\Parser\Client\Library::getAvailableClients();
				break;
			case 'player':
				$result = \UDD\Parser\Client\MediaPlayer::getAvailableClients();
				break;
			case 'app':
				$result = \UDD\Parser\Client\MobileApp::getAvailableClients();
				break;
			case 'pim':
				$result = \UDD\Parser\Client\PIM::getAvailableClients();
				break;
			case 'reader':
				$result = \UDD\Parser\Client\FeedReader::getAvailableClients();
				break;
			case 'brand':
				$result = \UDD\Parser\Device\DeviceParserAbstract::$deviceBrands;
				break;
			case 'bot':
				$result = [];
				$parser = new \Spyc();
				$bots   = $parser->loadFile( PODD_VENDOR_DIR . 'udd/regexes/bots.yml' );
				foreach ( $bots as $bot ) {
					$result[] = $bot['name'];
				}
				break;
			default:
				$result = [];
		}
		return $result;
	}

	/**
	 * Get the definitions for a type.
	 *
	 * @param string $type    Optional. The type to get.
	 * @return array The requested definition.
	 * @since    1.0.0
	 */
	public static function get_definition_array( $type = 'class' ) {
		switch ( $type ) {
			case 'class':
				$result = [ esc_html__( 'Mobile', 'device-detector' ), esc_html__( 'Desktop', 'device-detector' ), esc_html__( 'Bot', 'device-detector' ) ];
				break;
			case 'device':
				$result = [ esc_html__( 'Smart Display', 'device-detector' ), esc_html__( 'Smartphone', 'device-detector' ), esc_html__( 'Tablet', 'device-detector' ), esc_html__( 'TV', 'device-detector' ), esc_html__( 'Feature Phone', 'device-detector' ), esc_html__( 'Phablet', 'device-detector' ), esc_html__( 'Portable Media Player', 'device-detector' ), esc_html__( 'Camera', 'device-detector' ), esc_html__( 'Car Browser', 'device-detector' ), esc_html__( 'Console', 'device-detector' ) ];
				break;
			case 'client':
				$result = [ esc_html__( 'PIM', 'device-detector' ), esc_html__( 'Browser', 'device-detector' ), esc_html__( 'Application Library', 'device-detector' ), esc_html__( 'Media Player', 'device-detector' ), esc_html__( 'Feed Reader', 'device-detector' ), esc_html__( 'Mobile Application', 'device-detector' ) ];
				break;
			default:
				$result = self::get_identifier_array( $type );
		}
		return $result;
	}

	/**
	 * Get the definitions for a type as string.
	 *
	 * @param string $type    Optional. The type to get.
	 * @return string The requested definition as printable le string.
	 * @since    1.0.0
	 */
	public static function get_definition( $type = 'class' ) {
		$definition = self::get_definition_array( $type );
		natcasesort( $definition );
		return implode( ', ', $definition ) . '.';
	}

}
