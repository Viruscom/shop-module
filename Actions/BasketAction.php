<?php

    namespace Modules\Shop\Actions;

    use App\Classes\ProductHelper;
    use App\Models\AdBox;
    use App\Models\AdBoxTranslation;
    use Modules\Shop\Entities\Orders\Order;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;
    use Modules\Shop\Http\Requests\OrderRequest;

    class BasketAction
    {
        public function storeOrder($request, $basket)
        {
            $order = Order::create($request->all());
            foreach ($basket->calculated_basket_products as $basketProduct) {
                $order->order_products()->create([
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
            }

            return $order;
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
    }
