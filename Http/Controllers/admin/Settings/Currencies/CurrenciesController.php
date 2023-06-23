<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\Currencies;

use App\Http\Controllers\Controller;
use Modules\Shop\Entities\Settings\Currency;

class CurrenciesController extends Controller
{
    public function index()
    {
        return view('shop::admin.settings.currencies.index', [
            'currencies' => Currency::all()
        ]);
    }
}
