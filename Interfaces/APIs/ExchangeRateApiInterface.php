<?php

namespace Modules\Shop\Interfaces\APIs;

interface ExchangeRateApiInterface
{
    public function getApiKey();
    public function getBaseUrl();
    public function getAllCurrencies();
    public function getExchangeRate($currencyCode);
}
