<?php

namespace Modules\Shop\Interfaces;

interface CurrencyActionInterface
{
    public function getAllCurrencies();
    public function updateAllCurrenciesList();
    public function getCurrencyRate($currencyCode);

}
