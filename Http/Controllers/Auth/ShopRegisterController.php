<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Shop\Entities\ShopRegisteredUser;
use Modules\Shop\Http\Controllers\ShopRegisteredUserController;

class ShopRegisterController extends ShopRegisteredUserController
{
    public function showRegistrationForm()
    {
        return view('shop::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return redirect()->route('shop.dashboard', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code]);
    }
    protected function rules()
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:shop_users',
            'password' => 'required|min:8|confirmed',
        ];
    }
    protected function validationErrorMessages()
    {
        return [
            'name.required'      => 'The name is required.',
            'email.required'     => 'The email address is required.',
            'email.email'        => 'The email address is not valid.',
            'email.unique'       => 'The email address is already taken.',
            'password.required'  => 'The password is required.',
            'password.min'       => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
    protected function create(array $data)
    {
        return ShopRegisteredUser::create([
                                              'name'     => $data['name'],
                                              'email'    => $data['email'],
                                              'password' => Hash::make($data['password']),
                                          ]);
    }
}
