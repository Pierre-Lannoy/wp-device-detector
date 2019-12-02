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

use PODeviceDetector\System\Role;

wp_enqueue_script( 'podd-moment-with-locale' );
wp_enqueue_script( 'podd-daterangepicker' );
wp_enqueue_script( 'podd-chartist' );
wp_enqueue_script( 'podd-chartist-tooltip' );
wp_enqueue_script( PODD_ASSETS_ID );
wp_enqueue_style( PODD_ASSETS_ID );
wp_enqueue_style( 'podd-daterangepicker' );
wp_enqueue_style( 'podd-tooltip' );
wp_enqueue_style( 'podd-chartist' );
wp_enqueue_style( 'podd-chartist-tooltip' );


?>

<div class="wrap">
	<div class="podd-dashboard">
		<div class="podd-row">
			<?php echo $analytics->get_title_bar() ?>
		</div>
        <div class="podd-row">
	        <?php echo $analytics->get_kpi_bar() ?>
        </div>
        <div class="podd-row">
	        <?php echo $analytics->get_main_chart() ?>
        </div>
        <div class="podd-row">
			<?php echo $analytics->get_events_list() ?>
        </div>
	</div>
</div>
