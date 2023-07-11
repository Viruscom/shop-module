<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\Entities\Settings\Payment;

class MyPosPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'mypos';
        $data = [
            'type'                   => $type,
            'data'                   => json_encode([
                                                        'environment'     => 'TEST',
                                                        'environment_url' => 'https://mypos.com/vmp/checkout-test/',
                                                        'shop_id'         => 'shop id',
                                                        'wallet'          => 'wallet',
                                                        'key_index'       => 1,
                                                        'version'         => "1.4",
                                                        'private_key'     => 'private key',
                                                        'public_key'      => 'public key',
                                                        'complany_name'   => 'My company',
                                                        'complany_eik'    => 'EIK',
                                                    ]),
            'active'                 => true,
            'position'               => Payment::getMaxPosition(),
            'validation_rules'       => json_encode([
                                                        'environment'     => 'required',
                                                        'environment_url' => 'required',
                                                        'shop_id'         => 'required',
                                                        'wallet'          => 'required',
                                                        'key_index'       => 'required',
                                                        'version'         => 'required',
                                                        'private_key'     => 'required',
                                                        'public_key'      => 'required',
                                                        'complany_name'   => 'required',
                                                        'complany_eik'    => 'required',
                                                    ]),
            'validation_messages'    => json_encode([]),
            'validation_attributes'  => json_encode([]),
            'class'                  => '',
            'execute_payment_method' => '',
            'edit_view_path'         => 'shop::payments.' . $type . '.edit'
        ];

        $payment = Payment::where('type', $type)->first();
        if (is_null($payment)) {
            $payment = Payment::create($data);
        } else {
            $data['position'] = $payment->position;
            $payment->update($data);
        }
    }
}
