<?php

namespace Modules\Shop\Http\Controllers\Front;

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
        $order = Order::where('uid', $orderUid)->first();
        WebsiteHelper::abortIfNull($order);

        return view('shop::front.guests.orders.verification_form');
    }

    public function showGuestOrderView($orderUid, Request $request)
    {
        $order = Order::where('uid', $orderUid)->first();
        WebsiteHelper::abortIfNull($order);

        if (!$order->showGuestOrderValidation($request)) {
            WebsiteHelper::abortIfNull($order);
        }

        return view('shop::front.guests.orders.show', compact('order'));
    }
}
