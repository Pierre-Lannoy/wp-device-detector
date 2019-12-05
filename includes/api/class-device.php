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
			$this->device_is_smartphone            = $detector->isSmartphone();
			$this->device_is_featurephone          = $detector->isFeaturePhone();
			$this->device_is_tablet                = $detector->isTablet();
			$this->device_is_phablet               = $detector->isPhablet();
			$this->device_is_console               = $detector->isConsole();
			$this->device_is_portable_media_player = $detector->isPortableMediaPlayer();
			$this->device_is_car_browser           = $detector->isCarBrowser();
			$this->device_is_tv                    = $detector->isTV();
			$this->device_is_smart_display         = $detector->isSmartDisplay();
			$this->device_is_camera                = $detector->isCamera();
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
				$bot                     = $detector->getBot();
				$this->bot_name          = $bot['name'];
				$this->bot_category      = $bot['category'];
				$this->bot_url           = $bot['url'];
				$this->bot_producer_name = $bot['producer']['name'];
				$this->bot_producer_url  = $bot['producer']['url'];
			} else {
				$this->os_name               = $detector->getOs( 'name' );
				$this->os_short_name         = $detector->getOs( 'short_name' );
				$this->os_version            = $detector->getOs( 'version' );
				$this->os_platform           = $detector->getOs( 'platform' );
				$this->client_type           = $detector->getClient( 'type' );
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
	 * @var boolean  True if it's a camera, false otherwise.
	 * @since   1.0.0
	 */
	public $device_is_camera = false;

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
