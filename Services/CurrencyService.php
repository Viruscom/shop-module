<?php

namespace Modules\Shop\Services;

use Modules\Shop\Entities\Settings\Main\CountrySale;

class CurrencyService
{
    public static function formatPrice($price, $currencyCode = null): string
    {
        if (!is_null($currencyCode)) {

            return number_format($price, 2, ',', ' ');
        }

        return number_format($price, 2, ',', ' ');
    }

    public static function setUserLocation()
    {

    }

    public static function getUserGeoLocationByIp()
    {

    }

    public static function setUserCurrency($currencyCode = null)
    {
        if (!is_null($currencyCode)) {
            //TODO: set choosed currency
        }

        //Set default currency
        return CountrySale::class->with('country')::first()->currency;
    }
}
