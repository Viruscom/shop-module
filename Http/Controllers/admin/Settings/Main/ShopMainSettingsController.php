<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\Main;

use App\Http\Controllers\Controller;
use App\Models\Settings\Post;
use Illuminate\Contracts\Support\Renderable;
use Modules\Shop\Entities\Settings\Country;
use Modules\Shop\Entities\Settings\Main\CountrySale;
use Modules\Shop\Http\Requests\Admin\Settings\MainSettingsUpdateRequest;

class ShopMainSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $postSetting = Post::getSettings();
        if (is_null($postSetting)) {
            $postSetting = Post::storeEmptyRow();
        }

        $countries      = Country::orderBy('name', 'asc')->get();
        $salesCountries = CountrySale::pluck('country_id')->toArray();

        return view('shop::admin.settings.main.index', compact('postSetting', 'countries', 'salesCountries'));
    }

    public function update(MainSettingsUpdateRequest $request)
    {
        $postSetting = Post::first();

        $postSetting->update(['shop_orders_email' => $request->shop_orders_email]);
        Post::updateCache();

        CountrySale::truncate();
        foreach ($request->sales_countries as $key => $countryId) {
            CountrySale::create(['country_id' => $countryId]);
        }

        return redirect()->route('admin.shop.settings.index')->with('success-message', 'admin.common.successful_edit');
    }
}
