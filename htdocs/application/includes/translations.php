<?php

namespace App;

use Scabbia\Extensions\Http\Request;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\LarouxJs\LarouxJs;

/**
 * @ignore
 */
class Translations
{
    /**
     * @ignore
     */
    public static function fakeFunction()
    {
        _('Sunday');
        _('Monday');
        _('Tuesday');
        _('Wednesday');
        _('Thursday');
        _('Friday');
        _('Saturday');
    }

    /**
     * @ignore
     */
    public static function javascriptTranslations()
    {
        $tLanguage = Request::cookie('lang', 'en');
        I18n::setLanguage($tLanguage);

        $tTranslations = array(
            'sunday' => I18n::_('Sunday'),
            'monday' => I18n::_('Monday'),
            'tuesday' => I18n::_('Tuesday'),
            'wednesday' => I18n::_('Wednesday'),
            'thursday' => I18n::_('Thursday'),
            'friday' => I18n::_('Friday'),
            'saturday' => I18n::_('Saturday'),

            'change' => I18n::_('Change'),
            'remove' => I18n::_('Remove')
        );

        LarouxJs::addToDictionary($tTranslations);
    }
}
