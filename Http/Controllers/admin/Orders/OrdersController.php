<?php

    namespace Modules\Shop\Http\Controllers\admin\Orders;

    use App\Helpers\CacheKeysHelper;
    use App\Helpers\WebsiteHelper;
    use App\Http\Controllers\Controller;
    use App\Models\Settings\ShopSetting;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Modules\Shop\Actions\BasketAction;
    use Modules\Shop\Entities\Basket\Basket;
    use Modules\Shop\Entities\Basket\BasketProduct;
    use Modules\Shop\Entities\Basket\BasketProductAdditive;
    use Modules\Shop\Entities\Basket\BasketProductCollection;
    use Modules\Shop\Entities\Orders\AdminOrder\AdminOrder;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
    use Modules\Shop\Entities\Settings\City;
    use Modules\Shop\Entities\Settings\Country;
    use Modules\Shop\Entities\Settings\Delivery;
    use Modules\Shop\Entities\Settings\Main\CountrySale;
    use Modules\Shop\Entities\Settings\Payment;
    use Modules\Shop\Http\Requests\Admin\AdminOrders\AdminOrderStoreRequest;
    use Modules\Shop\Http\Requests\OrderReturnAmountRequest;
    use Modules\Shop\Models\Admin\Products\Product;

    class OrdersController extends Controller
    {
        public function index()
        {
            return view('shop::admin.orders.index', [
                'orders' => Order::whereNull('parent_order_id')->orderBy('created_at', 'desc')->get()
            ]);
        }
        public function store($id, Request $request, BasketAction $action)
        {
            $order = AdminOrder::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket = Basket::where('key', $order->admin_basket_key)->first();

            //TODO: change city and Country to be dynamic
            $country = Country::find($order->country_id);
            $city    = City::find($order->city_id);

            if ($basket->basket_products->count() < 1) {
                return redirect(route('admin.shop.orders.get-create-step-two', ['id' => $order->id]))->withErrors([__('First add products to basket.')]);
            }

            $basketProducts = $basket->basket_products;

            $basket->calculate($basketProducts, $country, $city);
            //TODO: Ima razlika, da sew vidi

            //            if ($basket->total != $request->total || $basket->total_discounted != $request->total_discounted || $basket->total_free_delivery != $request->total_free_delivery) {
            //                return redirect(route('admin.shop.orders.get-create-step-two', ['id' => $order->id]))->withError(__('There are changes.'));
            //            }
            $data = [
                'user_id'               => $order->user_id,
                'key'                   => $basket->key,
                'uid'                   => Str::uuid(),
                'email'                 => $order->email,
                'first_name'            => $order->first_name,
                'last_name'             => $order->last_name,
                'phone'                 => $order->phone,
                'street'                => $order->street,
                'street_number'         => $order->street_number,
                'country_id'            => $order->country_id,
                'city_id'               => $order->city_id,
                'zip_code'              => $order->zip_code,
                'invoice_required'      => $order->invoice_required,
                'company_name'          => $order->company_name,
                'company_eik'           => $order->company_eik,
                'company_vat_eik'       => $order->company_vat_eik,
                'company_mol'           => $order->company_mol,
                'company_address'       => $order->company_address,
                'payment_id'            => $order->payment_id,
                'delivery_id'           => $order->delivery_id,
                'discounts_to_apply'    => json_encode($basket->discounts_to_apply),
                'total'                 => $basket->total,
                'total_discounted'      => $basket->total_discounted,
                'total_free_delivery'   => $basket->total_free_delivery,
                'paid_at'               => null,
                'delivered_at'          => null,
                //                'delivery_data'         => $order->email,
                'shipment_status'       => Order::SHIPMENT_WAITING,
                'payment_status'        => Order::PAYMENT_PENDING,
                //                'payment_address'       => $order->email,
                //                'returned_amount'       => $order->email,
                //                'date_of_return'        => $order->email,
                //                'type_of_return'        => $order->email,
                //                'return_comment'        => $order->email,
                //                'vr_number'             => $order->email,
                //                'vr_trans_number'       => $order->email,
                //                'vr_date'               => $order->email,
                'total_default'         => $basket->total_default,
                'promo_code'            => $basket->promo_code,
                'guest_validation_code' => is_null($basket->user_id) ? Str::random(100) : null,
                'with_utensils'         => $order->with_utensils,
                'comment'               => $order->comment,
                'entrance'              => $order->entrance,
                'floor'                 => $order->floor,
                'apartment'             => $order->apartment,
                'bell_name'             => $order->bell_name,
                'parent_order_id'       => null,
                'sent_to_yanak_at'      => null,
            ];

            $clientOrder = $action->storeOrder($data, $basket);

            //TODO: check quantities
            //            $action->decrementProductsQuantities($request, $basket);
            $basket->delete();
            $order->delete();
            //            $clientOrder->sendMailOrderPlacedToAdmin();
            $payment = Payment::where('id', $request->payment_id)->where('active', 1)->get()->first();

            //            $clientOrder->sendMailOrderPlacedToClientFromAdmin($payment);

            return redirect(route('admin.shop.orders'))->with('success-message', __('Successful create'));
        }

        public function cancel()
        {
            $basket = Basket::getOrCreateAdminSystemBasket();
            $order  = AdminOrder::where('admin_basket_key', $basket->key)->first();

            Basket::deleteAdminSystemBasket();
            if (!is_null($order)) {
                $order->delete();
            }

            return redirect()->route('admin.shop.orders')->with('success-message', trans('admin.common.successful_delete'));
        }
        public function onCreateAddProduct($id, Request $request, BasketAction $basketAction)//can be used for add,increment,decrement,delete
        {
            $order = AdminOrder::where('id', $id)->first();
            if (is_null($order)) {
                return back()->withErrors(['Продуктът не е намерен']);
            }
            if (!isset($request->product_id)) {
                return back()->withErrors(['Продуктът не е намерен']);
            }
            $basketAction->clearAdditivesArrayToPush($request);
            if (!$request->has('product_print') || $request->product_print == '') {
                $request['product_print'] = $basketAction->generateProductPrint($request);
            }

            $product = Product::where('id', $request->product_id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $basket = Basket::getOrCreateAdminSystemBasket();
            if (!isset($request->product_quantity)) {// when we want to increment with 1, product_quantity showld not be present in the request
                $request['product_quantity'] = 1;
            }

            $basketProducts = $basket->basket_products()->where('product_id', $product->id)->where('product_print', $request->product_print);
            //delete case
            if ($request->product_quantity == 0) {
                $basketProducts->delete();

                return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id]);
            }

            //decrement case
            if ($request->product_quantity == -1) {
                $basketProduct = $basketProducts->first();
                if (is_null($basketProduct)) {
                    return back()->withErrors(['Продуктът не е намерен']);// we do not have what to decrement
                }

                if ($basketProduct->product_quantity == 1) {
                    $basketProducts->delete();
                } else {
                    $basketProduct->decrement('product_quantity', 1);
                }

                return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id]);
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

            return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id]);
        }
        public function create()
        {
            $basket = Basket::getOrCreateAdminSystemBasket();
            $order  = AdminOrder::where('admin_basket_key', $basket->key)->first();

            //TODO: change city and Country to be dynamic
            $country = Country::find(34);
            $city    = City::find(9701);

            $basket->calculate($basket->basket_products, $country, $city);

            return view('shop::admin.orders.create.create', [
                'products'        => Product::with('translations', 'combinations')->get(),
                'clients'         => ShopRegisteredUser::where('active', true)->with('paymentAddresses', 'shipmentAddresses', 'companies')->get(),
                'saleCountries'   => CountrySale::with('country', 'country.cities')->get(),
                'paymentMethods'  => Payment::where('active', true)->orderBy('position', 'asc')->get(),
                'deliveryMethods' => Delivery::where('active', true)->orderBy('position', 'asc')->get(),
                'basket'          => $basket,
                'countryId'       => $country->id,
                'cityId'          => $city->id,
                'order'           => $order
            ]);
        }
        public function onCreateRemoveExtension($id, Request $request, BasketAction $basketAction)
        {
            $order = AdminOrder::where('id', $id)->first();
            if (is_null($order)) {
                return back()->withErrors(['Продуктът не е намерен']);
            }
            if (!isset($request->product_id)) {
                return back()->withErrors(['Продуктът не е намерен']);
            }

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

            return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id]);
        }
        public function update($id, $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            $order->update($order->getUpdateData($request));
            $order->updateProducts($request->only('products'));

            //TODO: uncomment this $order->sendMailOrderUpdated();

            return redirect()->route('admin.shop.orders')->with('success-message', 'admin.common.successful_edit');
        }
        public function edit($id)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->with(
                'order_products',
                'order_products.product',
                'order_products.product.translations',
                'user',
                'payment',
                'delivery',
                'documents',
                'history',
                'returns'
            )->first();
            WebsiteHelper::redirectBackIfNull($order);

            $salesCountries = CountrySale::pluck('country_id')->toArray();

            return view('shop::admin.orders.edit', [
                'order'        => $order,
                'cities'       => City::whereIn('country_id', $salesCountries)->orderBy('name', 'asc')->get(),
                'products'     => Product::active(true)->with('translations')->get(),
                'clients'      => ShopRegisteredUser::where('active', true)->get(),
                'vrNumber'     => ShopSetting::where('key', 'virtual_receipt_number')->first(),
                'payments'     => Payment::all(),
                'myPosPayment' => Payment::where('type', 'mypos')->first()
            ]);
        }
        public function show($id)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->with(
                'order_products',
                'order_products.product',
                'order_products.product.translations',
                'payment',
                'delivery',
                'documents',
                'history',
                'returns'
            )->first();
            WebsiteHelper::redirectBackIfNull($order);

            return view('shop::admin.orders.show', compact('order'));
        }
        public function changePaymentStatus($id, $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            $order->update(['payment_status' => $request->payment_status_id]);
            $order->history()->create(['activity_name' => 'Статусът беше променен на: ' . $order->getReadablePaymentStatus()]);
            $order->sendMailPaymentStatusChanged();
        }
        public function createStepTwo(AdminOrderStoreRequest $request)
        {
            $order = AdminOrder::getOrCreateAdminOrder($request);

            return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id]);
        }

        public function getCreateStepTwo($id)
        {
            $order = AdminOrder::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket = Basket::where('key', $order->admin_basket_key)->first();

            //TODO: change city and Country to be dynamic
            $country = Country::find(34);
            $city    = City::find(9701);

            $basket->calculate($basket->basket_products, $country, $city);

            return view('shop::admin.orders.create.create_step_two', [
                'products' => Product::where('active', true)->with('translations', 'combinations')->get(),
                'basket'   => $basket,
                'order'    => $order,
            ]);
        }

        public function onCreateApplyPromoCode($id, Request $request)
        {
            if (!isset($request->promo_code) || empty($request->promo_code)) {
                return back()->withErrors(['Няма промокод или не е валиден']);
            }
            $order = AdminOrder::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket = Basket::where('key', $order->admin_basket_key)->first();

            $currentPromoCode   = $basket->promo_code;
            $basket->promo_code = $request->promo_code;
            $basket->save();

            //TODO: change city and Country to be dynamic
            $country = Country::find(34);
            $city    = City::find(9701);

            $basket->calculate($basket->basket_products, $country, $city);

            $promoCodeValid = $basket->isCurrentPromoCodeValid();
            if (!$promoCodeValid) {
                $basket             = Basket::where('key', $order->admin_basket_key)->first();
                $basket->promo_code = $currentPromoCode;
                $basket->save();

                return redirect()->back()->withErrors(['Невалиден промо код']);
            }

            return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id])->with('success-message', 'Успешно приложен промо код');
        }

        public function onCreateDeletePromoCode($id)
        {
            $order = AdminOrder::where('id', $id)->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket             = Basket::where('key', $order->admin_basket_key)->first();
            $basket->promo_code = null;
            $basket->save();

            return redirect()->route('admin.shop.orders.get-create-step-two', ['id' => $order->id])->with('success-message', 'Успешно изтрихте промо код');
        }

        public function storeUserId(Request $request)
        {
            if ($request->has('userId')) {
                return 'error';
            }

            $user = ShopRegisteredUser::find($request->userId);
            if (is_null($user)) {
                return 'error';
            }

            // Store User id
            $basket = Basket::getOrCreateAdminSystemBasket();
            $basket->update(['user_id' => $request->userId]);

            return 'success';
        }

        public function changeShipmentStatus($id, $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            $order->update(['shipment_status' => $request->payment_status_id]);
            $order->history()->create(['activity_name' => 'Статусът беше променен на: ' . $order->getReadableShipmentStatus()]);
            $order->sendMailShipmentStatusChanged();
        }

        public function returnUpdate($id, OrderReturnAmountRequest $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            if ($request->returned_amount > $order->grandTotalWithDiscountsVatAndDelivery()) {
                return redirect()->back()->withInput()->withErrors([trans('shop::admin.returned_products.amount_error')]);
            }

            $order->update([
                               'returned_amount' => $request->returned_amount,
                               'date_of_return'  => $request->date_of_return,
                               'type_of_return'  => $request->type_of_return,
                               'return_comment'  => $request->return_comment
                           ]);

            $order->history()->create(['activity_name' => 'Връщане на поръчка / пари беше променено на: Върната сума ' . $order->returned_amount . ' лв., дата на връщане на сумата ' . $order->date_of_return . ', начин на връщане на сумата ' . $order->type_of_return]);

            return redirect()->back()->with('success-message', 'admin.common.successful_edit');
        }

        public function paymentUpdate()
        {
            //TODO: Send email to client with new payment
        }

        public function companyUpdate()
        {
            //TODO: Send email to client with new company
        }

        public function getProductByIdForOrder(Request $request)
        {
            $clientLevel = null;

            if ($request->has('client_id')) {
                $client      = ShopRegisteredUser::where('id', $request->client_id)->first();
                $clientLevel = is_null($client) ? 1 : $client->client_group_id;
            }

            if ($request->isProductCollection !== 'false') {
                //Get product collection here
                $collection = '66666666';

                return '999999';
            }

            $product = Product::where('id', $request->productID)->active(true)->isInStock()->with('translations')->first();
            if (is_null($product)) {
                return 'error';
            }

            return [
                'product'            => $product->toJson(),
                'productQuantity'    => $request->productQuantity,
                'productTranslation' => $product,
                'image'              => $product->getFileUrl(),
                'discounts'          => 0, //TODO: $product->getCalculatedDiscounts(),
                'priceWithDiscounts' => 0, //TODO: $product->getPriceWithDiscounts($clientLevel)
            ];
        }

        public function paymentStatusUpdate($id, Request $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            $order->update(['payment_status' => $request->status]);
            $order->history()->create(['activity_name' => 'Промяна на статус на плащане: ' . $order->getReadablePaymentStatus()]);
            $order->sendMailPaymentStatusChanged();

            return redirect()->back()->with('success-message', 'admin.common.successful_edit');
        }

        public function shipmentStatusUpdate($id, Request $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            $order->update(['shipment_status' => $request->status]);
            $order->history()->create(['activity_name' => 'Промяна на статус на поръчката: ' . $order->getReadableShipmentStatus()]);
            $order->sendMailShipmentStatusChanged();

            return redirect()->back()->with('success-message', 'admin.common.successful_edit');
        }

        public function companyInfoUpdate($id, Request $request)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->with('user')->first();
            WebsiteHelper::redirectBackIfNull($order);
            $data = [
                'company_name'    => $request->company_name,
                'company_mol'     => $request->company_mol,
                'company_eik'     => $request->company_eik,
                'company_vat_eik' => $request->company_vat_eik,
                'company_address' => $request->company_address,
            ];

            if (!is_null($order->user)) {
                $companies    = $order->user->companies;
                $isNewCompany = true;
                if ($companies->isNotEmpty()) {
                    foreach ($companies as $company) {
                        if ($request->company_eik == $company->company_eik) {
                            $isNewCompany = false;

                            $data = [
                                'company_name'    => $company->company_name,
                                'company_mol'     => $company->company_mol,
                                'company_eik'     => $company->company_eik,
                                'company_vat_eik' => $company->company_vat_eik,
                                'company_address' => $company->company_address,
                            ];
                        }
                    }
                }

                if ($isNewCompany) {
                    $order->user->companies()->create(['email'           => $order->email,
                                                       'phone'           => $order->phone,
                                                       'street'          => $order->street,
                                                       'street_number'   => $order->street_number,
                                                       'country_id'      => null,
                                                       'city_id'         => null,
                                                       'zip_code'        => null,
                                                       'company_name'    => $request->company_name,
                                                       'company_mol'     => $request->company_mol,
                                                       'company_eik'     => $request->company_eik,
                                                       'company_vat_eik' => $request->company_vat_eik,
                                                       'company_address' => $request->company_address,
                                                       'is_default'      => $companies->isEmpty(),
                                                       'is_deleted'      => false
                                                      ]);
                }
            }

            $order->update($data);

            return response()->json($data);
        }

        public function editProducts($id)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->with(
                'order_products',
                'order_products.product',
                'order_products.product.translations',
                'user',
                'payment',
                'delivery',
                'documents',
                'history',
                'returns'
            )->first();

            WebsiteHelper::redirectBackIfNull($order);

            $salesCountries = CountrySale::pluck('country_id')->toArray();

            $basket = Basket::getOrCreateOrderSystemBasket($order);
            $basket->calculate($basket->basket_products, $order->country, $order->city);

            return view('shop::admin.orders.edit', [
                'order'        => $order,
                'basket'       => $basket,
                'cities'       => City::whereIn('country_id', $salesCountries)->orderBy('name', 'asc')->get(),
                'products'     => cache()->get(CacheKeysHelper::$SHOP_PRODUCT_FRONT),
                'clients'      => ShopRegisteredUser::where('active', true)->get(),
                'vrNumber'     => ShopSetting::where('key', 'virtual_receipt_number')->first(),
                'payments'     => Payment::all(),
                'myPosPayment' => Payment::where('type', 'mypos')->first()
            ]);
        }

        public function editProductsCancel($id)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->with(
                'order_products',
                'order_products.product',
                'order_products.product.translations',
                'user',
                'payment',
                'delivery',
                'documents',
                'history',
                'returns'
            )->first();
            WebsiteHelper::redirectBackIfNull($order);

            Basket::deleteOrderSystemBasket($order);

            return redirect()->route('admin.shop.orders.edit', ['id' => $order->id]);
        }

        public function addProduct($id, Request $request, BasketAction $basketAction)//can be used for add,increment,decrement,delete
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);

            if (!isset($request->product_id)) {
                return redirect()->back();//no message need no regular user should ever be here!
            }
            $basketAction->clearAdditivesArrayToPush($request);
            if (!$request->has('product_print') || $request->product_print == '') {
                $request['product_print'] = $basketAction->generateProductPrint($request);
            }

            $product = Product::where('id', $request->product_id)->first();
            WebsiteHelper::redirectBackIfNull($product);

            $basket = Basket::getOrCreateOrderSystemBasket($order);
            if (!isset($request->product_quantity)) {// when we want to increment with 1, product_quantity showld not be present in the request
                $request['product_quantity'] = 1;
            }

            $basketProducts = $basket->basket_products()->where('product_id', $product->id)->where('product_print', $request->product_print);
            //delete case
            if ($request->product_quantity == 0) {
                $basketProducts->delete();

                return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id]);
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

                return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id]);
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

            return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id])->with(['success-message', trans('admin.common.successful_create')]);
        }

        public function removeExtension($id, Request $request, BasketAction $basketAction)
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

            return redirect()->route('admin.shop.orders.edit_products', ['id' => $id]);
        }

        public function applyPromoCode($id, Request $request)
        {
            if (!isset($request->promo_code) || empty($request->promo_code)) {
                return back()->withErrors(['Няма промокод или не е валиден']);
            }
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket             = Basket::getOrCreateOrderSystemBasket($order);
            $currentPromoCode   = $basket->promo_code;
            $basket->promo_code = $request->promo_code;
            $basket->save();
            $basket->calculate($basket->basket_products, $order->country, $order->city);

            $promoCodeValid = $basket->isCurrentPromoCodeValid();
            if (!$promoCodeValid) {
                $basket             = Basket::getOrCreateOrderSystemBasket($order);
                $basket->promo_code = $currentPromoCode;
                $basket->save();

                return redirect()->back()->withErrors(['Невалиден промо код']);
            }

            return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id])->with('success-message', 'Успешно приложен промо код');
        }

        public function deletePromoCode($id)
        {
            $order = Order::where('id', $id)->whereNull('parent_order_id')->first();
            WebsiteHelper::redirectBackIfNull($order);
            $basket             = Basket::getOrCreateOrderSystemBasket($order);
            $basket->promo_code = null;
            $basket->save();

            return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id])->with('success-message', 'Успешно изтрихте промо код');
        }

        public function editProductsSave($id, Request $request)
        {

            $order = Order::where('id', $id)->whereNull('parent_order_id')->with(
                'order_products',
            )->first();
            WebsiteHelper::redirectBackIfNull($order);
            //save current order as a child order of it
            $order->replicateWithRelations(['order_products']);

            $basket = Basket::getOrCreateOrderSystemBasket($order);
            if ($basket->basket_products->count() < 1) {
                return redirect()->route('admin.shop.orders.edit_products', ['id' => $order->id])->withErrors([__('First add products to basket.')]);
            }

            $basket->calculate($basket->basket_products, $order->country, $order->city);
            $order->discounts_to_apply  = json_encode($basket->discounts_to_apply);
            $order->total_default       = $basket->total_default;
            $order->promo_code          = $basket->promo_code;
            $order->total               = $basket->total;
            $order->total_discounted    = $basket->total_discounted;
            $order->total_free_delivery = $basket->total_free_delivery;
            $order->save();
            $order->order_products()->delete();
            $action = new BasketAction();
            $action->storeOrderProducts($order, $basket);

            $basket->delete();

            //TODO: Uncomment send emails
            //            $order->sendMailOrderUpdatedToClient();
            //            $order->sendMailOrderUpdatedToAdmin();

            return redirect()->route('admin.shop.orders.edit', ['id' => $order->id])->with('success-message', 'admin.common.successful_edit');
        }

        public function updateComment(Request $request, $id)
        {
            $messages = [
                'comment.required' => 'The comment field is required.',
                'comment.string'   => 'The comment must be a string.',
            ];

            $validator = Validator::make($request->all(), [
                'comment' => 'required|string',
            ],                           $messages);

            if ($validator->fails()) {
                return response()->json([
                                            'success' => false,
                                            'errors'  => $validator->errors()->all()
                                        ]);
            }

            try {
                $order = Order::where('id', $id)->first();
                if (is_null($order)) {
                    return response()->json([
                                                'success' => false,
                                                'errors'  => ['Order not found.']
                                            ]);
                }

                $order->update(['comment' => $request->comment]);

                return response()->json([
                                            'success' => true,
                                            'message' => 'Comment updated successfully.'
                                        ]);
            } catch (Exception $e) {
                return response()->json([
                                            'success' => false,
                                            'errors'  => ['An unexpected error occurred. Please try again.']
                                        ]);
            }
        }

        public function updateOthers(Request $request, $id)
        {
            if (!$request->has('with_utensils')) {
                return response()->json([
                                            'success' => false,
                                            'errors'  => ['Invalid data!']
                                        ]);
            }

            try {
                $order = Order::where('id', $id)->first();
                if (is_null($order)) {
                    return response()->json([
                                                'success' => false,
                                                'errors'  => ['Order not found.']
                                            ]);
                }
                $data                  = [];
                $data['with_utensils'] = false;
                if ($request->has('with_utensils')) {
                    $data['with_utensils'] = filter_var($request->with_utensils, FILTER_VALIDATE_BOOLEAN);
                }

                $order->update($data);

                return response()->json([
                                            'success' => true,
                                            'message' => 'Order info updated successfully.'
                                        ]);
            } catch (Exception $e) {
                return response()->json([
                                            'success' => false,
                                            'errors'  => ['An unexpected error occurred. Please try again.']
                                        ]);
            }
        }
    }
