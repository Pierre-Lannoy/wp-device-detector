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
use UDD\Parser\Device\AbstractDeviceParser;
use PODeviceDetector\System\Cache;

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
	 * The list of allowed definitions.
	 *
	 * @since  2.3.0
	 * @var    array    $definitions    Maintains the allowed definitions id.
	 */
	public static $definitions = [ 'class', 'device', 'client', 'os', 'browser', 'engine', 'library', 'player', 'app', 'pim', 'reader', 'brand', 'bot' ];

	/**
	 * Initialize a device and return it.
	 *
	 * @param string $ua    Optional. The user-agent string.
	 * @return \PODeviceDetector\API\Device  The device object.
	 * @since    1.0.0
	 */
	public static function new( $ua = '' ) {
		if ( '' === $ua ) {
			$ua = filter_input( INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		}
		if ( ! isset( $ua ) ) {
			$ua = 'unknown';
		}
		$id = Cache::id( $ua, 'fingerprint/' );
		if ( array_key_exists( $id, self::$cache ) ) {
			return self::$cache[ $id ];
		}
		$device = Cache::get_global( $id );
		if ( isset( $device ) && is_object( $device ) && $device instanceof \PODeviceDetector\API\Device ) {
			self::$cache[ $id ] = $device;
			return self::$cache[ $id ];
		}
		$span = \DecaLog\Engine::tracesLogger( PODD_SLUG )->startSpan( 'Detection', DECALOG_SPAN_MAIN_RUN );
		\DecaLog\Engine::eventsLogger( PODD_SLUG )->debug( 'Cache miss.' );
		AbstractDeviceParser::setVersionTruncation( \UDD\Parser\Device\AbstractDeviceParser::VERSION_TRUNCATION_NONE );
		$parser = new \UDD\DeviceDetector( $ua );
		$parser->parse();
		$device = new Device( $parser );
		Cache::set_global( $id, $device, 'infinite' );
		self::$cache[ $id ] = $device;
		\DecaLog\Engine::tracesLogger( PODD_SLUG )->endSpan( $span );
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
					} elseif ( $value->device_is_smart_speaker ) {
						return 'smart-speaker';
					} elseif ( $value->device_is_wearable ) {
						return 'wearable';
					} elseif ( $value->device_is_peripheral ) {
						return 'peripheral';
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
				$result = \UDD\Parser\Device\AbstractDeviceParser::$deviceBrands;
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
				$result = [ esc_html__( 'Smart Speaker', 'device-detector' ), esc_html__( 'Wearable', 'device-detector' ), esc_html__( 'Peripheral', 'device-detector' ), esc_html__( 'Smart Display', 'device-detector' ), esc_html__( 'Smartphone', 'device-detector' ), esc_html__( 'Tablet', 'device-detector' ), esc_html__( 'TV', 'device-detector' ), esc_html__( 'Feature Phone', 'device-detector' ), esc_html__( 'Phablet', 'device-detector' ), esc_html__( 'Portable Media Player', 'device-detector' ), esc_html__( 'Camera', 'device-detector' ), esc_html__( 'Car Browser', 'device-detector' ), esc_html__( 'Console', 'device-detector' ) ];
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
	 * @return string The requested definition as printable string.
	 * @since    1.0.0
	 */
	public static function get_definition( $type = 'class' ) {
		$definition = self::get_definition_array( $type );
		natcasesort( $definition );
		return implode( ', ', $definition ) . '.';
	}

	/**
	 * Get the definitions, via shortcode, for a type as string.
	 *
	 * @param array $attributes The attributes of the shortcode.
	 * @return string The requested definition as printable string.
	 * @since    2.3.0
	 */
	public static function sc_get_definition( $attributes ) {
		$_attributes = shortcode_atts( [ 'define' => '' ], $attributes );
		if ( in_array( $_attributes['define'], self::$definitions, true ) ) {
			return self::get_definition( $_attributes['define'] );
		}
		return '';
	}

}
