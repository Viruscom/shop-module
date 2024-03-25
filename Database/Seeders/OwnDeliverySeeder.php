<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\Entities\Settings\Delivery;

class OwnDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'own_delivery';
        $data = [
            'type'                  => $type,
            'data'                  => json_encode([]),
            'active'                => true,
            'position'              => Delivery::getMaxPosition(),
            'validation_rules'      => json_encode([]),
            'validation_messages'   => json_encode([]),
            'validation_attributes' => json_encode([]),
            'edit_view_path'        => 'shop::deliveries.' . $type . '.edit'
        ];

        $delivery = Delivery::where('type', $type)->first();
        if (is_null($delivery)) {
            $delivery = Delivery::create($data);
        } else {
            // $data['position'] = $delivery->position;
            // $delivery->update($data);
        }
    }
}
