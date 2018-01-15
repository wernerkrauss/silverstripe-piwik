# Change log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [0.4.0] - 2018-01-15
### Changed
 - Changed to silverstripe-vendormodule

## [0.3.0] - 2017-06-01
### Changed
 - Disable module on cli and dev/build, fixes #4
 - Disable module on some controllers, use `PiwikExtension.excluded_controllers` config var
 - Upgrade to SilverStripe 4

## [0.2.0] - 2016-03-16
### Changed
 - Passing current $SiteConfig to the tracking code template to enable optional settings
 - Updated README for usage with Subsites and Translatable modules
### Added
 - optional extension for determining the piwik_site_id in SiteConfig.
 - this CHANGELOG file

## [0.1.0] - 2016-03-16
### First official version
