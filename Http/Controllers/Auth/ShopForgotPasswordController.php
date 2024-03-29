<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use App\Models\Settings\Post;
use App\Models\Settings\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Modules\Shop\Emails\ShopPasswordResetEmail;

class ShopForgotPasswordController extends ShopResetPasswordController
{
    public function showLinkRequestForm()
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Възстановяване на парола | ' . $currentLanguage->seo_title);
        SeoHelper::setDescription('Тук можете да Вашият имейл, на който да изпратим писмо с инструкции за въстановяване на Вашата парола.');

        return view('shop::auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $language    = LanguageHelper::getCurrentLanguage();
        $broker      = $this->broker();
        $user        = $broker->getUser($this->credentials(request()));
        $token       = $broker->createToken($user);
        $action_link = route('shop.password.reset', ['languageSlug' => $language->code, 'token' => $token, 'email' => $request->email]);
        $body = trans('shop::front.login.we_received_a_request_1') . $request->email . trans('shop::front.login.we_received_a_request_2') . url('/') . '. ' . trans('shop::front.login.you_can_reset_password');
        $settingsPost = Post::getSettings();
        $shopSettings = ShopSetting::where('key', 'shop_owner_name')->first();
        \Mail::send('shop::emails.reset_password', ['action_link' => $action_link, 'body' => $body], function ($message) use ($request, $settingsPost, $shopSettings) {
            $message->from($settingsPost->shop_orders_email, $shopSettings->value);
            $message->to($request->email, 'Your name')
                ->subject(trans('shop::front.login.reset_from_heading'));
        });

        return back()->with('success-message', trans('shop::front.login.we_sent_email'));
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
