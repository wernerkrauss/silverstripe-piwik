# Silverstripe Piwik Analytics Module

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wernerkrauss/silverstripe-piwik/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wernerkrauss/silverstripe-piwik/?branch=master)

This module includes a piwik analytics javascript at the bottom of your page.

It's configurable via config API, you can change the included Javascript by overwriting the Piwik.ss template.


## Requirements
  * Silverstripe > 4.0
  
For a SS3 compatible version use version 0.2.

## Installation
Best installed via composer. You may clone the repo or download the zip, however you should find a directory called "silverstripe-piwik"
with all files in `vendor/wernerkrauss/`

### using Composer
```
composer require wernerkrauss/silverstripe-piwik ^0.4.0
```

## Features
  * Includes piwik tracking code to your page. You can configure if it's included automatically or manually by calling
  $Piwik inside your template
  * By default only included in frontend pages
  * By default only included in Live mode

## Configuration
```yml
Netwerkstatt\Piwik\Extensions\PiwikExtension:
  piwik_server: '//logs.example.com/' #domain without protocol an trailing slash
  piwik_site_id: 123 #the id defined by your piwik install
  show_on_dev: false #default: don't show in dev mode
  show_on_test: false #default: don't show in test mode
  show_on_live: true #default: show in live mode
  auto_include: true #default: include automatically
  include_in_backend: false #default: don't include in backend
```

## Usage with Subsites Module
When you're using subsites you can add the PIWIK Site ID for each subsite / domain in SiteConfig.
To do this you have to add an extension:

```yml
SilverStripe\SiteConfig\SiteConfig:
  extensions:
    - Netwerkstatt\Piwik\Extensions\PiwikSiteConfigExtension
```

You'll also have to tweak the used template for the tracking code. Copy the default `Piwik.ss` file to your theme's _/templates/_ folder
or to _/mysite/templates/_ and adjust the setting like

```
_paq.push(["setSiteId", "$SiteConfig.PiwikSiteID"]);
```
### Exclude on some controllers
You can finetune the controllers Piwik should NOT be included using the `PiwikExtension.excluded_controllers` config var.
By default the module is disabled on dev/build.


### Usage with Subsites and Translatable
When you're useing Subsites with translatable you have to be sure to add it to the SiteConfig for every translation.
One workaround might be if don't put the value fot the Piwik SiteID to SiteConfig, but directly to the Subsites DataObject.

Then don't extend SiteConfig but Subsite:

```yml
Silverstripe\Subsites\Model\Subsite:
  extensions:
    - Netwerkstatt\Piwik\Extensions\PiwikSiteConfigExtension
```

and change your template to reflect the changes:

```
_paq.push(["setSiteId", "$SiteConfig.Subsite.PiwikSiteID"]);
```
