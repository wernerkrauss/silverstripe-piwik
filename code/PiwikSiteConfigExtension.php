<?php

/**
 * Created by IntelliJ IDEA.
 * User: Werner M. Krauß <werner.krauss@netwerkstatt.at>
 * Date: 16.03.2016
 * Time: 08:53
 */
class PiwikSiteConfigExtension extends DataExtension
{
    private static $db = array(
        'PiwikSiteID' => 'Int'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Piwik', HeaderField::create('Piwik'));

        $siteIDField = NumericField::create('PiwikSiteID', _t('PiwikSiteConfigExtension.db_PiwikSiteID', 'PIWIK Site ID'))
            ->setDescription(_t('PiwikSiteConfigExtension.SiteIDDescription', 'The ID of this site, can be found in the generated PIWIK tracking code'));

        $fields->addFieldToTab('Root.Piwik', $siteIDField);
    }
}
