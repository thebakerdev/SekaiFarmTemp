<?php

namespace App;

class country {


    public static function getCountryList()
    {
        $countries =  config('dropdowns.countries_asean') + config('dropdowns.countries');

        return $countries;
    }
}
