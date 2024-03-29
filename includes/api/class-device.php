<?php
/**
 * Detected device handling
 *
 * Handles all detected device properties.
 *
 * @package API
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\API;

use PODeviceDetector\Plugin\Feature\Detector;
use Morpheus;
use PODeviceDetector\System\Favicon;
use PODeviceDetector\Plugin\Feature\ClassTypes;
use PODeviceDetector\Plugin\Feature\ClientTypes;
use PODeviceDetector\Plugin\Feature\DeviceTypes;


/**
 * Define the detected device.
 *
 * Handles all detected device properties.
 *
 * @package API
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Device {

	/**
	 * Initializes the class and set its properties.
	 *
	 * @param \UDD\DeviceDetector $detector The fields to copy.
	 * @since 1.0.0
	 */
	public function __construct( $detector = null ) {
		if ( isset( $detector ) && is_object( $detector ) && $detector instanceof \UDD\DeviceDetector ) {
			$this->class_is_bot                    = $detector->isBot();
			$this->class_is_desktop                = $detector->isDesktop();
			$this->class_is_mobile                 = $detector->isMobile();
			$this->class_full_type                 = $this->get_class_full_type();
			$this->device_is_smartphone            = $detector->isSmartphone();
			$this->device_is_featurephone          = $detector->isFeaturePhone();
			$this->device_is_tablet                = $detector->isTablet();
			$this->device_is_phablet               = $detector->isPhablet();
			$this->device_is_console               = $detector->isConsole();
			$this->device_is_portable_media_player = $detector->isPortableMediaPlayer();
			$this->device_is_car_browser           = $detector->isCarBrowser();
			$this->device_is_tv                    = $detector->isTV();
			$this->device_is_smart_display         = $detector->isSmartDisplay();
			$this->device_is_smart_speaker         = $detector->isSmartSpeaker();
			$this->device_is_wearable              = $detector->isWearable();
			$this->device_is_peripheral            = $detector->isPeripheral();
			$this->device_is_camera                = $detector->isCamera();
			$this->device_full_type                = $this->get_device_full_type();
			$this->client_is_browser               = $detector->isBrowser();
			$this->client_is_feed_reader           = $detector->isFeedReader();
			$this->client_is_mobile_app            = $detector->isMobileApp();
			$this->client_is_pim                   = $detector->isPIM();
			$this->client_is_library               = $detector->isLibrary();
			$this->client_is_media_player          = $detector->isMediaPlayer();
			$this->has_touch_enabled               = $detector->isTouchEnabled();
			$this->brand_name                      = $detector->getBrandName();
			$this->brand_short_name                = $detector->getBrand();
			$this->model_name                      = $detector->getModel();
			if ( $this->class_is_bot ) {
				$bot            = $detector->getBot();
				$this->bot_name = $bot['name'];
				if ( array_key_exists( 'category', $bot ) ) {
					$this->bot_category = $bot['category'];
				}
				$this->bot_full_category = $this->get_bot_full_category();
				if ( array_key_exists( 'url', $bot ) ) {
					$this->bot_url = $bot['url'];
				} else {
					$this->bot_url = '';
				}
				if ( array_key_exists( 'producer', $bot ) ) {
					if ( array_key_exists( 'name', $bot['producer'] ) ) {
						$this->bot_producer_name = $bot['producer']['name'];
					}
					if ( array_key_exists( 'url', $bot['producer'] ) ) {
						$this->bot_producer_url = $bot['producer']['url'];
					}
				}
			} else {
				$this->os_name               = $detector->getOs( 'name' );
				$this->os_short_name         = $detector->getOs( 'short_name' );
				$this->os_version            = $detector->getOs( 'version' );
				$this->os_platform           = $detector->getOs( 'platform' );
				$this->client_type           = $detector->getClient( 'type' );
				$this->client_full_type      = $this->get_client_full_type();
				$this->client_name           = $detector->getClient( 'name' );
				$this->client_short_name     = $detector->getClient( 'short_name' );
				$this->client_version        = $detector->getClient( 'version' );
				$this->client_engine         = $detector->getClient( 'engine' );
				$this->client_engine_version = $detector->getClient( 'engine_version' );
			}
		}
	}

	/**
	 * Initialize a device and return it.
	 *
	 * @param string $ua    Optional. The user-agent string.
	 * @return \PODeviceDetector\API\Device  The device object.
	 * @since    1.0.0
	 */
	public static function get( $ua = '' ) {
		return Detector::new( $ua );
	}

	/**
	 * Get the brand icon base64 encoded.
	 *
	 * @return string  The icon base64 encoded.
	 * @since    1.0.0
	 */
	public function brand_icon_base64() {
		return Morpheus\Icons::get_brand_base64( $this->brand_name );
	}

	/**
	 * Get the brand icon html image tag.
	 *
	 * @return string  The icon, as html image, ready to print.
	 * @since    1.0.0
	 */
	public function brand_icon_image() {
		return '<img class="podd-brand-icon podd-brand-icon-' . $this->brand_short_name . '" style="width:16px;vertical-align:top;" src="' . $this->brand_icon_base64() . '" />';
	}

	/**
	 * Get the os icon base64 encoded.
	 *
	 * @return string  The icon base64 encoded.
	 * @since    1.0.0
	 */
	public function os_icon_base64() {
		return Morpheus\Icons::get_os_base64( $this->os_short_name );
	}

	/**
	 * Get the os icon html image tag.
	 *
	 * @return string  The icon, as html image, ready to print.
	 * @since    1.0.0
	 */
	public function os_icon_image() {
		return '<img class="podd-os-icon podd-os-icon-' . $this->os_short_name . '" style="width:16px;vertical-align:top;" src="' . $this->os_icon_base64() . '" />';
	}

	/**
	 * Get the browser icon base64 encoded.
	 *
	 * @return string  The icon base64 encoded.
	 * @since    1.0.0
	 */
	public function browser_icon_base64() {
		return Morpheus\Icons::get_browser_base64( $this->client_short_name );
	}

	/**
	 * Get the browser icon html image tag.
	 *
	 * @return string  The icon, as html image, ready to print.
	 * @since    1.0.0
	 */
	public function browser_icon_image() {
		return '<img class="podd-browser-icon podd-browser-icon-' . $this->client_short_name . '" style="width:16px;vertical-align:top;" src="' . $this->browser_icon_base64() . '" />';
	}

	/**
	 * Get the bot icon base64 encoded.
	 *
	 * @return string  The icon base64 encoded.
	 * @since    1.0.0
	 */
	public function bot_icon_base64() {
		$url_parts = wp_parse_url( $this->bot_url );
		return Favicon::get_base64( $url_parts['host'] );
	}

	/**
	 * Get the bot icon html image tag.
	 *
	 * @return string  The icon, as html image, ready to print.
	 * @since    1.0.0
	 */
	public function bot_icon_image() {
		$id = str_replace( [ '-', ' ', '/', '.', '_', '!', '^', '&' ], '', strtolower( $this->client_short_name ) );
		return '<img class="podd-bot-icon podd-bot-icon-' . $id . '" style="width:16px;vertical-align:top;" src="' . $this->bot_icon_base64() . '" />';
	}

	/**
	 * Get the full class type.
	 *
	 * @return string  The full class type.
	 * @since    1.0.0
	 */
	private function get_class_full_type() {
		if ( $this->class_is_bot ) {
			return ClassTypes::$class_names['bot'];
		}
		if ( $this->class_is_mobile ) {
			return ClassTypes::$class_names['mobile'];
		}
		if ( $this->class_is_desktop ) {
			return ClassTypes::$class_names['desktop'];
		}
		return ClassTypes::$class_names['other'];
	}

	/**
	 * Get the full device type.
	 *
	 * @return string  The full device type.
	 * @since    1.0.0
	 */
	private function get_device_full_type() {
		if ( $this->device_is_smartphone ) {
			return DeviceTypes::$device_names['smartphone'];
		}
		if ( $this->device_is_featurephone ) {
			return DeviceTypes::$device_names['featurephone'];
		}
		if ( $this->device_is_tablet ) {
			return DeviceTypes::$device_names['tablet'];
		}
		if ( $this->device_is_phablet ) {
			return DeviceTypes::$device_names['phablet'];
		}
		if ( $this->device_is_console ) {
			return DeviceTypes::$device_names['console'];
		}
		if ( $this->device_is_portable_media_player ) {
			return DeviceTypes::$device_names['portable-media-player'];
		}
		if ( $this->device_is_car_browser ) {
			return DeviceTypes::$device_names['car-browser'];
		}
		if ( $this->device_is_tv ) {
			return DeviceTypes::$device_names['tv'];
		}
		if ( $this->device_is_smart_display ) {
			return DeviceTypes::$device_names['smart-display'];
		}
		if ( $this->device_is_smart_speaker ) {
			return DeviceTypes::$device_names['smart-speaker'];
		}
		if ( $this->device_is_wearable ) {
			return DeviceTypes::$device_names['wearable'];
		}
		if ( $this->device_is_peripheral ) {
			return DeviceTypes::$device_names['peripheral'];
		}
		if ( $this->device_is_camera ) {
			return DeviceTypes::$device_names['camera'];
		}
		return DeviceTypes::$device_names['other'];
	}

	/**
	 * Get the full client type.
	 *
	 * @return string  The full class type.
	 * @since    1.0.0
	 */
	private function get_client_full_type() {
		if ( $this->client_is_browser ) {
			return ClientTypes::$client_names['browser'];
		}
		if ( $this->client_is_feed_reader ) {
			return ClientTypes::$client_names['feed-reader'];
		}
		if ( $this->client_is_mobile_app ) {
			return ClientTypes::$client_names['mobile-app'];
		}
		if ( $this->client_is_pim ) {
			return ClientTypes::$client_names['pim'];
		}
		if ( $this->client_is_library ) {
			return ClientTypes::$client_names['library'];
		}
		if ( $this->client_is_media_player ) {
			return ClientTypes::$client_names['media-payer'];
		}
		return ClientTypes::$client_names['other'];
	}

	/**
	 * Get the full bot category.
	 *
	 * @return string  The full class type.
	 * @since    1.0.0
	 */
	private function get_bot_full_category() {
		switch ( strtoupper( $this->bot_category ) ) {
			case 'SEARCH BOT':
				return esc_html__( 'Search bot', 'device-detector' );
			case 'SEARCH TOOLS':
				return esc_html__( 'Search tool', 'device-detector' );
			case 'SECURITY SEARCH BOT':
				return esc_html__( 'Security search bot', 'device-detector' );
			case 'SECURITY CHECKER':
				return esc_html__( 'Security checker', 'device-detector' );
			case 'SOCIAL MEDIA AGENT':
				return esc_html__( 'Social media agent', 'device-detector' );
			case 'CRAWLER':
			case 'READ-IT-LATER SERVICE':
				return esc_html__( 'Crawler', 'device-detector' );
			case 'SITE MONITOR':
				return esc_html__( 'Site monitor', 'device-detector' );
			case 'SERVICE AGENT':
				return esc_html__( 'Service agent', 'device-detector' );
			case 'BENCHMARK':
				return esc_html__( 'Benchmark tool', 'device-detector' );
			case 'VALIDATOR':
				return esc_html__( 'Validator tool', 'device-detector' );
			case 'FEED FETCHER':
			case 'FEED READER':
				return esc_html__( 'Feed fetcher', 'device-detector' );
			default:
				return esc_html__( 'Bot', 'device-detector' );
		}
		return esc_html__( 'Unknown', 'device-detector' );
	}

	/**
	 * Get the human readable device details.
	 *
	 * @return  array   The details of the device
	 * @since    2.0.0
	 */
	public function get_as_array() {
		$result          = [];
		$result['class'] = $this->class_full_type;
		$result['type']  = $this->device_full_type;
		if ( $this->class_is_bot ) {
			$result['name']     = $this->bot_name;
			$result['category'] = $this->bot_full_category;
			$result['url']      = $this->bot_url;
			$result['producer'] = $this->bot_producer_name;
		} else {
			$result['brand']    = $this->brand_name;
			$result['model']    = $this->model_name;
			$result['client']   = $this->client_full_type;
			$result['name']     = $this->client_name . ' ' . $this->client_version;
			$result['engine']   = $this->client_engine . ' ' . $this->client_engine_version;
			$result['os']       = $this->os_name . ' ' . $this->os_version;
			$result['platform'] = $this->os_platform;
		}
		return $result;
	}

	/**
	 * Get the full device details.
	 *
	 * @return  array   The details of the device
	 * @since    2.0.0
	 */
	public function get_as_full_array() {
		$result                   = [];
		$result['class']['id']    = Detector::get_element( 'class', $this );
		$result['class']['name']  = $this->class_full_type;
		$result['device']['id']   = Detector::get_element( 'device', $this );
		$result['device']['name'] = $this->device_full_type;
		if ( $this->class_is_bot ) {
			$result['bot']['name']             = $this->bot_name;
			$result['bot']['category']         = $this->bot_full_category;
			$result['bot']['url']              = $this->bot_url;
			$result['bot']['icon']             = $this->bot_icon_base64();
			$result['bot']['producer']['name'] = $this->bot_producer_name;
			$result['bot']['producer']['url']  = $this->bot_producer_url;
		} else {
			$result['brand']['id']                        = $this->brand_short_name;
			$result['brand']['name']                      = $this->brand_name;
			$result['brand']['icon']                      = $this->brand_icon_base64();
			$result['brand']['model']                     = $this->model_name;
			$result['client']['id']                       = Detector::get_element( 'client', $this );
			$result['client']['name']                     = $this->client_full_type;
			$result[ $result['client']['id'] ]['id']      = $this->client_short_name;
			$result[ $result['client']['id'] ]['name']    = $this->client_name;
			$result[ $result['client']['id'] ]['version'] = $this->client_version;
			$result['os']['id']                           = $this->os_short_name;
			$result['os']['name']                         = $this->os_name;
			$result['os']['version']                      = $this->os_version;
			$result['os']['platform']                     = $this->os_platform;
			$result['os']['icon']                         = $this->os_icon_base64();
			if ( 'browser' === $result['client']['id'] ) {
				$result[ $result['client']['id'] ]['icon'] = $this->browser_icon_base64();
			}
			if ( '' !== $this->client_engine ) {
				$result[ $result['client']['id'] ]['engine']['name']    = $this->client_engine;
				$result[ $result['client']['id'] ]['engine']['version'] = $this->client_engine_version;
			}
		}
		return $result;
	}

	/**
	 * @var boolean  True if it's a bot, false otherwise.
	 * @since   1.0.0
	 */
	public $class_is_bot = false;

	/**
	 * @var boolean  True if it's a desktop, false otherwise.
	 * @since   1.0.0
	 */
	public $class_is_desktop = false;

	/**
	 * @var boolean  True if it's a mobile, false otherwise.
	 * @since   1.0.0
	 */
	public $class_is_mobile = false;

	/**
	 * @var string  The name of the class translated if translation exists, else in english.
	 * @since   1.0.0
	 */
	public $class_full_type = '';

	/**
	 * @var boolean  True if it's a smartphone, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_smartphone = false;

	/**
	 * @var boolean  True if it's a featurephone, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_featurephone = false;

	/**
	 * @var boolean  True if it's a tablet, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_tablet = false;

	/**
	 * @var boolean  True if it's a phablet, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_phablet = false;

	/**
	 * @var boolean  True if it's a console, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_console = false;

	/**
	 * @var boolean  True if it's a portable media player, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_portable_media_player = false;

	/**
	 * @var boolean  True if it's a car browser, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_car_browser = false;

	/**
	 * @var boolean  True if it's a tv, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_tv = false;

	/**
	 * @var boolean  True if it's a smart display, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_smart_display = false;

	/**
	 * @var boolean  True if it's a smart speaker, false otherwise.
	 * @since   3.0.0
	 */
	public $device_is_smart_speaker = false;

	/**
	 * @var boolean  True if it's a wearable, false otherwise.
	 * @since   3.0.0
	 */
	public $device_is_wearable = false;

	/**
	 * @var boolean  True if it's a peripheral, false otherwise.
	 * @since   3.0.0
	 */
	public $device_is_peripheral = false;

	/**
	 * @var boolean  True if it's a camera, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_camera = false;

	/**
	 * @var string  The name of the device type translated if translation exists, else in english.
	 * @since   1.0.0
	 */
	public $device_full_type = '';

	/**
	 * @var boolean  True if it's a browser, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_browser = false;

	/**
	 * @var boolean  True if it's a feed reader, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_feed_reader = false;

	/**
	 * @var boolean  True if it's a mobile app, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_mobile_app = false;

	/**
	 * @var boolean  True if it's a PIM, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_pim = false;

	/**
	 * @var boolean  True if it's a library, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_library = false;

	/**
	 * @var boolean  True if it's a media player, false otherwise.
	 * @since   1.0.0
	 */
	public $client_is_media_player = false;

	/**
	 * @var string  The name of the client type translated if translation exists, else in english.
	 * @since   1.0.0
	 */
	public $client_full_type = '';

	/**
	 * @var boolean  True if device has touch enabled, false otherwise.
	 * @since   1.0.0
	 */
	public $has_touch_enabled = false;

	/**
	 * @var string  The OS name.
	 * @since   1.0.0
	 */
	public $os_name = '';

	/**
	 * @var string  The OS short name.
	 * @since   1.0.0
	 */
	public $os_short_name = '';

	/**
	 * @var string  The OS version.
	 * @since   1.0.0
	 */
	public $os_version = '';

	/**
	 * @var string  The OS platform.
	 * @since   1.0.0
	 */
	public $os_platform = '';

	/**
	 * @var string  The client type.
	 * @since   1.0.0
	 */
	public $client_type = '';

	/**
	 * @var string  The client name.
	 * @since   1.0.0
	 */
	public $client_name = '';

	/**
	 * @var string  The client short name.
	 * @since   1.0.0
	 */
	public $client_short_name = '';

	/**
	 * @var string  The client version.
	 * @since   1.0.0
	 */
	public $client_version = '';

	/**
	 * @var string  The client engine.
	 * @since   1.0.0
	 */
	public $client_engine = '';

	/**
	 * @var string  The client engine version.
	 * @since   1.0.0
	 */
	public $client_engine_version = '';

	/**
	 * @var string  The brand name.
	 * @since   1.0.0
	 */
	public $brand_name = '';

	/**
	 * @var string  The brand short name.
	 * @since   1.0.0
	 */
	public $brand_short_name = '';

	/**
	 * @var string  The model name.
	 * @since   1.0.0
	 */
	public $model_name = '';

	/**
	 * @var string  The bot name.
	 * @since   1.0.0
	 */
	public $bot_name = '';

	/**
	 * @var string  The bot category.
	 * @since   1.0.0
	 */
	public $bot_category = '';

	/**
	 * @var string  The bot category translated if translation exists, else in english.
	 * @since   1.0.0
	 */
	public $bot_full_category = '';

	/**
	 * @var string  The bot url.
	 * @since   1.0.0
	 */
	public $bot_url = '';

	/**
	 * @var string  The bot producer name.
	 * @since   1.0.0
	 */
	public $bot_producer_name = '';

	/**
	 * @var string  The bot producer url.
	 * @since   1.0.0
	 */
	public $bot_producer_url = '';
}
