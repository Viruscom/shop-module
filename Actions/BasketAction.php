<?php

    namespace Modules\Shop\Actions;

    use App\Classes\ProductHelper;
    use App\Models\AdBox;
    use App\Models\AdBoxTranslation;
    use Illuminate\Http\Request;
    use Modules\RetailObjectsRestourant\Models\ProductAdditive;
    use Modules\Shop\Entities\Basket\BasketProductAdditive;
    use Modules\Shop\Entities\Basket\BasketProductCollection;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
    use Modules\Shop\Entities\Settings\City;
    use Modules\Shop\Entities\Settings\Country;
    use Modules\Shop\Http\Requests\OrderRequest;
    use Modules\Shop\Models\Admin\ProductCollection\ProductCollectionPivot;

    class BasketAction
    {
        public function storeOrder($data, $basket)
        {
            $order = Order::create($data);
            $this->storeOrderProducts($order, $basket);

            return $order;
        }

        public function storeOrderProducts($order, $basket)
        {
            foreach ($basket->calculated_basket_products as $basketProduct) {
                $orderProduct = $order->order_products()->create([
                                                                     'product_id'                   => $basketProduct->product_id,
                                                                     'product_quantity'             => $basketProduct->product_quantity,
                                                                     'supplier_delivery_price'      => $basketProduct->product->supplier_delivery_price,
                                                                     'price'                        => $basketProduct->product->price,
                                                                     'discounts_amount'             => $basketProduct->discounts_amount,
                                                                     'vat'                          => $basketProduct->vat,
                                                                     'vat_applied_price'            => $basketProduct->vat_applied_price,
                                                                     'end_price'                    => $basketProduct->end_price,
                                                                     'free_delivery'                => $basketProduct->free_delivery ? 1 : 0,
                                                                     'vat_applied_discounted_price' => $basketProduct->vat_applied_discounted_price,
                                                                     'end_discounted_price'         => $basketProduct->end_discounted_price,
                                                                     'vat_applied_default_price'    => $basketProduct->vat_applied_default_price,
                                                                 ]);

                $this->orderStoreAdditives($orderProduct, $basketProduct);
                $this->orderStoreAdditiveExcepts($orderProduct, $basketProduct);
                $this->orderStoreProductCollection($orderProduct, $basketProduct);
            }
        }

        private function orderStoreAdditives($orderProduct, $basketProduct)
        {
            if ($basketProduct->additives->isNotEmpty()) {
                foreach ($basketProduct->additives as $additive) {
                    $orderProduct->additives()->create([
                                                           'order_product_id'    => $orderProduct->id,
                                                           'product_id'          => $basketProduct->product_id,
                                                           'product_additive_id' => $additive->product_additive_id,
                                                           'price'               => $additive->price,
                                                           'quantity'            => $additive->quantity * $basketProduct->product_quantity,
                                                           'total'               => $additive->total * $basketProduct->product_quantity,
                                                           'in_without_list'     => $additive->in_without_list,
                                                           'product_print'       => $additive->product_print,
                                                           'stk_idnumb'          => $additive->stk_idnumb
                                                       ]);
                }
            }
        }

        private function orderStoreAdditiveExcepts($orderProduct, $basketProduct)
        {
            if ($basketProduct->additiveExcepts->isNotEmpty()) {
                foreach ($basketProduct->additiveExcepts as $additive) {
                    $orderProduct->additiveExcepts()->create([
                                                                 'order_product_id'    => $orderProduct->id,
                                                                 'product_id'          => $basketProduct->product_id,
                                                                 'product_additive_id' => $additive->product_additive_id,
                                                                 'price'               => $additive->price,
                                                                 'quantity'            => $additive->quantity,
                                                                 'total'               => $additive->total,
                                                                 'in_without_list'     => $additive->in_without_list,
                                                                 'product_print'       => $additive->product_print,
                                                                 'stk_idnumb'          => 0
                                                             ]);
                }
            }
        }
        private function orderStoreProductCollection($orderProduct, $basketProduct)
        {
            if ($basketProduct->productCollection->isNotEmpty()) {
                foreach ($basketProduct->productCollection as $collectionProduct) {
                    $orderProduct->productCollection()->create([
                                                                   'order_product_id' => $orderProduct->id,
                                                                   'product_id'       => $collectionProduct->product_id,
                                                                   'main_product_id'  => $collectionProduct->main_product_id,
                                                                   'price'            => $collectionProduct->price,
                                                                   'quantity'         => $collectionProduct->quantity,
                                                                   'total'            => $collectionProduct->total,
                                                                   'product_print'    => $collectionProduct->product_print
                                                               ]);
                }
            }
        }

        public function clearAdditivesArray($array): array
        {
            $processedAdditives = [];
            foreach ($array as $key => $additive) {
                if (isset($additive['selected'])) {
                    $processedAdditives[$key] = $additive;
                }
            }

            return $processedAdditives;
        }

        public function storeAdditives($additivesArray, $newProduct)
        {
            foreach ($additivesArray as $additiveId => $valueArray) {
                $additive = ProductAdditive::where('id', $additiveId)->first();
                if (!is_null($additive)) {
                    BasketProductAdditive::create([
                                                      'basket_product_id'   => $newProduct->id,
                                                      'product_id'          => $newProduct->product_id,
                                                      'product_additive_id' => $additive->id,
                                                      'price'               => $additive->price,
                                                      'quantity'            => $valueArray['quantity'],
                                                      'total'               => $additive->price * $valueArray['quantity'],
                                                      'in_without_list'     => false,
                                                      'product_print'       => $newProduct->product_print,
                                                      'stk_idnumb'          => $additive->stk_idnumb
                                                  ]);
                }
            }
        }
        public function storeExcepts($additivesArray, $newProduct)
        {
            foreach ($additivesArray as $additiveId => $valueArray) {
                $additive = ProductAdditive::where('id', $additiveId)->first();
                if (!is_null($additive)) {
                    BasketProductAdditive::create([
                                                      'basket_product_id'   => $newProduct->id,
                                                      'product_id'          => $newProduct->product_id,
                                                      'product_additive_id' => $additive->id,
                                                      'price'               => $additive->price,
                                                      'quantity'            => 0,
                                                      'total'               => 0,
                                                      'in_without_list'     => true,
                                                      'product_print'       => $newProduct->product_print,
                                                      'stk_idnumb'          => 0
                                                  ]);
                }
            }
        }

        public function generateProductPrint($request): string
        {
            $productPrint = "";

            if (isset($request->additivesAdd)) {
                $productPrint .= json_encode($request->additivesAdd);
            }
            if (isset($request->additivesExcept)) {
                $productPrint .= json_encode($request->additivesExcept);
            }
            if (isset($request->selectedCollectionPivotProduct)) {
                $productPrint .= json_encode($request->selectedCollectionPivotProduct);
            }

            return base64_encode($productPrint);
        }
        public function storeCollection($selectedCollectionPivotProduct, $newProduct)
        {
            foreach ($selectedCollectionPivotProduct as $key => $collectionProductId) {
                $collectionProduct = ProductCollectionPivot::where('main_product_id', $newProduct->product_id)->where('additional_product_id', $collectionProductId)->first();
                if (!is_null($collectionProduct)) {
                    //TODO: Change country and city get logic
                    $priceWithDiscountWithVat = $collectionProduct->getVatPrice(Country::find(34), City::find(9701));
                    BasketProductCollection::create([
                                                        'basket_product_id' => $newProduct->id,
                                                        'product_id'        => $collectionProduct->additional_product_id,
                                                        'main_product_id'   => $newProduct->product_id,
                                                        'price'             => $priceWithDiscountWithVat,
                                                        'quantity'          => $newProduct->product_quantity,
                                                        'total'             => $newProduct->product_quantity * $priceWithDiscountWithVat,
                                                        'product_print'     => $newProduct->product_print
                                                    ]);
                }
            }
        }
        public function replicateArraysForProductPrint($product, $request)
        {
            $additiveArray                       = null;
            $additivesExceptArray                = null;
            $selectedCollectionPivotProductArray = null;

            if (!is_null($product->additives) && $product->additives->isNotEmpty()) {
                foreach ($product->additives as $additive) {
                    $additiveArray[$additive->productAdditive->id]['selected'] = 'on';
                    $additiveArray[$additive->productAdditive->id]['quantity'] = $additive->quantity;
                }
                $request['additivesAdd'] = $additiveArray;
            }

            if (!is_null($product->additivesExcept) && $product->additivesExcept->isNotEmpty()) {
                foreach ($product->additivesExcept as $except) {
                    $additivesExceptArray[$except->productAdditive->id]['selected'] = 'on';
                }
                $request['additivesExcept'] = $additivesExceptArray;
            }

            if (!is_null($product->productCollection) && $product->productCollection->isNotEmpty()) {
                foreach ($product->productCollection as $collectionProduct) {
                    $selectedCollectionPivotProductArray[] = $collectionProduct->product->id;
                }
                $request['selectedCollectionPivotProduct'] = $selectedCollectionPivotProductArray;
            }
            if (!$request->has('additivesAdd') && !$request->has('additivesExcept') && !$request->has('selectedCollectionPivotProduct')) {
                $request['allEmpty'] = "[]";
            }
        }
        public function prepareShipmentAddressFields(OrderRequest $request)
        {
            if (!is_null($request['user_id']) && isset($request['shipment_address_id'])) {
                $registeredUser = ShopRegisteredUser::where('id', $request['user_id'])->with('shipmentAddresses')->first();
                $wantedAddress  = $registeredUser->shipmentAddresses()->where('id', $request['shipment_address_id'])->first();
                if (!is_null($wantedAddress) && $wantedAddress->street == $request['street'] && $wantedAddress->street_number == $request['street_number']) {
                    $request['street']        = $wantedAddress->street;
                    $request['street_number'] = $wantedAddress->street_number;
                    $request['entrance']      = $wantedAddress->entrance;
                } else {
                    $registeredUser->shipmentAddresses()->create([
                                                                     'name'          => $request['street'] . ', №' . $request['street_number'],
                                                                     'street'        => $request['street'],
                                                                     'street_number' => $request['street_number'],
                                                                     'entrance'      => $request['entrance'],
                                                                     'floor'         => $request['floor'],
                                                                     'apartment'     => $request['apartment'],
                                                                     'bell_name'     => $request['bell_name'],
                                                                     'zip_code'      => $request['zip_code'],
                                                                     'city_id'       => $request['city_id'],
                                                                     'country_id'    => $request['country_id'],
                                                                 ]);
                }
            }
        }
        public function prepareCompanyFields(OrderRequest $request)
        {
            if (!is_null($request['user_id']) && isset($request['company_id']) && $request->has('invoice_required') && $request->invoice_required) {
                $registeredUser = ShopRegisteredUser::where('id', $request['user_id'])->with('companies')->first();
                $wantedCompany  = $registeredUser->companies()->where('id', $request['company_id'])->first();
                if (!is_null($wantedCompany) && ($request['company_name'] == '' && $request['company_mol'] == '' && $request['company_eik'] == '' && $request['company_address'] == '')) {
                    $request['street']          = $wantedCompany->street;
                    $request['street_number']   = $wantedCompany->street_number;
                    $request['company_name']    = $wantedCompany->company_name;
                    $request['company_mol']     = $wantedCompany->company_mol;
                    $request['company_phone']   = $wantedCompany->phone;
                    $request['company_eik']     = $wantedCompany->company_eik;
                    $request['company_vat_eik'] = $wantedCompany->company_vat_eik;
                    $request['company_address'] = $wantedCompany->company_address;
                } else {
                    $registeredUser->companies()->create([
                                                             'street'          => $request['street'],
                                                             'street_number'   => $request['street_number'],
                                                             'company_name'    => $request['company_name'],
                                                             'company_mol'     => $request['company_mol'],
                                                             'phone'           => $request['company_phone'],
                                                             'company_eik'     => $request['company_eik'],
                                                             'company_address' => $request['company_address'],
                                                             'email'           => $request['email'],
                                                         ]);
                }
            }
        }
        public function decrementProductsQuantities(OrderRequest $request, $basket)
        {

        }
        public function clearAdditivesArrayToPush(Request $request)
        {
            $processedAdditives = [];
            if ($request->has('additivesAdd')) {
                foreach ($request->additivesAdd as $key => $additive) {
                    if (isset($additive['selected'])) {
                        $processedAdditives[$key] = $additive;
                    }
                }

                $request['additivesAdd'] = $processedAdditives;
            }
        }
    }
