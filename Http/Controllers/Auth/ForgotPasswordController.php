<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Възстановяване на парола | ' . $currentLanguage->seo_title);
        SeoHelper::setDescription('Тук можете да Вашият имейл, на който да изпратим писмо с инструкции за въстановяване на Вашата парола.');

        return view('shop::auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()->withErrors(
                ['email' => trans($response)]
            );
    }
}
