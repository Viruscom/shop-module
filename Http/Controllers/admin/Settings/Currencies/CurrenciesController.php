<?php

    namespace Modules\Shop\Http\Controllers\admin\Settings\Currencies;

    use App\Http\Controllers\Controller;
    use GuzzleHttp\Client;
    use Modules\Shop\Entities\Settings\Currency;
    use Modules\Shop\Entities\Settings\InternalIntegrations\InternalIntegration;

    class CurrenciesController extends Controller
    {
        public function index()
        {
            $currencies = Currency::all();
            if ($currencies->isEmpty()) {
                $exchangeRateApi = InternalIntegration::where('key', 'exchangeRateApi')->first();
                if (is_null($exchangeRateApi)) {
                    return redirect()->back()->withErrors([trans('shop::admin.currencies.api_key_needed_error')]);
                }

                $exchangeRateApi = json_decode($exchangeRateApi->data);
                $url             = "https://v6.exchangerate-api.com/v6/{$exchangeRateApi->EXCHANGE_RATE_API_KEY}/codes";

                $response            = (new Client([
                                                       'verify' => false,
                                                   ]))->get($url);
                $supportedCurrencies = json_decode($response->getBody(), true);
                if ($supportedCurrencies['result'] == 'success') {
                    Currency::addSupportedCurrencies($supportedCurrencies['supported_codes']);
                }
            }

            return view('shop::admin.settings.currencies.index', [
                'currencies' => Currency::all()
            ]);
        }
    }
