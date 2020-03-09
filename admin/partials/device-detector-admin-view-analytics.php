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

$simple_list   = [ 'classes', 'types', 'clients', 'libraries', 'applications', 'feeds', 'medias' ];
$extended_list = [ 'browsers', 'bots', 'devices', 'oses' ];

?>

<div class="wrap">
	<div class="podd-dashboard">
		<div class="podd-row">
			<?php echo $analytics->get_title_bar() ?>
		</div>
        <div class="podd-row">
	        <?php echo $analytics->get_kpi_bar() ?>
        </div>
		<?php if ( 'summary' === $analytics->type ) { ?>
            <div class="podd-row">
                <div class="podd-box podd-box-50-50-line">
					<?php echo $analytics->get_top_browser_box() ?>
					<?php echo $analytics->get_top_bot_box() ?>
                </div>
            </div>
            <div class="podd-row">
                <div class="podd-box podd-box-33-33-33-line">
					<?php echo $analytics->get_classes_box() ?>
					<?php echo $analytics->get_types_box() ?>
					<?php echo $analytics->get_clients_box() ?>
                </div>
            </div>
            <div class="podd-row">
                <div class="podd-box podd-box-50-50-line">
					<?php echo $analytics->get_top_device_box() ?>
					<?php echo $analytics->get_top_os_box() ?>
                </div>
            </div>
            <div class="podd-row">
                <div class="podd-box podd-box-25-25-25-25-line">
					<?php echo $analytics->get_libraries_box() ?>
					<?php echo $analytics->get_applications_box() ?>
					<?php echo $analytics->get_feeds_box() ?>
					<?php echo $analytics->get_medias_box() ?>
                </div>
            </div>
		<?php } ?>
		<?php if ( 'browser' === $analytics->type ) { ?>
            <div class="podd-row">
                <div class="podd-box podd-box-50-50-line">
					<?php echo $analytics->get_simpletop_version_box() ?>
					<?php echo $analytics->get_simpletop_os_box() ?>
                </div>
            </div>
		<?php } ?>
		<?php if ( 'os' === $analytics->type ) { ?>
            <div class="podd-row">
                <div class="podd-box podd-box-50-50-line">
					<?php echo $analytics->get_simpletop_version_box() ?>
					<?php echo $analytics->get_simpletop_browser_box() ?>
                </div>
            </div>
		<?php } ?>
		<?php if ( 'device' === $analytics->type ) { ?>
            <div class="podd-row">
                <div class="podd-box podd-box-50-50-line">
					<?php echo $analytics->get_simpletop_os_box() ?>
					<?php echo $analytics->get_simpletop_browser_box() ?>
                </div>
            </div>
		<?php } ?>
		<?php if ( 'browser' === $analytics->type || 'os' === $analytics->type || 'device' === $analytics->type || 'bot' === $analytics->type ) { ?>
			<?php echo $analytics->get_main_chart() ?>
		<?php } ?>
		<?php if ( in_array( (string) $analytics->type, array_merge( $simple_list, $extended_list ), true ) ) { ?>
            <div class="podd-row">
				<?php echo $analytics->get_list() ?>
            </div>
		<?php } ?>
		<?php if ( 'summary' === $analytics->type && Role::SUPER_ADMIN === Role::admin_type() && 'all' === $analytics->site) { ?>
            <div class="podd-row last-row">
	            <?php echo $analytics->get_sites_list() ?>
            </div>
		<?php } ?>
	</div>
</div>
