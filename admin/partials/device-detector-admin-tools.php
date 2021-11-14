<?php
/**
 * Provide a admin-facing tools for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

wp_localize_script(
	PODD_ASSETS_ID,
	'describer',
	[
		'restUrl'   => esc_url_raw( rest_url() . 'device-detector/v' . IPLOCATOR_API_VERSION . '/describe' ),
		'restNonce' => wp_create_nonce( 'wp_rest' ),
        'sGeneric'  => esc_html__( 'Generic', 'device-detector' ),
	]
);

wp_enqueue_script( PODD_ASSETS_ID );
wp_enqueue_style( PODD_ASSETS_ID );

$img = '<img id="podd_test_ua_wait" style="display:none;width:22px;vertical-align:middle;" src="' . PODD_ADMIN_URL . 'medias/three-dots.svg" />'

?>

<div class="wrap">
	<h2><?php echo esc_html__( 'Devices Test', 'device-detector' ); ?></h2>
    <div class="podd_test_ua_container">
        <input class="regular-text" id="podd_test_ua_value" placeholder="" type="text" value="<?php echo filter_input( INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING ); ?>">
        <button id="podd_test_ua_action" class="button button-primary"><span id="podd_test_ua_text"><?php echo esc_html__( 'Test Now', 'device-detector' ); ?></span><?php echo $img; ?></button>
    </div>
    <div id="podd_test_ua_cdescriber"><div id="podd_test_ua_describer" style="display:none"></div></div>
</div>
