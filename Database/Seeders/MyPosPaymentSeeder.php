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
                                                        'shop_id'         => '000000000000010',
                                                        'wallet'          => '61938166610',
                                                        'key_index'       => 1,
                                                        'version'         => "1.4",
                                                        'private_key'     => '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCf0TdcTuphb7X+Zwekt1XKEWZDczSGecfo6vQfqvraf5VPzcnJ
2Mc5J72HBm0u98EJHan+nle2WOZMVGItTa/2k1FRWwbt7iQ5dzDh5PEeZASg2UWe
hoR8L8MpNBqH6h7ZITwVTfRS4LsBvlEfT7Pzhm5YJKfM+CdzDM+L9WVEGwIDAQAB
AoGAYfKxwUtEbq8ulVrD3nnWhF+hk1k6KejdUq0dLYN29w8WjbCMKb9IaokmqWiQ
5iZGErYxh7G4BDP8AW/+M9HXM4oqm5SEkaxhbTlgks+E1s9dTpdFQvL76TvodqSy
l2E2BghVgLLgkdhRn9buaFzYta95JKfgyKGonNxsQA39PwECQQDKbG0Kp6KEkNgB
srCq3Cx2od5OfiPDG8g3RYZKx/O9dMy5CM160DwusVJpuywbpRhcWr3gkz0QgRMd
IRVwyxNbAkEAyh3sipmcgN7SD8xBG/MtBYPqWP1vxhSVYPfJzuPU3gS5MRJzQHBz
sVCLhTBY7hHSoqiqlqWYasi81JzBEwEuQQJBAKw9qGcZjyMH8JU5TDSGllr3jybx
FFMPj8TgJs346AB8ozqLL/ThvWPpxHttJbH8QAdNuyWdg6dIfVAa95h7Y+MCQEZg
jRDl1Bz7eWGO2c0Fq9OTz3IVLWpnmGwfW+HyaxizxFhV+FOj1GUVir9hylV7V0DU
QjIajyv/oeDWhFQ9wQECQCydhJ6NaNQOCZh+6QTrH3TC5MeBA1Yeipoe7+BhsLNr
cFG8s9sTxRnltcZl1dXaBSemvpNvBizn0Kzi8G3ZAgc=
-----END RSA PRIVATE KEY-----',
                                                        'public_key'      => '-----BEGIN CERTIFICATE-----
MIIBsTCCARoCCQCCPjNttGNQWDANBgkqhkiG9w0BAQsFADAdMQswCQYDVQQGEwJC
RzEOMAwGA1UECgwFbXlQT1MwHhcNMTgxMDEyMDcwOTEzWhcNMjgxMDA5MDcwOTEz
WjAdMQswCQYDVQQGEwJCRzEOMAwGA1UECgwFbXlQT1MwgZ8wDQYJKoZIhvcNAQEB
BQADgY0AMIGJAoGBAML+VTmiY4yChoOTMZTXAIG/mk+xf/9mjwHxWzxtBJbNncNK
0OLI0VXYKW2GgVklGHHQjvew1hTFkEGjnCJ7f5CDnbgxevtyASDGst92a6xcAedE
adP0nFXhUz+cYYIgIcgfDcX3ZWeNEF5kscqy52kpD2O7nFNCV+85vS4duJBNAgMB
AAEwDQYJKoZIhvcNAQELBQADgYEACj0xb+tNYERJkL+p+zDcBsBK4RvknPlpk+YP
ephunG2dBGOmg/WKgoD1PLWD2bEfGgJxYBIg9r1wLYpDC1txhxV+2OBQS86KULh0
NEcr0qEY05mI4FlE+D/BpT/+WFyKkZug92rK0Flz71Xy/9mBXbQfm+YK6l9roRYd
J4sHeQc=
-----END CERTIFICATE-----',
                                                        'complany_name'   => 'My company',
                                                        'complany_eik'    => '111222333',
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
            'class'                  => 'Modules\MyPosPayment\Actions\PaymentAction',
            'execute_payment_method' => 'initPayment',
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
