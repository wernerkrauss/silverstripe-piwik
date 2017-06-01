<?php

namespace Netwerkstatt\Piwik\Extensions;


use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Dev\DevBuildController;
use SilverStripe\Dev\DevelopmentAdmin;
use SilverStripe\ORM\DatabaseAdmin;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;


class PiwikExtension extends Extension
{

    /**
     * @var string the url to the server, without protocol and trailing slash, e.g. //piwik.foo.com/
     */
    private static $piwik_server = '//piwik.foo.com/';

    /**
     * @var int the piwik site id
     */
    private static $piwik_site_id = 0;

    /**
     * @var bool Do you want tracking code in dev environments?
     */
    private static $show_on_dev = false;

    /**
     * @var bool do you want tracking code in test environments?
     */
    private static $show_on_test = false;

    /**
     * @var bool we want tracking code in live environments
     */
    private static $show_on_live = true;

    /**
     * @var bool include tracking code on contentcontrollerInit
     */
    private static $auto_include = true;

    /**
     * @var bool include tracking code automatically in backend, subclasses of LeftAndMain
     */
    private static $include_in_backend = false;

    private static $excluded_controllers = [
        DevelopmentAdmin::class,
        DevBuildController::class,
        DatabaseAdmin::class
    ];

    /**
     * includes the piwik tracking code when ContentController initializes...
     * @todo: get it working ;)
     */
    public function onAfterInit(&$controller)
    {
        if ($this->autoInclude() && $js = $this->getPiwik(false)) {
            Requirements::customScript($js, 'piwiktrackingcode');
        }
    }

    /**
     * generates piwik tracking code out of config vars and Piwik.ss template
     * @param $wrap wrap inside <script> tags, e.g. for templates
     */
    public function getPiwik($wrap = true)
    {
        if (Director::isDev() && !Config::inst()->get(PiwikExtension::class, 'show_on_dev')) {
            return false;
        }
        if (Director::isTest() && !Config::inst()->get(PiwikExtension::class, 'show_on_test')) {
            return false;
        }
        if (Director::isLive() && !Config::inst()->get(PiwikExtension::class, 'show_on_live')) {
            return false;
        }

        //used for overwriting defaults in SiteConfig, e.g. for different SiteIDs in a Subsite installation
        $currentSiteConfig = Controller::curr()->hasMethod('getSiteConfig')
            ? Controller::curr()->getSiteConfig()
            : SiteConfig::current_site_config();


        $data = [
            'WrapInJsTags' => $wrap,
            'URL' => Config::inst()->get(PiwikExtension::class, 'piwik_server'),
            'SiteID' => Config::inst()->get(PiwikExtension::class, 'piwik_site_id'),
            'SiteConfig' => $currentSiteConfig
        ];

        return ArrayData::create($data)->renderWith(['Netwerkstatt\\Piwik\\Piwik']);
    }

    /**
     * Helper function to define if tracking code should be included automatically
     * @return bool
     */
    public function autoInclude()
    {
        if (!Config::inst()->get(PiwikExtension::class, 'auto_include')) {
            return false;
        }

        if (Director::is_cli()) {
            return false;
        }

        //don't include on dev/build etc...
        if ($this->isBlockedController()) {
            return false;
        }

        if ($this->isBackend() && !Config::inst()->get(PiwikExtension::class, 'include_in_backend')) {
            return false;
        }

        return true;
    }


    /**
     * @return bool is the extended controller an instance of LeftAndMain
     */
    public function isBackend()
    {
        return Controller::curr() instanceof LeftAndMain;
    }

    /**
     * Checks if the current controller is in a list of blocked controllers (e.g. dev/build)
     *
     * @return mixed
     */
    public function isBlockedController()
    {
        return max(array_map(
            function ($name) {
                return Controller::curr() instanceof $name;
            },
            Config::inst()->get(PiwikExtension::class, 'excluded_controllers')
        ));
    }
}
