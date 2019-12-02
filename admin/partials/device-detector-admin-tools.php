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

use PODeviceDetector\Plugin\Feature\Scripts;

$scripts = new Scripts();
$scripts->prepare_items();

wp_enqueue_script( PODD_ASSETS_ID );
wp_enqueue_style( PODD_ASSETS_ID );

?>

<div class="wrap">
	<h2><?php echo PODD_PRODUCT_NAME; ?></h2>
	<?php settings_errors(); ?>
	<?php $scripts->warning(); ?>
	<?php $scripts->views(); ?>
    <form id="podd-tools" method="post" action="<?php echo $scripts->get_url(); ?>">
        <input type="hidden" name="page" value="podd-tools" />
	    <?php $scripts->display(); ?>
    </form>
</div>
