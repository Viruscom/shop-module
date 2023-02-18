<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\Entities\Payment;

class BankTransferPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'bank_transfer';
        $data = [
            'type'                   => $type,
            'data'                   => json_encode([
                                                        'receiver_name'      => 'Momchil OOD',
                                                        'receiver_bank_name' => 'Unicredit Bulbank',
                                                        'receiver_iban'      => 'BG18UNCR1212121212',
                                                        'receiver_bic'       => 'STSABGSF'
                                                    ]),
            'active'                 => true,
            'position'               => Payment::getMaxPosition(),
            'validation_rules'       => json_encode([
                                                        'receiver_name'      => 'required|min:2|max:255',
                                                        'receiver_bank_name' => 'required|min:2|max:255',
                                                        'receiver_iban'      => 'required|min:22|max:22',
                                                        'receiver_bic'       => 'required|min:8|max:8'
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
            // $data['position'] = $payment->position;
            // $payment->update($data);
        }
    }
}
