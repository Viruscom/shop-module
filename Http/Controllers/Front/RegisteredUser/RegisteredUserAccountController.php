<?php

    namespace Modules\Shop\Http\Controllers\Front\RegisteredUser;

    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use Exception;
    use GuzzleHttp\Client;
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
            return view('shop::front.registered_users.profile.personal_data', ['registeredUser' => Auth::guard('shop')->user()]);
        }
        public function getFavoriteProducts()
        {
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
            $registeredUser = Auth::guard('shop')->user();

            return view('shop::front.registered_users.profile.orders.index', compact('registeredUser'));
        }
        public function showOrderDetails($languageSlug, $order_hash)
        {
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
                                     'verify'   => false
                                 ]);

            $subscriberHash = md5(strtolower($registeredUser->email));

            try {
                // Проверка дали абонатът вече съществува
                $response = $client->request('GET', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                    'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                ]);

                $body = json_decode($response->getBody(), true);
                // Ако статусът на абонат е "subscribed", той вече е абониран
                if ($body['status'] === 'subscribed') {
                    // Отписване на абоната
                    $client->request('PATCH', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                        'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                        'json' => ['status' => 'unsubscribed'],
                    ]);

                    $registeredUser->update(['newsletter_subscribed' => false]);

                    return redirect()->back()->with(['success-message' => 'Вие успешно се абонирахте.']);
                }

                // Абониране на потребителя
                try {
                    $subscriberHash = md5(strtolower($registeredUser->email));

                    // Опитваме се да актуализираме съществуващ абонат
                    $client->request('PATCH', 'lists/' . $mailChimpSettings->MAILCHIMP_LIST_ID . '/members/' . $subscriberHash, [
                        'auth' => ['anystring', $mailChimpSettings->MAILCHIMP_API_KEY],
                        'json' => [
                            'status' => 'subscribed',
                        ],
                    ]);

                    $registeredUser->update(['newsletter_subscribed' => true]);

                    return redirect()->back()->with(['success-message' => 'Успешно се абонирахте.']);
                } catch (Exception $e) {
                    // Ако има грешка и тя е, защото абонатът не съществува
                    if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 404) {
                        try {
                            // Абониране на нов потребител
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
