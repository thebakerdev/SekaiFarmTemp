<?php

namespace App\Services;

use App;
use App\Services\GeoPlugin;
use App\Services\GeoLocation;

class Localization
{
    /**
     * Localize based on user selection. By Default localize by browser language
     *
     * @return void
     */
    public static function byBrowser()
    {
        $locale = App::getLocale();

        $browser_locale = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        
        $browser_locale = substr($browser_locale, 0, 2);

        if(session('locale')) {

            $locale = session('locale');
        } else {
            $locale = $browser_locale;
        }

        App::setLocale($locale);
    }

    /**
     * Set active state based on a given locale
     *
     * @param String $locale
     * @return void
     */
    public static function setActive($locale)
    {
        $default_locale = App::getLocale();

        // check if user selected a locale and use user selection
        if (session('locale')) {
            
            $default_locale = session('locale');
        }

        if ($locale === $default_locale) {
            
            return 'active';
        }
    }
}