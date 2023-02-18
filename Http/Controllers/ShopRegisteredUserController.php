<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Entities\ShopRegisteredUser;

class ShopRegisteredUserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('shop::front.login.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
                                                'name'     => 'required|string|max:255',
                                                'email'    => 'required|string|email|max:255|unique:shop_registered_users',
                                                'password' => 'required|string|min:8|confirmed',
                                            ]);

        $user           = new ShopRegisteredUser();
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        Auth::login($user);

        return redirect()->intended('/');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
                                              'email'    => 'required|string|email',
                                              'password' => 'required|string',
                                          ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
                                      'email' => 'The provided credentials do not match our records.',
                                  ]);
    }
    public function showLoginForm()
    {
        return view('shop::front.login.login');
    }
}
