<?php

namespace Modules\Shop\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ShopForgotPasswordController extends ShopResetPasswordController
{
    public function showLinkRequestForm()
    {
        return view('shop::auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(
                ['email' => [__($response)]]
            );
    }
    protected function rules()
    {
        return [
            'email' => 'required|email|exists:shop_registered_users',
        ];
    }
    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'The email address is required.',
            'email.email'    => 'The email address is not valid.',
            'email.exists'   => 'The email address is not registered.',
        ];
    }
    protected function broker()
    {
        return Password::broker('shop_users');
    }
}
