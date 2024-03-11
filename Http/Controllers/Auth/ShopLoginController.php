<?php

namespace Modules\Shop\Http\Controllers\Auth;


use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopLoginController extends ShopRegisterController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Вход в потребителски профил | ' . $currentLanguage->seo_title);
        SeoHelper::setDescription('Тук можете да влезете в своя профил.');

        if (!is_null(Auth::guard('shop')->user())) {
            return redirect()->route('shop.dashboard', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code]);
        }

        return view('shop::auth.login');
    }
    protected function guard()
    {
        return Auth::guard('shop');
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('shop.login', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code]);
    }

    protected function authenticated(Request $request, $user)
    {
        $defaultAddress = $user->shipmentAddresses()->where('is_default', true)->first();

        if (!is_null($defaultAddress)) {
            session()->put('validated_shipment_address_object', $defaultAddress);
            session()->put('validated_shipment_address_id', $defaultAddress->id);
            session()->put('validated_delivery_address', $defaultAddress->street);
            session()->put('validated_zip_code', $defaultAddress->zip_code);
            session()->put('validated_street_number', $defaultAddress->street_number);
        }
        return redirect()->route('shop.dashboard', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code]);
    }
}
