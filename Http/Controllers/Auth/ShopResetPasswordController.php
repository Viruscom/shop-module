<?php

namespace Modules\Shop\Http\Controllers\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Modules\Shop\Http\Controllers\ShopRegisteredUserController;

class ShopResetPasswordController extends ShopRegisteredUserController
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('shop::reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('shop.login')->with('status', __($response));
        }

        throw ValidationException::withMessages([
                                                    'email' => [__($response)]
                                                ]);
    }
    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }
    protected function validationErrorMessages()
    {
        return [
            'token.required'     => 'The password reset token is required.',
            'email.required'     => 'The email address is required.',
            'email.email'        => 'The email address is not valid.',
            'password.required'  => 'The new password is required.',
            'password.min'       => 'The new password must be at least 8 characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ];
    }

    protected function broker()
    {
        return Password::broker('shop_users');
    }
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }
}
