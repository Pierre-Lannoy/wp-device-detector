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

use PODeviceDetector\API\Device;
use PODeviceDetector\System\Role;

// phpcs:ignore
$active_tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'misc' );
if ( 'misc' === $active_tab && ! ( Role::SUPER_ADMIN === Role::admin_type() || Role::SINGLE_ADMIN === Role::admin_type() ) ) {
	$active_tab = 'core';
}
$url  = esc_url(
	add_query_arg(
		[
			'page' => 'podd-viewer',
		],
		admin_url( 'admin.php' )
	)
);

?>

<div class="wrap">

	<h2><?php echo esc_html( sprintf( esc_html__( '%s Settings', 'device-detector' ), PODD_PRODUCT_NAME ) ); ?></h2>
	<?php settings_errors(); ?>
	<h2 class="nav-tab-wrapper">
		<a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page' => 'podd-settings',
					'tab'  => 'core',
				),
				admin_url( 'admin.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'core' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'WordPress core', 'device-detector' ); ?></a>
		<a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page' => 'podd-settings',
					'tab'  => 'css',
				),
				admin_url( 'admin.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'css' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'CSS', 'device-detector' ); ?></a>
		<?php if ( Role::SUPER_ADMIN === Role::admin_type() || Role::SINGLE_ADMIN === Role::admin_type() ) { ?>
            <a href="
		<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'podd-settings',
						'tab'  => 'misc',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		" class="nav-tab <?php echo 'misc' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Options', 'device-detector' ); ?></a>
		<?php } ?>
        <a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page' => 'podd-settings',
					'tab'  => 'about',
				),
				admin_url( 'admin.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'about' === $active_tab ? 'nav-tab-active' : ''; ?>" style="float:right;"><?php esc_html_e( 'About', 'device-detector' ); ?></a>
		<?php if ( class_exists( 'PODeviceDetector\Plugin\Feature\Wpcli' ) ) { ?>
            <a href="
            <?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'podd-settings',
						'tab'  => 'wpcli',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
            " class="nav-tab <?php echo 'wpcli' === $active_tab ? 'nav-tab-active' : ''; ?>" style="float:right;">WP-CLI</a>
		<?php } ?>
        <a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page' => 'podd-settings',
					'tab'  => 'devices',
				),
				admin_url( 'admin.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'devices' === $active_tab ? 'nav-tab-active' : ''; ?>" style="float:right;"><?php esc_html_e( 'Devices', 'device-detector' ); ?></a>
	</h2>
	<?php if ( 'misc' === $active_tab && ( Role::SUPER_ADMIN === Role::admin_type() || Role::SINGLE_ADMIN === Role::admin_type() ) ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-options.php'; ?>
	<?php } ?>
	<?php if ( 'core' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-core.php'; ?>
	<?php } ?>
	<?php if ( 'css' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-css.php'; ?>
	<?php } ?>
	<?php if ( 'about' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-about.php'; ?>
	<?php } ?>
	<?php if ( 'wpcli' === $active_tab ) { ?>
		<?php wp_enqueue_style( PODD_ASSETS_ID ); ?>
		<?php echo do_shortcode( '[podd-wpcli]' ); ?>
	<?php } ?>
	<?php if ( 'devices' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-devices.php'; ?>
	<?php } ?>
</div>
