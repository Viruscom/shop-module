<?php

namespace Modules\Shop\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function show()
    {
        return view('auth.verify');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
