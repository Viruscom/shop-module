<?php

    namespace Modules\Shop\Http\Controllers;

    use App\Helpers\LanguageHelper;
    use App\Helpers\SeoHelper;
    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use App\Models\LawPages\LawPageTranslation;
    use Artesaos\SEOTools\Facades\SEOTools;
    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Modules\Shop\Actions\BasketAction;
    use Modules\Shop\Entities\Basket\Basket;
    use Modules\Shop\Entities\Basket\BasketProduct;
    use Modules\Shop\Entities\Basket\BasketProductAdditive;
    use Modules\Shop\Entities\Basket\BasketProductCollection;
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
            $country        = Country::find(session()->get('country_id'));
            if (is_null($country)) {
                return redirect(route('basket.index'))->withErrors([__('Нещо се обърка. Моля, опитайте отново или се свържете с администратор.')]);
            }

            $city = City::find(session()->get('city_id'));
            if (is_null($city)) {
                return redirect(route('basket.index'))->withErrors([__('Нещо се обърка. Моля, опитайте отново или се свържете с администратор.')]);
            }

            $basket->calculate($basketProducts, $country, $city);
            //TODO: Ima razlika, da sew vidi

            //            if ($basket->total != $request->total || $basket->total_discounted != $request->total_discounted || $basket->total_free_delivery != $request->total_free_delivery) {
            //                return redirect(route('basket.index'))->withError(__('There are changes.'));
            //            }

            //TODO: check quantities
            $request['discounts_to_apply']  = json_encode($basket->discounts_to_apply);
            $request['key']                 = $basket->key;
            $request['user_id']             = $basket->user_id;
            $request['uid']                 = Str::uuid();
            $request['paid_at']             = null;
            $request['delivered_at']        = null;
            $request['shipment_status']     = Order::SHIPMENT_WAITING;
            $request['payment_status']      = Order::PAYMENT_PENDING;
            $request['total_default']       = $basket->total_default;
            $request['total']               = $basket->total;
            $request['total_discounted']    = $basket->total_discounted;
            $request['total_free_delivery'] = $basket->total_free_delivery;
            $request['promo_code']          = $basket->promo_code;
            $request['invoice_required']    = (bool)$request->has('invoice_required') && $request->invoice_required == 'on';
            $request['with_utensils']       = (bool)$request->has('with_utensils') && $request->with_utensils == 'on';
            $request['comment']             = $request->comment;
            if (!is_null(session()->get('validated_shipment_address_id'))) {
                $request['shipment_address_id'] = session()->get('validated_shipment_address_id');
            }

            if (is_null($basket->user_id)) {
                $request['guest_validation_code'] = Str::random(100);
            }

            $action->prepareShipmentAddressFields($request);
            $action->prepareCompanyFields($request);
            $order = $action->storeOrder($request->all(), $basket);

            //            $action->decrementProductsQuantities($request, $basket);
            $basket->delete();
            $order->sendMailOrderPlacedToClient();
            $order->sendMailOrderPlacedToAdmin();

            //execute payment method?
            $payment = Payment::where('id', $request->payment_id)->where('active', 1)->get()->first();
            if (!empty($payment->class) && !empty($payment->execute_payment_method)) {
                return call_user_func_array(array($payment->class, $payment->execute_payment_method), array($order));
            }

            return redirect(route('basket.order.preview', ['id' => $order->id]))->with('success', __('Successful update'));
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
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Каса | ' . $currentLanguage->seo_title);
            SeoHelper::setDescription('Тук можете да управлявате Вашите продукти, които желаете да закупите.');

            //get current country and city once chosen
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
            $currentLanguage = LanguageHelper::getCurrentLanguage();
            SeoHelper::setTitle('Количка | ' . $currentLanguage->seo_title);
            SeoHelper::setDescription('Тук можете да управлявате Вашите продукти, които желаете да закупите.');

            //get countries and cities for selects
            $countries = Country::limit(50)->get();
            $cities    = City::limit(50)->get();
            //END
            //get current coutry and city once chosen
            $country = Country::find(session()->get('country_id'));
            $city    = City::find(session()->get('city_id'));

            $basket = Basket::getCurrent();
            $basket->calculate($basket->basket_products, $country, $city);

            return view('shop::basket.index', ['basket' => $basket, 'countries' => $countries, 'cities' => $cities]);
        }
        public function addProduct(Request $request, BasketAction $basketAction)//can be used for add,increment,decrement,delete
        {
            if (!isset($request->product_id)) {
                return redirect()->back();//no message need no regular user should ever be here!
            }
            $basketAction->clearAdditivesArrayToPush($request);
            if (!$request->has('product_print') || $request->product_print == '') {
                $request['product_print'] = $basketAction->generateProductPrint($request);
            }

            $product = Product::where('id', $request->product_id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $basket = Basket::getCurrent();
            if (!isset($request->product_quantity)) {// when we want to increment with 1, product_quantity showld not be present in the request
                $request['product_quantity'] = 1;
            }

            $basketProducts = $basket->basket_products()->where('product_id', $product->id)->where('product_print', $request->product_print);
            //delete case
            if ($request->product_quantity == 0) {
                $basketProducts->delete();

                return redirect()->back();
            }

            //decrement case
            if ($request->product_quantity == -1) {
                $basketProduct = $basketProducts->first();
                if (is_null($basketProduct)) {
                    return redirect()->back();// we do not have what to decrement
                }

                if ($basketProduct->product_quantity == 1) {
                    $basketProducts->delete();
                } else {
                    $basketProduct->decrement('product_quantity', 1);
                }

                return redirect()->back();
            }

            //create/increment case
            $basketProduct = $basketProducts->first();
            if (is_null($basketProduct)) {
                $newProduct = $basket->basket_products()->create(['product_id' => $product->id, 'product_quantity' => $request->product_quantity, 'product_print' => $request->product_print]);
                if (isset($request->additivesAdd)) {
                    $request['additivesAdd'] = $basketAction->clearAdditivesArray($request->additivesAdd);
                    $basketAction->storeAdditives($request->additivesAdd, $newProduct);
                }
                if (isset($request->additivesExcept)) {
                    $basketAction->storeExcepts($request->additivesExcept, $newProduct);
                }
                if (isset($request->selectedCollectionPivotProduct)) {
                    $basketAction->storeCollection($request->selectedCollectionPivotProduct, $newProduct);
                }
            } else {
                $basketProduct->increment('product_quantity', $request->product_quantity);
            }

            return redirect()->back()->with(['success-message', trans('admin.common.successful_create')]);
        }

        public function removeExtension(Request $request, BasketAction $basketAction)
        {
            $product = BasketProduct::where('id', $request->product_id)->where('product_print', $request->product_print)->first();
            WebsiteHelper::redirectBackIfNull($product);
            switch ($request->extension_type) {
                case 'collection':
                    BasketProductCollection::where('id', $request->extension_id)->first()->delete();
                    break;

                case 'additives':
                case 'additive_excepts':
                    BasketProductAdditive::where('id', $request->extension_id)->first()->delete();
                    break;

                default:
                    return back();
            }

            $basketAction->replicateArraysForProductPrint($product, $request);
            if ($request->has('allEmpty')) {
                $newProductPrint = base64_encode($request->allEmpty);
            } else {
                $newProductPrint = $basketAction->generateProductPrint($request);
            }
            $newProduct = BasketProduct::where('basket_id', $product->basket_id)->where('product_id', $product->product_id)->where('product_print', $newProductPrint)->first();
            if (!is_null($newProduct)) {
                $newProduct->increment('product_quantity', $product->product_quantity);
                $product->delete();
            } else {
                if (!is_null($product->additives) && $product->additives->isNotEmpty()) {
                    $product->additives()->update(['product_print' => $newProductPrint]);
                }

                if (!is_null($product->additiveExcepts) && $product->additiveExcepts->isNotEmpty()) {
                    $product->additiveExcepts()->update(['product_print' => $newProductPrint]);
                }

                if (!is_null($product->productCollection) && $product->productCollection->isNotEmpty()) {
                    $product->productCollection()->update(['product_print' => $newProductPrint]);
                }
                $product->update(['product_print' => $newProductPrint]);
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
