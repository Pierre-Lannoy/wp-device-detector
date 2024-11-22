# Changelog
All notable changes to **Device Detector** are documented in this *changelog*.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and **Device Detector** adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [4.2.0] - 2024-11-22

### Added
- Compatibility with WordPress 6.7.

### Changed
- Upgraded UDD from version 6.3.2 to version 6.4.1: dozens of added and improved detections.
- Ability to self-update from Github.
- The plugin user agent is now more consistent and "standard".

### Fixed
- There's a WordPress core "feature" which causes some PII to leak (to wp.org) during plugin and theme updates. This is no more the case for this plugin.
- In some cases, a WordPress notice can be triggered concerning the loading sequence of translations.

### Removed
- Test site launching from wordpress.org plugin page.
- All Databeam hooks and libraries, as the Databeam project is abandoned.
- Dependency on wp.org for updates.

## [4.1.0] - 2024-09-10

### Added
- Compatibility with WordPress 6.6.

## [4.0.0] - 2024-05-28

### Added
- [BC] To enable installation on more heterogeneous platforms, the plugin now adapts its internal logging mode to already loaded libraries.

### Changed
- Updated DecaLog SDK from version 4.1.0 to version 5.0.0.
- Upgraded UDD from version 6.3.1 to version 6.3.2: dozens of added and improved detections.

### Fixed
- PHP error with some plugins like Woocommerce Paypal Payments.

## [3.8.0] - 2024-05-07

### Changed
- The plugin now adapts its requirements to the PSR-3 loaded version.

## [3.7.2] - 2024-05-04

### Fixed
- PHP error when DecaLog is not installed.

## [3.7.1] - 2024-05-04

### Changed
- Updated DecaLog SDK from version 3.0.0 to version 4.1.0.
- Upgraded UDD from version 6.3.0 to version 6.3.1: dozens of added and improved detections.
- Some icons for brands, browsers or os have been updated.
- Minimal required WordPress version is now 6.2.

## [3.7.0] - 2024-03-02

### Added
- Compatibility with WordPress 6.5.

### Changed
- Upgraded UDD from version 6.1.6 to version 6.3.0: dozens of added and improved detections.
- Minimal required WordPress version is now 6.1.
- Minimal required PHP version is now 8.1.

### Fixed
- There's a typo in Morpheus project URL.

## [3.6.0] - 2023-10-25

### Added
- Compatibility with WordPress 6.4.

### Changed
- Upgraded UDD from version 6.1.3 to version 6.1.6: dozens of added and improved detections.

### Fixed
- With PHP 8.2, in some edge cases, deprecation warnings may be triggered when viewing analytics.

## [3.5.0] - 2023-07-12

### Added
- Compatibility with WordPress 6.3.

### Changed
- Upgraded UDD from version 6.1.0 to version 6.1.3: dozens of added and improved detections.
- The color for `shmop` test in Site Health is now gray to not worry to much about it (was previously orange).

## [3.4.1] - 2023-03-02

### Fixed
- [SEC004] CSRF vulnerability / [CVE-2023-27444](https://www.cve.org/CVERecord?id=CVE-2023-27444) (thanks to [Mika](https://patchstack.com/database/researcher/5ade6efe-f495-4836-906d-3de30c24edad) from [Patchstack](https://patchstack.com)).

## [3.4.0] - 2023-02-24

The developments of PerfOps One suite, of which this plugin is a part, is now sponsored by [Hosterra](https://hosterra.eu).

Hosterra is a web hosting company I founded in late 2022 whose purpose is to propose web services operating in a European data center that is water and energy efficient and ensures a first step towards GDPR compliance.

This sponsoring is a way to keep PerfOps One plugins suite free, open source and independent.

### Added
- Compatibility with WordPress 6.2.

### Changed
- Upgraded UDD from version 6.0.3 to version 6.1.0: dozens of added and improved detections.
- Improved loading by removing unneeded jQuery references in public rendering (thanks to [Kishorchand](https://github.com/Kishorchandth)).

### Fixed
- In some edge-cases, detecting IP may produce PHP deprecation warnings (thanks to [YR Chen](https://github.com/stevapple)).

## [3.3.0] - 2022-10-06

### Added
- Compatibility with WordPress 6.1.
- [WPCLI] The results of `wp device` commands are now logged in [DecaLog](https://wordpress.org/plugins/decalog/).

### Changed
- Improved ephemeral cache in analytics.
- Upgraded UDD from version 6.0.0 to version 6.0.3: dozens of added and improved detections.
- [WPCLI] The results of `wp device` commands are now prefixed by the product name.

### Fixed
- [SEC003] Moment.js library updated to 2.29.4 / [Regular Expression Denial of Service (ReDoS)](https://github.com/moment/moment/issues/6012).

## [3.2.0] - 2022-04-22

### Added
- Compatibility with WordPress 6.0.

### Changed
- Site Health page now presents a much more realistic test about object caching.
- Upgraded UDD from version 5.0.2 to version 6.0.0: dozens of added and improved detections.
- Improved favicon handling for new Google API specifications.
- Updated DecaLog SDK from version 2.0.2 to version 3.0.0.

### Fixed
- [SEC002] Moment.js library updated to 2.29.2 / [CVE-2022-24785](https://github.com/advisories/GHSA-8hfj-j24r-96c4).

## [3.1.1] - 2022-01-17

### Fixed
- The Site Health page may launch deprecated tests.

## [3.1.0] - 2022-01-17

### Added
- Compatibility with PHP 8.1.

### Changed
- Upgraded UDD from version 5.0.0 to version 5.0.2: dozens of added and improved detections.
- Updated DecaLog SDK from version 2.0.1 to version 2.0.2.
- Updated PerfOps One library from 2.2.1 to 2.2.2.
- Refactored cache mechanisms to fully support Redis and Memcached.
- Improved bubbles display when width is less than 500px (thanks to [Pat Ol](https://profiles.wordpress.org/pasglop/)).
- The tables headers have now a better contrast (thanks to [Paul Bonaldi](https://profiles.wordpress.org/bonaldi/)).

### Fixed
- Object caching method may be wrongly detected in Site Health status (thanks to [freshuk](https://profiles.wordpress.org/freshuk/)).
- There may be name collisions with internal APCu cache.
- An innocuous Mysql error may be triggered at plugin activation.

## [3.0.2] - 2021-12-15

### Fixed
- The DecaLog SDK may produce errors  (thanks to [Jhonny Oliveira](https://github.com/jhonny-oliveira)).

## [3.0.1] - 2021-12-15

### Changed
- Updated DecaLog SDK from version 2.0.0 to version 2.0.1.

### Fixed
- The console menu may display an empty screen (thanks to [Renaud Pacouil](https://www.laboiteare.fr)).
- The tool menu does not work if [IP Locator](https://wordpress.org/plugins/ip-locator/) is not installed  (thanks to [Jhonny Oliveira](https://github.com/jhonny-oliveira)).

## [3.0.0] - 2021-12-07

### Added
- Compatibility with WordPress 5.9.
- 3 new devices types can be detected: smart speakers, wearables and peripherals (projectors, etc.).
- New API properties: `device_is_smart_speaker`, `device_is_wearable` and `device_is_peripheral`.
- New button in settings to install recommended plugins.
- New icons for brands.
- The available hooks (filters and actions) are now described in `HOOKS.md` file.

### Changed
- Improved detection for iOS and iPadOS.
- Improved update process on high-traffic sites to avoid concurrent resources accesses.
- Better publishing frequency for metrics.
- Updated icons for brands, browsers and oses.
- X axis for graphs have been redesigned and are more accurate.
- Upgraded UDD from version 4.3.0 to version 5.0.0: dozens of added and improved detections.
- [BC] Device Detector API version is now v3.
- Updated labels and links in plugins page.
- Updated the `README.md` file.

### Fixed
- Country translation with i18n module may be wrong.
- There's typos in `CHANGELOG.md`.

## [2.4.0] - 2021-09-07

### Added
- It's now possible to hide the main PerfOps One menu via the `poo_hide_main_menu` filter or each submenu via the `poo_hide_analytics_menu`, `poo_hide_consoles_menu`, `poo_hide_insights_menu`, `poo_hide_tools_menu`, `poo_hide_records_menu` and `poo_hide_settings_menu` filters (thanks to [Jan Thiel](https://github.com/JanThiel)).

### Changed
- Updated DecaLog SDK from version 1.2.0 to version 2.0.0.

### Fixed
- There may be name collisions for some functions if version of WordPress is lower than 5.6.
- The main PerfOps One menu is not hidden when it doesn't contain any items (thanks to [Jan Thiel](https://github.com/JanThiel)).
- In some very special conditions, the plugin may be in the default site language rather than the user's language.
- The PerfOps One menu builder is not compatible with Admin Menu Editor plugin (thanks to [dvokoun](https://wordpress.org/support/users/dvokoun/)).

## [2.3.1] - 2021-08-11

### Changed
- Upgraded UDD from version 4.2.3 to version 4.3.0: dozens of added and improved detections.
- New redesigned UI for PerfOps One plugins management and menus (thanks to [Loïc Antignac](https://github.com/webaxones), [Paul Bonaldi](https://profiles.wordpress.org/bonaldi/), [Axel Ducoron](https://github.com/aksld), [Laurent Millet](https://profiles.wordpress.org/wplmillet/), [Samy Rabih](https://github.com/samy) and [Raphaël Riehl](https://github.com/raphaelriehl) for their invaluable help).

### Fixed
- In some conditions, the plugin may be in the default site language rather than the user's language.
- Bot detection may trigger a PHP notice.

## [2.3.0] - 2021-06-22

### Added
- Compatibility with WordPress 5.8.
- Integration with DecaLog SDK.
- Traces publication.

### Changed
- Upgraded UDD from version 4.2.0 to version 4.2.3: dozens of added and improved detections.

## [2.2.1] - 2021-02-25

### Changed
- Upgraded UDD from version 4.1.0 to version 4.2.0: dozens of added and improved detections.

## [2.2.0] - 2021-02-25

### Added
- Compatibility with WordPress 5.7.

### Changed
- Consistent reset for settings.
- Improved translation loading.
- Many icons for brands, browsers and OSes have been updated or added.
- [WP_CLI] `device` command have now a definition and all synopsis are up to date.
- Upgraded UDD from version 4.0.1 to version 4.1.0.

### Fixed
- In Site Health section, Opcache status may be wrong (or generates PHP warnings) if OPcache API usage is restricted.

## [2.1.1] - 2020-11-28

### Changed
- WP-CLI and ajax calls are definitely excluded from analytics.

### Fixed
- With some command line tools, Device Detector may trigger a false-warning.

## [2.1.0] - 2020-11-23

### Added
- Compatibility with WordPress 5.6.
- Support for data feeds - reserved for future use.

### Changed
- Improvement in the way roles are detected.
- [MultiSite] Improved default site detection.
- Upgraded UDD from version 3.13.0 to version 4.0.1.

### Fixed
- [SEC001] User may be wrongly detected in XML-RPC or Rest API calls.
- [WP-CLI] Generating statistics may produce PHP warnings.
- When site is in english and a user choose another language for herself/himself, menu may be stuck in english.

## [2.0.1] - 2020-10-13

### Changed
- [WP-CLI] Improved documentation.
- The analytics dashboard now displays a warning if analytics features are not activated.
- Prepares PerfOps menus to future 5.6 version of WordPress.

### Fixed
- The remote IP can be wrongly detected when behind some types of reverse-proxies.
- In admin dashboard, the statistics link is visible even if analytics features are not activated.
- [WP-CLI] Typos in documentation.

## [2.0.0] - 2020-10-08

### Added
- New tool (in PerfOps Tools menu) to analyze a user-agent string with the Device Detector engine.
- [WP-CLI] New command to get a device detail: see `wp help device describe` for details.
- [WP-CLI] New command to display Device Detector status: see `wp help device status` for details.
- [WP-CLI] New command to toggle on/off main settings: see `wp help device settings` for details.
- [WP-CLI] New command to describe engine capacities: see `wp help device engine` for details.
- [WP-CLI] New command to display devices statistics: see `wp help device analytics` for details.
- New Site Health "info" section about shared memory.
- [API] New `/wp-json/device-detector/v1/describe` endpoint to analyze a user-agent string. Available to all authenticated users.

### Changed
- The positions of PerfOps menus are pushed lower to avoid collision with other plugins (thanks to [Loïc Antignac](https://github.com/webaxones)).
- Improved layout for language indicator.
- Admin notices are now set to "don't display" by default.
- Improved changelog readability.
- Improved IP detection  (thanks to [Ludovic Riaudel](https://github.com/lriaudel)).
- The integrated markdown parser is now [Markdown](https://github.com/cebe/markdown) from Carsten Brandt.

### Fixed
- Some bots icons may be not displayed when it should be.
- With Firefox, some links are unclickable in the Control Center (thanks to [Emil1](https://wordpress.org/support/users/milouze/)).

### Removed
- Parsedown as integrated markdown parser.

## [1.5.0] - 2020-08-17

### Added
- Compatibility with WordPress 5.5.

### Changed
- Updating the plugin now deletes the cache pool.
- Detection sequence has been improved.
- Many icons for brands, browsers ans os have been added.
- Upgraded UDD from version 3.12.6 to version 3.13.0.

## [1.4.3] - 2020-06-29

### Changed
- Full compatibility with PHP 7.4.
- Automatic switching between memory and transient when a cache plugin is installed without a properly configured Redis / Memcached.
- Updated UDD from version 3.12.4 to version 3.12.6.

### Fixed
- When used for the first time, settings checkboxes may remain checked after being unchecked.

## [1.4.2] - 2020-05-04

### Changed
- The lists for classes, device types and client types display now the translated name (it was previously the identifier).

### Fixed
- There's an error while activating the plugin when the server is Microsoft IIS with Windows 10.
- With Microsoft Edge, some layouts may be ugly.

## [1.4.1] - 2020-04-13

### Fixed
- Namespaces collisions.

## [1.4.0] - 2020-04-12
### Added
- Compatibility with [DecaLog](https://wordpress.org/plugins/decalog/) early loading feature.

### Changed
- The settings page have now the standard WordPress style.
- Better styling in "PerfOps Settings" page.
- In site health "info" tab, the boolean are now clearly displayed.
- [API] Improves the way bot producers are rendered. 
- [API] Improves the way bot categories are rendered.
- Updated UDD from version 3.12.3 to version 3.12.4.

### Fixed
- Some strings are not translatable.

## [1.3.0] - 2020-03-09

### Added
- [MultiSite] New box in summary displaying all sites to network admins.
- [MultiSite] There's now a way to navigate between sites sub-reports.

### Changed
- Better styling in "PerfOps Settings" page.

### Removed
- Unneeded tool links in settings page.

## [1.2.0] - 2020-03-01

### Added
- Full integration with PerfOps One suite.
- Compatibility with WordPress 5.4.

### Changed
- New menus (in the left admin bar) for accessing features: "PerfOps Analytics" and "PerfOps Settings".

### Removed
- Compatibility with WordPress versions prior to 5.2.
- Old menus entries, due to PerfOps integration.

## [1.1.1] - 2020-02-16

### Changed
- The name of the the menu item is now "Devices Analytics".

### Fixed
- Displayed version is not the good one.

## [1.1.0] - 2020-02-04

### Added
- Full compatibility with [APCu Manager](https://wordpress.org/plugins/apcu-manager/).
- Full compatibility with [DecaLog](https://wordpress.org/plugins/decalog/).

### Changed
- The position of the "options" tab (in settings screen) is now consistent with other PO plugins. 

### Fixed
- Name collision with some non-maintained plugins. 

## [1.0.0] - 2020-01-22

Initial release