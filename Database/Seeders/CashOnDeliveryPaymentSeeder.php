<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\Entities\Settings\Payment;

class CashOnDeliveryPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'cash_on_delivery';
        $data = [
            'type'                   => $type,
            'data'                   => json_encode([]),
            'active'                 => true,
            'position'               => Payment::getMaxPosition(),
            'validation_rules'       => json_encode([]),
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
            // $data['position'] = $payment->position;
            // $payment->update($data);
        }
    }
}
