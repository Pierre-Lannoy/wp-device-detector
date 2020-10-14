# Changelog
All notable changes to **Device Detector** are documented in this *changelog*.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and **Device Detector** adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased - will be 2.1.0]

### Added
- Support for data feeds - reserved for future use.

### Changed
- [MultiSite] Improved default site detection.

### Fixed
- [WP-CLI] Generating statistics may produce PHP warnings.

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
- Full integration with PerfOps.One suite.
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