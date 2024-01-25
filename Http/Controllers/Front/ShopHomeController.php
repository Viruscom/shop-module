<?php

namespace Modules\Shop\Http\Controllers\Front;

use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use App\Helpers\WebsiteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Entities\Orders\Order;

class ShopHomeController extends Controller
{
    public function dashboard()
    {
        return view('shop::front.registered_users.profile.dashboard', ['registeredUser' => Auth::guard('shop')->user()]);
    }

    public function personalData()
    {
        return view('shop::front.registered_users.profile.personal_data', ['registeredUser' => Auth::guard('shop')->user()]);
    }

    public function showGuestOrder($orderUid)
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Преглед на поръчка | ' . $currentLanguage->seo_title);

        $order = Order::where('uid', $orderUid)->with('order_products', 'payment', 'delivery', 'documents', 'city')->first();
        WebsiteHelper::redirectBackIfNull($order);

        return view('shop::front.guests.orders.show', compact('order'));
    }
}
