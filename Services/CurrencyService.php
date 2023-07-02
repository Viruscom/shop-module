<?php

namespace Modules\Shop\Services;

class CurrencyService
{
    public static function formatPrice($price, $currencyCode = null): string
    {
        if (!is_null($currencyCode)) {
            return number_format((float)$price, 2, ',', ' ');
        }

        return number_format((float)$price, 2, ',', ' ');
    }
}
