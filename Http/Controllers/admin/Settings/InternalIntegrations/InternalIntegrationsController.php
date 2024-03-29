<?php

    namespace Modules\Shop\Http\Controllers\admin\Settings\InternalIntegrations;

    use App\Http\Controllers\Controller;
    use App\Models\Settings\Application;
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

        public function exchangeRateEdit()
        {
            $exchangeRateApi = InternalIntegration::where('key', 'exchangeRateApi')->first();
            if (is_null($exchangeRateApi)) {
                $exchangeRateApi = InternalIntegration::create(['key' => 'exchangeRateApi', 'data' => json_encode(['EXCHANGE_RATE_API_KEY' => ''])]);
            }
            $exchangeRateApi = json_decode($exchangeRateApi->data);

            return view('shop::admin.settings.internal_integrations.exchange_rate.index', compact('exchangeRateApi'));
        }

        public function exchangeRateUpdate(Request $request)
        {
            $exchangeRateApi = InternalIntegration::where('key', 'exchangeRateApi')->first();

            $exchangeRateApi->update(['data' => json_encode(['EXCHANGE_RATE_API_KEY' => $request->EXCHANGE_RATE_API_KEY])]);

            return back()->with('success-message', trans('admin.common.successful_edit'));
        }

        public function facebookConversationApiEdit()
        {
            $facebookConversationApi = InternalIntegration::where('key', 'facebookConversationApi')->first();
            $applicationSettings     = Application::first();
            if (is_null($applicationSettings)) {
                $applicationSettings = Application::storeEmptyRow();
            }

            if (is_null($facebookConversationApi)) {
                $facebookConversationApi = InternalIntegration::create(['key' => 'facebookConversationApi', 'data' => json_encode(['ACCESS_TOKEN' => '', 'PIXEL_ID' => $applicationSettings->facebook_pixel_id])]);
            }

            $facebookConversationApi = json_decode($facebookConversationApi->data);

            return view('shop::admin.settings.internal_integrations.facebook.conversation_api.index', compact('facebookConversationApi'));
        }

        public function facebookConversationApiUpdate(Request $request)
        {
            $facebookConversationApi = InternalIntegration::where('key', 'facebookConversationApi')->first();
            $applicationSettings     = Application::first();
            if (is_null($applicationSettings) || $applicationSettings->facebook_pixel_id == '') {
                return redirect()->back()->withInput()->withErrors(['shop::admin.facebook_conversation_api.pixel_id_error']);
            }

            $facebookConversationApi->update(['data' => json_encode(['ACCESS_TOKEN' => $request->EXCHANGE_RATE_API_KEY])]);

            return back()->with('success-message', trans('admin.common.successful_edit'));
        }
    }
