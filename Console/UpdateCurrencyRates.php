<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Shop\Entities\Settings\CurrencyRate;

class UpdateCurrencyRates extends Command
{
    protected $signature   = 'update:currency-rates';
    protected $description = 'Update currency rates from API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::get('https://your-exchange-rate-api-url'); // Replace with your API URL
        $data     = $response->json();

        if ($data['result'] !== 'success') {
            $this->error('API call failed');

            return;
        }

        $now = Carbon::now();
        foreach ($data['conversion_rates'] as $currency => $rate) {
            CurrencyRate::updateOrCreate(
                ['base_currency' => $data['base_code'], 'target_currency' => $currency],
                ['rate' => $rate, 'last_update' => $now, 'next_update' => Carbon::createFromTimestamp($data['time_next_update_unix'])]
            );
        }

        $this->info('Currency rates updated successfully');
    }
}
