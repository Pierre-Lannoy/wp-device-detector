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

// phpcs:ignore
$active_tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'misc' );

use UDD\DeviceDetector;
use UDD\Parser\Device\DeviceParserAbstract;

// OPTIONAL: Set version truncation to none, so full versions will be returned
// By default only minor versions will be returned (e.g. X.Y)
// for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);

$userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

$dd = new DeviceDetector($userAgent);

// OPTIONAL: Set caching method
// By default static cache is used, which works best within one php process (memory array caching)
// To cache across requests use caching in files or memcache
// $dd->setCache(new Doctrine\Common\Cache\PhpFileCache('./tmp/'));

// OPTIONAL: Set custom yaml parser
// By default Spyc will be used for parsing yaml files. You can also use another yaml parser.
// You may need to implement the Yaml Parser facade if you want to use another parser than Spyc or [Symfony](https://github.com/symfony/yaml)
// $dd->setYamlParser(new DeviceDetector\Yaml\Symfony());

// OPTIONAL: If called, getBot() will only return true if a bot was detected  (speeds up detection a bit)
// $dd->discardBotInformation();

// OPTIONAL: If called, bot detection will completely be skipped (bots will be detected as regular devices then)
// $dd->skipBotDetection();

$dd->parse();

if ($dd->isBot()) {
	// handle bots,spiders,crawlers,...
	$text = 'bot / ' . $dd->getBot();
} else {
	$text = $dd->getDevice() . ' / ' . $dd->getDeviceName() . ' / ' . $dd->getClient() . ' / ' . $dd->getOs() . ' / ' . $dd->getBrandName() . ' / ' . $dd->getModel() ;



}
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
					'tab'  => 'misc',
				),
				admin_url( 'options-general.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'misc' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Options', 'device-detector' ); ?></a>
		<a href="
		<?php
		echo esc_url(
			add_query_arg(
				array(
					'page' => 'podd-settings',
					'tab'  => 'about',
				),
				admin_url( 'options-general.php' )
			)
		);
		?>
		" class="nav-tab <?php echo 'about' === $active_tab ? 'nav-tab-active' : ''; ?>" style="float:right;"><?php esc_html_e( 'About', 'device-detector' ); ?></a>
	</h2>
    
	<?php if ( 'misc' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-options.php'; ?>
	<?php } ?>
	<?php if ( 'about' === $active_tab ) { ?>
		<?php include __DIR__ . '/device-detector-admin-settings-about.php'; ?>
	<?php } ?>

    <p>&nbsp;</p>
    <em><?php echo $text;?></em>

	<?php print_r($dd->getClient()); ?>
	<?php print_r($dd->getOs()); ?>
</div>
