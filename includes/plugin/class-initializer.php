<?php
/**
 * Plugin initialization handling.
 *
 * @package Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin;

/**
 * Fired after 'plugins_loaded' hook.
 *
 * This class defines all code necessary to run during the plugin's initialization.
 *
 * @package Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Initializer {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		\PODeviceDetector\System\Sitehealth::init();
		\PODeviceDetector\Plugin\Feature\Schema::init();
		\PODeviceDetector\System\APCu::init();
		if ( 'en_US' !== determine_locale() ) {
			unload_textdomain( PODD_SLUG );
			load_plugin_textdomain( PODD_SLUG );
		}
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	public function late_initialize() {
		require_once PODD_PLUGIN_DIR . 'perfopsone/init.php';
	}

}
