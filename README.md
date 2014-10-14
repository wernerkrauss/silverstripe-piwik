# Silverstripe Piwik Analytics Module

This module includes a piwik analytics javascript at the bottom of your page.

It's configurable via config API, you can change the included Javascript by overwriting the Piwik.ss template.


##Requirements
  * Silverstripe > 3.1
  
##Features
  * Includes piwik tracking code to your page. You can configure if it's included automatically or manually by calling $Piwik inside your template
  * By default only included in frontend pages
  * By default only included in Live mode
  
##Configuration
```yml
PiwikExtension:
  piwik_server: '//logs.example.com/' #domain without protocol an trailing slash
  piwik_site_id: 123 #the id defined by your piwik install
  show_on_dev: false #default: don't show in dev mode
  show_on_test: false #default: don't show in test mode
  show_on_live: true #default: show in live mode
  auto_include: true #default: include automatically
  include_in_backend: false #default: don't include in backend
```

