<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\Main;

use App\Http\Controllers\Controller;
use App\Models\Settings\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Settings\Country;
use Modules\Shop\Entities\Settings\Main\CountrySale;

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

    public function update(Request $request)
    {
        $postSetting = Post::first();

        $postSetting->update($request->all());
        Post::updateCache();
    }
}
