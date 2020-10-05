<?php
/**
 * Main plugin file.
 *
 * @package Bootstrap
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.1.0
 *
 * @wordpress-plugin
 * Plugin Name:       Device Detector
 * Plugin URI:        https://github.com/Pierre-Lannoy/wp-device-detector
 * Description:       Full featured analytics reporting and management tool that detects all devices accessing your WordPress site.
 * Version:           1.5.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pierre Lannoy
 * Author URI:        https://pierre.lannoy.fr
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Network:           true
 * Text Domain:       device-detector
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/includes/system/class-option.php';
require_once __DIR__ . '/includes/system/class-environment.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/includes/libraries/class-libraries.php';
require_once __DIR__ . '/includes/libraries/autoload.php';
require_once __DIR__ . '/includes/features/class-wpcli.php';

/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 */
function podd_activate() {
	PODeviceDetector\Plugin\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 */
function podd_deactivate() {
	PODeviceDetector\Plugin\Deactivator::deactivate();
}

/**
 * The code that runs during plugin uninstallation.
 *
 * @since 1.0.0
 */
function podd_uninstall() {
	PODeviceDetector\Plugin\Uninstaller::uninstall();
}

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function podd_run() {
	\PODeviceDetector\System\Logger::init();
	\PODeviceDetector\System\Cache::init();
	$plugin = new PODeviceDetector\Plugin\Core();
	$plugin->run();
}

register_activation_hook( __FILE__, 'podd_activate' );
register_deactivation_hook( __FILE__, 'podd_deactivate' );
register_uninstall_hook( __FILE__, 'podd_uninstall' );
podd_run();
