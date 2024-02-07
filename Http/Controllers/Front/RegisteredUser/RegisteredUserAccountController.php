<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\LanguageHelper;
    use App\Helpers\SeoHelper;
    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Exception;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\ClientException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Entities\Settings\InternalIntegrations\InternalIntegration;
    use Modules\Shop\Http\Requests\Front\RegisteredUser\PersonalDataUpdateRequest;
    use Modules\Shop\Models\Admin\Products\Product;

    class RegisteredUserAccountController extends Controller
    {
        public function dashboard()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Моят профил | ' . $currentLanguage->seo_title);

            $registeredUser = Auth::guard('shop')->user();
            session()->put('regUser', $registeredUser);

            return view('shop::front.registered_users.profile.dashboard', [
                'registeredUser'         => $registeredUser,
                'orders'                 => $registeredUser->orders()->limit(5)->get(),
                'defaultShipmentAddress' => $registeredUser->shipmentAddresses()->isDeleted(false)->isDefault(true)->with('city')->first(),
                'defaultPaymentAddress'  => $registeredUser->paymentAddresses()->isDeleted(false)->isDefault(true)->with('city')->first(),
            ]);
        }

        public function personalData()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Лични данни | ' . $currentLanguage->seo_title);

            return view('shop::front.registered_users.profile.personal_data', ['registeredUser' => Auth::guard('shop')->user()]);
        }
        public function getFavoriteProducts()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Любими | ' . $currentLanguage->seo_title);
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.favorite_products', ['registeredUser' => $registeredUser, 'favoriteProducts' => $registeredUser->favoriteProducts()->with('product', 'product.translations', 'product.measureUnit')->get()]);
        }
        public function favoriteProductStore($languageslug, $id, Request $request)
        {
            $product = Product::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $registeredUser = Auth::guard('shop')->user();
            $registeredUser->favoriteProducts()->create(['user_id' => $registeredUser->id, 'product_id' => $product->id]);

            return redirect()->back()->with('success', trans('admin.common.successful_create'));
        }
        public function favoriteProductDelete($languageslug, $id, Request $request)
        {
            $product = Product::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $registeredUser = Auth::guard('shop')->user();
            $favProduct     = $registeredUser->favoriteProducts()->where('user_id', $registeredUser->id)->where('product_id', $product->id)->first();
            WebsiteHelper::redirectBackIfNull($favProduct);

            $favProduct->delete();

            return redirect()->back()->with('success', trans('admin.common.successful_delete'));
        }
        public function getOrders()
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Поръчки | ' . $currentLanguage->seo_title);

            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.orders.index', compact('registeredUser'));
        }
        public function showOrderDetails($languageSlug, $order_hash)
        {
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Преглед на поръчка | ' . $currentLanguage->seo_title);

            $order = Order::where('id', decrypt($order_hash))->with('order_products', 'payment', 'delivery', 'documents', 'city')->first();
            WebsiteHelper::redirectBackIfNull($order);

            return view('shop::front.registered_users.profile.orders.show', compact('order'));
        }
        public function subscribe()
        {
            $mailChimpSettings = json_decode(InternalIntegration::where('key', 'mailChimp')->first()->data);
            $registeredUser    = Auth::guard('shop')->user();

            $client = new Client([
                                                 'base_uri' => 'https://' . $mailChimpSettings->MAILCHIMP_API_SERVER . '.api.mailchimp.com/3.0/',
                                                 'verify'   => false,
                                             ]);

            $subscriberHash = md5(strtolower($registeredUser->email));

            try {
                $response = $client->request('GET', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                    'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                ]);

                $body = json_decode($response->getBody(), true);
                if ($body['status'] === 'subscribed') {
                    $client->request('PATCH', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                        'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                        'json' => ['status' => 'unsubscribed'],
                    ]);

                    $registeredUser->update(['newsletter_subscribed' => false]);

                    return redirect()->back()->with(['success-message' => 'Вие успешно се отписахте.']);
                } elseif ($body['status'] === 'unsubscribed') {
                    $client->request('PATCH', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                        'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                        'json' => ['status' => 'subscribed'],
                    ]);

                    $registeredUser->update(['newsletter_subscribed' => true]);

                    return redirect()->back()->with(['success-message' => 'Успешно се абонирахте отново.']);
                } else {
                    return response()->json(['message' => 'Вашият статус е: ' . $body['status'] . '. Моля, свържете се с нас за съдействие.'], 400);
                }
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() === 404) {
                    try {
                        $client->request('POST', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members', [
                            'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                            'json' => [
                                'email_address' => $registeredUser->email,
                                'status'        => 'subscribed',
                            ],
                        ]);

                        $registeredUser->update(['newsletter_subscribed' => true]);

                        return redirect()->back()->with(['success-message' => 'Успешно се абонирахте.']);
                    } catch (Exception $e) {
                        return response()->json(['message' => $e->getMessage()], 400);
                    }
                } else {
                    return response()->json(['message' => $e->getMessage()], 400);
                }
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()], 400);
            }
        }
        public function update($languageSlug, $id, PersonalDataUpdateRequest $request)
        {
            if (Auth::guard('shop')->user()->id != decrypt($id)) {
                return back()->withErrors(['shop::front.registered_user_profile.user_not_the_same']);
            }
            Auth::guard('shop')->user()->update($request->all());

            return back()->withInput()->with('success-message', 'admin.common.successful_edit');
        }

    }
