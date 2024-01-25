<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Helpers\LanguageHelper;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function showResetForm(Request $request, $token = null)
    {
        $currentLanguage = LanguageHelper::getCurrentLanguage();
        SeoHelper::setTitle('Възстановяване на парола | ' . $currentLanguage->seo_title);
        SeoHelper::setDescription('Тук можете да Вашият имейл, на който да изпратим писмо с инструкции за въстановяване на Вашата парола.');

        return view('shop::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
