<?php

    namespace Modules\Shop\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Models\LawPages\LawPageTranslation;
    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Modules\Shop\Actions\BasketAction;
    use Modules\Shop\Entities\Basket\Basket;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Entities\Settings\City;
    use Modules\Shop\Entities\Settings\Country;
    use Modules\Shop\Entities\Settings\Delivery;
    use Modules\Shop\Entities\Settings\Main\CountrySale;
    use Modules\Shop\Entities\Settings\Payment;
    use Modules\Shop\Http\Requests\OrderRequest;
    use Modules\Shop\Models\Admin\Products\Product;

    class BasketController extends Controller
    {
        public static function storeOrder(OrderRequest $request, BasketAction $action)
        {
            $basket = Basket::getCurrent();
            if ($basket->basket_products->count() < 1) {
                return redirect(route('basket.index'))->withErrors([__('First add products to basket.')]);
            }

            $basketProducts = $basket->basket_products;
            $country        = Country::find($request->country_id);
            $city           = City::find($request->city_id);
            $basket->calculate($basketProducts, $country, $city);
            //TODO: Ima razlika, da sew vidi

            if ($basket->total != $request->total || $basket->total_discounted != $request->total_discounted || $basket->total_free_delivery != $request->total_free_delivery) {
                dd($basket->total . ' --- ' . $request->total . ' --- ' . $basket->total_discounted . ' --- ' . $request->total_discounted . ' --- ' . $basket->total_free_delivery . ' --- ' . $request->total_free_delivery);

                return redirect(route('basket.index'))->withError(__('There are changes.'));
            }

            //TODO: check quantities

            $request['discounts_to_apply'] = json_encode($basket->discounts_to_apply);
            $request['key']                = $basket->key;
            $request['user_id']            = $basket->user_id;
            $request['uid']                = Str::uuid();
            $request['paid_at']            = null;
            $request['delivered_at']       = null;
            $request['shipment_status']    = Order::SHIPMENT_WAITING;
            $request['payment_status']     = Order::PAYMENT_PENDING;
            $request['total_default']      = $basket->total_default;
            $request['promo_code']         = $basket->promo_code;

            if (is_null($basket->user_id)) {
                $request['guest_validation_code'] = Str::random(100);
            }

            $action->prepareShipmentAddressFields($request);
            $action->prepareCompanyFields($request);
            $order = $action->storeOrder($request, $basket);

            //            $action->decrementProductsQuantities($request, $basket);
            $basket->delete();
            $order->sendMailOrderPlacedToClient();
            $order->sendMailOrderPlacedToAdmin();

            //execute payment method?
            $payment = Payment::where('id', $request->payment_id)->where('active', 1)->get()->first();
            if (!empty($payment->class) && !empty($payment->execute_payment_method)) {
                return call_user_func_array(array($payment->class, $payment->execute_payment_method), array($order));
            }
            //        return redirect(route('basket.order.preview', ['id' => $order->id]))->with('success', __('Successful update'));
        }
        public function previewOrder($id)
        {
            $order = Order::where('id', $id)->where(function ($q) {
                if (Auth::guard('shop')->check()) {
                    return $q->where('user_id', Auth::guard('shop')->user()->id);
                } else {
                    return $q->where('key', $_COOKIE['sbuuid']);
                }
            })->get()->first();

            if (is_null($order)) {
                abort(404);
            }

            return view('shop::basket.order.preview', ['order' => $order]);
        }
        public function createOrder()
        {
            $country = Country::find(session()->get('country_id'));
            $city    = City::find(session()->get('city_id'));

            $basket = Basket::getCurrent();
            if ($basket->basket_products->count() < 1) {
                return redirect(route('basket.index'))->withError(__('First add products to basket.'));
            }
            $basket->calculate($basket->basket_products, $country, $city);
            $countries = Country::limit(50)->get();
            $cities    = City::limit(50)->get();

            $paymentMethods  = Payment::orderBy('position', 'asc')->get();
            $deliveryMethods = Delivery::orderBy('position', 'asc')->get();

            $countriesSale = CountrySale::with('country', 'country.cities')->get();

            return view('shop::basket.order.create', [
                'basket'          => $basket,
                'countries'       => $countries,
                'cities'          => $cities,
                'paymentMethods'  => $paymentMethods,
                'deliveryMethods' => $deliveryMethods,
                'countriesSale'   => $countriesSale,
                'termsOfUse'      => LawPageTranslation::where('url', 'obshchi-usloviya')->with('parent', 'parent.translations')->first()
            ]);
        }
        public function index()
        {
            //get countries and cities for selects
            $countries = Country::limit(50)->get();
            $cities    = City::limit(50)->get();
            //TODO: REmove from here
            session()->put("city_id", 1);
            session()->put("country_id", 1);
            //END
            //get current coutry and city once chosen
            $country = Country::find(session()->get('country_id'));
            $city    = City::find(session()->get('city_id'));

            $basket = Basket::getCurrent();
            $basket->calculate($basket->basket_products, $country, $city);

            return view('shop::basket.index', ['basket' => $basket, 'countries' => $countries, 'cities' => $cities]);
        }
        public function addProduct(Request $request)//can be used for add,increment,decrement,delete
        {
            if (!isset($request->product_id)) {
                return redirect()->back();//no message need no regular user should evere be here!
            }

            $product = Product::findOrFail($request->product_id);

            $basket = Basket::getCurrent();
            if (!isset($request->product_quantity)) {// when we want to increment with 1, product_quantity showld not be present in the request
                $request['product_quantity'] = 1;
            }

            //delete case
            if ($request->product_quantity == 0) {
                $basket->basket_products()->where('product_id', $product->id)->delete();

                return redirect()->back();
            }

            //decrement case
            if ($request->product_quantity == -1) {
                $basketProduct = $basket->basket_products()->where('product_id', $product->id)->first();
                if (is_null($basketProduct)) {
                    return redirect()->back();// we do not have what to decrement
                }

                if ($basketProduct->product_quantity == 1) {
                    $basket->basket_products()->where('product_id', $product->id)->delete();
                } else {
                    $basketProduct->decrement('product_quantity', 1);
                }

                return redirect()->back();
            }

            //create/increment case
            $basketProduct = $basket->basket_products()->where('product_id', $product->id)->first();
            if (is_null($basketProduct)) {
                $basket->basket_products()->create(['product_id' => $product->id, 'product_quantity' => $request->product_quantity]);
            } else {
                $basketProduct->increment('product_quantity', $request->product_quantity);
            }

            return redirect()->route('basket.index');
        }

        public function applyPromoCode(Request $request)
        {
            if (!isset($request->promo_code) || empty($request->promo_code)) {
                return back()->withErrors(['Няма промокод или не е валиден']);
            }
            $basket             = Basket::getCurrent();
            $currentPromoCode   = $basket->promo_code;
            $basket->promo_code = $request->promo_code;
            $basket->save();
            $country = Country::find(session()->get('country_id'));
            $city    = City::find(session()->get('city_id'));
            $basket->calculate($basket->basket_products, $country, $city);
            //
            $promoCodeValid = $basket->isCurrentPromoCodeValid();
            if (!$promoCodeValid) {
                $basket             = Basket::getCurrent();
                $basket->promo_code = $currentPromoCode;
                $basket->save();
                $basket->calculate($basket->basket_products, $country, $city);

                return redirect()->back()->withErrors(['Невалиден промо код']);
            }

            return redirect()->route('basket.index')->with('success-message', 'Успешно приложен промо код');
        }

        public function deletePromoCode()
        {
            $basket             = Basket::getCurrent();
            $basket->promo_code = null;
            $basket->save();
            $country = Country::find(session()->get('country_id'));
            $city    = City::find(session()->get('city_id'));
            $basket->calculate($basket->basket_products, $country, $city);

            return redirect()->route('basket.index')->with('success-message', 'Успешно изтрихте промо код');
        }
    }
