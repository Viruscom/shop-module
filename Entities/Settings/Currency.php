<?php

    namespace Modules\Shop\Entities\Settings;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class Currency extends Model
    {
        protected $table = "currencies";
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'code',
            'name',
        ];

        public static function addSupportedCurrencies($supportedCodes)
        {
            foreach ($supportedCodes as $key => $currencyArray) {
                self::firstOrCreate(['code' => $currencyArray[0]], ['name' => $currencyArray[1]]);
            }
        }

        public function getAllExchangeRates(): HasMany
        {
            $rates = $this->hasMany(CurrencyRate::class)->where('base_currency', $this->code);

            if (!$rates->exists()) {
                //TODO: Call Exchange Rate API to get and update currency rates for base_currency
            }
            if ($rates->first()->next_update > Carbon::now()->timestamp) {
                //TODO: Call Exchange Rate API to get and update currency rate
            }

            return $rates;
        }
        public function exchangeRate($targetCurrency): HasOne
        {
            $rate = $this->hasOne(CurrencyRate::class)->where('base_currency', $this->code)->where('target_currency', $targetCurrency);
            if (!$rate->exists()) {
                //TODO: Call Exchange Rate API to get and update currency rate
            }
            if ($rate->next_update > Carbon::now()->timestamp) {
                //TODO: Call Exchange Rate API to get and update currency rate
            }

            return $rate;
        }
    }
