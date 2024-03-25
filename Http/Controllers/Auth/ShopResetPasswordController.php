<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Modules\Shop\Http\Controllers\ShopRegisteredUserController;

class ShopResetPasswordController extends ShopRegisteredUserController
{
    public function showResetForm(Request $request, $languageSlug, $token = null)
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Възстановяване на парола | ' . $currentLanguage->seo_title);
        SeoHelper::setDescription('Тук можете да Вашият имейл, на който да изпратим писмо с инструкции за въстановяване на Вашата парола.');

        return view('shop::auth.passwords.reset')->with(
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
            return redirect()->route('shop.login', ['languageSlug' => LanguageHelper::getCurrentLanguage()->code])->with('status', __($response));
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
            'token.required'     => trans('shop::front.login.reset_password_token_required'),
            'email.required'     => trans('shop::front.login.email_required'),
            'email.email'        => trans('shop::front.login.email_invalid'),
            'password.required'  => trans('shop::front.login.password_required'),
            'password.min'       => trans('shop::front.login.password_min'),
            'password.confirmed' => trans('shop::front.login.password_confirmed'),
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
