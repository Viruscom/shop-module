<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\Main;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class ShopMainSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('shop::admin.settings.main.index');
    }
}
