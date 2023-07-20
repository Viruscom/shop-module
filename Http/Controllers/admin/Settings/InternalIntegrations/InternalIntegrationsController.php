<?php

namespace Modules\Shop\Http\Controllers\admin\Settings\InternalIntegrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Settings\InternalIntegrations\InternalIntegration;

class InternalIntegrationsController extends Controller
{
    public function index()
    {
        return view('shop::admin.settings.internal_integrations.index');
    }

    public function mailChimpEdit()
    {
        $mailChimp = InternalIntegration::where('key', 'mailChimp')->first();
        if (is_null($mailChimp)) {
            $mailChimp = InternalIntegration::create(['key' => 'mailChimp', 'data' => json_encode(['MAILCHIMP_API_KEY' => '', 'MAILCHIMP_API_SERVER' => '', 'MAILCHIMP_LIST_ID' => ''])]);
        }
        $mailChimp = json_decode($mailChimp->data);

        return view('shop::admin.settings.internal_integrations.mail_chimp.index', compact('mailChimp'));
    }

    public function mailChimpUpdate(Request $request)
    {
        $mailChimp = InternalIntegration::where('key', 'mailChimp')->first();

        $mailChimp->update(['data' => json_encode(['MAILCHIMP_API_KEY' => $request->MAILCHIMP_API_KEY, 'MAILCHIMP_API_SERVER' => $request->MAILCHIMP_API_SERVER, 'MAILCHIMP_LIST_ID' => $request->MAILCHIMP_LIST_ID])]);

        return back()->with('success-message', trans('admin.common.successful_edit'));
    }
}
