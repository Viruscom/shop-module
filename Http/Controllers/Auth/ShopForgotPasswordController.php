<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Modules\Shop\Emails\ShopPasswordResetEmail;

class ShopForgotPasswordController extends ShopResetPasswordController
{
    public function showLinkRequestForm()
    {
        return view('shop::auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $language = LanguageHelper::getCurrentLanguage();
        $broker   = $this->broker();
        $user     = $broker->getUser($this->credentials(request()));
        $token    = $broker->createToken($user);
        //TODO: Да се сложат необходимите преводи
        $action_link = route('shop.password.reset', ['languageSlug' => $language->code, 'token' => $token, 'email' => $request->email]);
        $body        = "We are received a request to reset the password for <b>Your app Name </b> account associated with " . $request->email . ". You can reset your password by clicking the link below";

        \Mail::send('shop::emails.reset_password', ['action_link' => $action_link, 'body' => $body], function ($message) use ($request) {
            //TODO: Да се закачи имайла за пращане от системните настройки, да се вземе името на магазина от основните настройки
            $message->from('system@almatherapy.bg', env('app_name'));
            $message->to($request->email, 'Your name')
                ->subject(trans('messages.reset_password'));
        });

        return back()->with('success-message', 'Изпратихме e-mail на посочената от Вас електронна поща!');
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
