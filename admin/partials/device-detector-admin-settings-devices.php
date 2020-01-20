<?php
/**
 * Provide a admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

use PODeviceDetector\Plugin\Feature\Detector;
use UDD\DeviceDetector;

$intro = sprintf( esc_html__( '%1$s (engine version %2$s) allows to detect:', 'device-detector' ), '<em>' . PODD_PRODUCT_NAME . '</em>', DeviceDetector::VERSION );

?>
<p><?php echo $intro; ?></p>

<h3><?php esc_html_e( 'Classes', 'device-detector' ); ?></h3>
<p><?php echo Detector::get_definition( 'class' ) ?></p>
<h3><?php esc_html_e( 'Device Types', 'device-detector' ); ?></h3>
<p><?php echo Detector::get_definition( 'device' ) ?></p>
<h3><?php esc_html_e( 'Client Types', 'device-detector' ); ?></h3>
<p><?php echo Detector::get_definition( 'client' ) ?></p>
<h3><?php esc_html_e( 'Details', 'device-detector' ); ?></h3>
<h4><?php esc_html_e( 'Operating Systems', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'os' ) ?></p>
<h4><?php esc_html_e( 'Browsers', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'browser' ) ?></p>
<h4><?php esc_html_e( 'Browser Engines', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'engine' ) ?></p>
<h4><?php esc_html_e( 'Application Libraries', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'library' ) ?></p>
<h4><?php esc_html_e( 'Media Players', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'player' ) ?></p>
<h4><?php esc_html_e( 'Mobile Applications', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'app' ) ?></p>
<h4><?php esc_html_e( 'PIMs', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'pim' ) ?></p>
<h4><?php esc_html_e( 'Feed Readers', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'reader' ) ?></p>
<h4><?php esc_html_e( 'Brands', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'brand' ) ?></p>
<h4><?php esc_html_e( 'Bots', 'device-detector' ); ?></h4>
<p><?php echo Detector::get_definition( 'bot' ) ?></p>