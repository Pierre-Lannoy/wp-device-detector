=== Device Detector ===
Contributors: PierreLannoy
Tags: bot, detection, detector, device, mobile
Requires at least: 5.2
Requires PHP: 7.2
Tested up to: 5.5
Stable tag: 1.5.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Full featured analytics reporting and management tool that detects all devices accessing your WordPress site.

== Description ==

**Device Detector** is a full featured analytics reporting and management tool that detects all devices accessing your WordPress site.

For each call made to your site, **Device Detector** analyzes the sent header, detects the device doing the call (and its characteristics) and can:

* modify the `is_mobile()` WordPress core function to be more precise and reliable;
* add some CSS classes to the `body` tag of your site (many classes to choose from);
* let you use the result of the detection in your own developments;
* record detected characteristics for reporting.

**Device Detector** can report the following main items and characteristics:

* KPIs: number of hits, class breakdown, clients types and engines;
* Classes: Bot, Desktop, Mobile and Other;
* Devices types: Camera, Car Browser, Console, Feature Phone, Phablet, Portable Media Player, Smart Display, Smartphone, Tablet, TV;
* Client types: Application Library, Browser, Feed Reader, Media Player, Mobile Application, PIM.
* Technical characteristics and versions of all browsers;
* Device identification: brand, model, etc.;
* OS identification: name, version, etc.;
* Calling channel: site backend, site frontend, cron job, Ajax request, XML-RPC request, Rest API request, Atom/RDF/RSS feed;

For a full list of items, characteristics and supported devices, please see the 'devices' tab in the plugin settings.

**Device Detector** supports multisite report delegation and per site configuration (see FAQ).

**Device Detector** supports an extensive set of WP-CLI commands to:

* get a device detail: see `wp help device describe` for details;
* display Device Detector status: see `wp help device status` for details;
* toggle on/off main settings: see `wp help device settings` for details;
* describe engine capacities: see `wp help device engine` for details;
* display devices statistics: see `wp help device analytics` for details.

For a full help on WP-CLI commands in Device Detector, please [read this guide](https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md).

Based on the amazing [Matomo](https://github.com/matomo-org/matomo) UDD, Device Detector is a free and open source plugin for WordPress. It integrates many other free and open source works (as-is or modified). Please, see 'about' tab in the plugin settings to see the details.

= Developers =

If you're a plugins / themes developer and want to take advantage of the detection features of Device Detector, visit the [GitHub repository](https://github.com/Pierre-Lannoy/wp-device-detector) of the plugin to learn how to use it.

= Support =

This plugin is free and provided without warranty of any kind. Use it at your own risk, I'm not responsible for any improper use of this plugin, nor for any damage it might cause to your site. Always backup all your data before installing a new plugin.

Anyway, I'll be glad to help you if you encounter issues when using this plugin. Just use the support section of this plugin page.

= Privacy =

This plugin, as any piece of software, is neither compliant nor non-compliant with privacy laws and regulations. It is your responsibility to use it - by activating the corresponding options or services - with respect for the personal data of your users and applicable laws.

This plugin doesn't set any cookie in the user's browser.

This plugin may handle personally identifiable information (PII). If the GDPR or CCPA or similar regulation applies to your case, you must adapt your processes (consent management, security measure, treatment register, etc.).

= Donation =

If you like this plugin or find it useful and want to thank me for the work done, please consider making a donation to [La Quadrature Du Net](https://www.laquadrature.net/en) or the [Electronic Frontier Foundation](https://www.eff.org/) which are advocacy groups defending the rights and freedoms of citizens on the Internet. By supporting them, you help the daily actions they perform to defend our fundamental freedoms!

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'.
2. Search for 'Device Detector'.
3. Click on the 'Install Now' button.
4. Activate Device Detector.

= From WordPress.org =

1. Download Device Detector.
2. Upload the `device-detector` directory to your `/wp-content/plugins/` directory, using your favorite method (ftp, sftp, scp, etc...).
3. Activate Device Detector from your Plugins page.

= Once Activated =

1. Visit 'Settings > Device Detector' in the left-hand menu of your WP Admin to adjust settings.
2. Enjoy!

== Frequently Asked Questions ==

= What are the requirements for this plugin to work? =

You need at least **WordPress 5.2** and **PHP 7.2**.

= Can this plugin work on multisite? =

Yes. It is designed to work on multisite too. Network Admins can configure the plugin and have access to all analytics. Sites Admins have access to the analytics of their site(s) and can configure options for their own site(s).

= Where can I get support? =

Support is provided via the official [WordPress page](https://wordpress.org/support/plugin/device-detector/).

= Where can I find documentation? =

Developer's documentation can be found in the [GitHub repository](https://github.com/Pierre-Lannoy/wp-device-detector) of the plugin.

= Where can I report a bug? =
 
You can report bugs and suggest ideas via the [GitHub issue tracker](https://github.com/Pierre-Lannoy/wp-device-detector/issues) of the plugin.

== Changelog ==

Please, see [full changelog](https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/CHANGELOG.md) on GitHub.

== Upgrade Notice ==

== Screenshots ==

1. Main Analytics Dashboard
2. Browsers List
3. Browser Details
4. Bots List
5. Bot Details
6. Libraries List
7. OS List
8. OS Details
9. Devices List
10. Device Details
