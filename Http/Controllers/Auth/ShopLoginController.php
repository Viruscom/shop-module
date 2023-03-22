<?php

namespace Modules\Shop\Http\Controllers\Auth;

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
        return view('shop::auth.login');
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('shop.login');
    }
    protected function guard()
    {
        return Auth::guard('shop');
    }
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('shop.dashboard');
    }
}
