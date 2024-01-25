<?php

    namespace Modules\Shop\Entities\Orders\AdminOrder;

    use Illuminate\Database\Eloquent\Model;
    use Modules\Shop\Entities\RegisteredUser\ShopRegisteredUser;

    class AdminOrder extends Model
    {
        protected $table    = "admin_orders";
        protected $fillable = [
            'admin_basket_key', 'user_id', 'uid', 'key', 'email', 'first_name', 'last_name', 'phone', 'street', 'street_number', 'country_id', 'city_id', 'zip_code', 'invoice_required', 'company_name', 'company_eik', 'company_vat_eik', 'company_mol', 'company_address', 'payment_id', 'delivery_id', 'discounts_to_apply', 'total', 'total_discounted', 'total_free_delivery', 'paid_at', 'shipment_status', 'payment_status', 'payment_address', 'returned_amount', 'date_of_return', 'type_of_return', 'return_comment', 'vr_number', 'vr_trans_number', 'vr_date', 'total_default', 'promo_code', 'guest_validation_code', 'with_utensils', 'comment', 'entrance', 'floor', 'apartment', 'bell_name', 'parent_order_id'
        ];

        protected static function returnBackWithError($model, $errorMessage)
        {
            if (is_null($model)) {
                return back()->withInput()->withErrors([$errorMessage]);
            }
        }
        protected static function setClientContactInfo($request, $client)
        {
            $request['email']      = $client->email;
            $request['first_name'] = $client->first_name;
            $request['last_name']  = $client->last_name;
            $request['phone']      = $client->phone;
        }

        protected static function setClientShipmentInfo($request, $clientShipmentAddress)
        {
            $request['street']        = $clientShipmentAddress->street;
            $request['street_number'] = $clientShipmentAddress->street_number;
            $request['country_id']    = $clientShipmentAddress->country_id;
            $request['city_id']       = $clientShipmentAddress->city_id;
            $request['zip_code']      = $clientShipmentAddress->zip_code;
        }

        protected static function setClientCompanyInfo($request, $company)
        {
            $request['invoice_required'] = true;
            $request['company_name']     = $company->company_name;
            $request['company_eik']      = $company->company_eik;
            $request['company_vat_eik']  = $company->company_vat_eik;
            $request['company_mol']      = $company->company_mol;
            $request['company_address']  = $company->company_address;
        }

        protected static function prepareData($request, $data)
        {
            $data['email']         = $request->email;
            $data['first_name']    = $request->first_name;
            $data['last_name']     = $request->last_name;
            $data['phone']         = $request->phone;
            $data['street']        = $request->street;
            $data['street_number'] = $request->street_number;
            $data['country_id']    = $request->country_id;
            $data['city_id']       = $request->city_id;
            $data['zip_code']      = $request->zip_code;
            $data['payment_id']    = $request->payment_id;
            $data['delivery_id']   = $request->delivery_id;

            if ($request->has('admin_basket_key')) {
                $data['admin_basket_key'] = $request->admin_basket_key;
            }
            if ($request->has('company_name')) {
                $data['company_name'] = $request->company_name;
            }
            if ($request->has('company_eik')) {
                $data['company_eik'] = $request->company_eik;
            }
            if ($request->has('company_vat_eik')) {
                $data['company_vat_eik'] = $request->company_vat_eik;
            }
            if ($request->has('company_mol')) {
                $data['company_mol'] = $request->company_mol;
            }
            if ($request->has('company_address')) {
                $data['company_address'] = $request->company_address;
            }
            if ($request->has('shipment_status')) {
                $data['shipment_status'] = $request->shipment_status;
            }
            if ($request->has('payment_status')) {
                $data['payment_status'] = $request->payment_status;
            }
            if ($request->has('payment_address')) {
                $data['payment_address'] = $request->payment_address;
            }
            if ($request->has('comment')) {
                $data['comment'] = $request->comment;
            }
            if ($request->has('entrance')) {
                $data['entrance'] = $request->entrance;
            }
            if ($request->has('floor')) {
                $data['floor'] = $request->floor;
            }
            if ($request->has('apartment')) {
                $data['apartment'] = $request->apartment;
            }
            if ($request->has('bell_name')) {
                $data['bell_name'] = $request->bell_name;
            }
            if ($request->has('invoice_required')) {
                $data['invoice_required'] = true;
            }

            $data['with_utensils'] = false;
            if ($request->has('with_utensils')) {
                $data['with_utensils'] = filter_var($request->with_utensils, FILTER_VALIDATE_BOOLEAN);
            }

            return $data;
        }

        protected static function storeNewAddressForRegUser($client, $request)
        {
            if ($request->has('shipment_address_id') && $request->new_address == 1) {
                $shipmentAddresses     = $client->shipmentAddresses;
                $data['name']          = 'Адрес за доставка';
                $data['street']        = $request->street;
                $data['street_number'] = $request->street_number;
                $data['country_id']    = $request->country_id;
                $data['city_id']       = $request->city_id;
                $data['zip_code']      = $request->zip_code;
                $data['is_default']    = !count($shipmentAddresses);
                if ($request->has('entrance')) {
                    $data['entrance']      = $request->entrance;
                }
                if ($request->has('floor')) {
                    $data['floor'] = $request->floor;
                }
                if ($request->has('apartment')) {
                    $data['apartment'] = $request->apartment;
                }
                if ($request->has('bell_name')) {
                    $data['bell_name'] = $request->bell_name;
                }
                $client->shipmentAddresses()->create($data);
            }
        }

        public static function getOrCreateAdminOrder($request)
        {
            $data = [];

            if ($request->has('client_id') && !is_null($request->client_id)) {
                $client = ShopRegisteredUser::where('id', $request->client_id)->with('companies', 'shipmentAddresses')->first();
                self::returnBackWithError($client, 'Клиентът не е намерен');

                $data['user_id'] = $request->client_id;
                self::setClientContactInfo($request, $client);

                if ($request->has('shipment_address_id') && $request->new_address == 0) {
                    $clientShipmentAddress = $client->shipmentAddresses()->where('id', $request->shipment_address_id)->first();
                    self::returnBackWithError($clientShipmentAddress, 'Адресът на доставка не е намерен');
                    self::setClientShipmentInfo($request, $clientShipmentAddress);
                }

                self::storeNewAddressForRegUser($client, $request);

                if ($request->has('firm_account_id') && $request->firm_account_id != 0) {
                    $company = $client->companies()->where('id', $request->firm_account_id)->first();
                    self::returnBackWithError($company, 'Фирмата не е намерена');
                    self::setClientCompanyInfo($request, $company);
                }

                if ($request->has('firm_account_id') && $request->new_address == 1) {
                    //TODO:store new client company
                }
            }

            $data = self::prepareData($request, $data);

            return AdminOrder::updateOrCreate(['admin_basket_key' => $request->admin_basket_key], $data);
        }
    }
