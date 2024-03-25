<?php

    namespace Modules\Shop\Database\Seeders;

    use App\Models\Settings\ShopSetting;
    use Illuminate\Database\Seeder;

    class ShopSettingSeeder extends Seeder
    {
        public function run()
        {
            ShopSetting::firstOrCreate(
                ['key' => 'shop_owner_name'],
                [
                    'value' => "Shop name",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'eik'],
                [
                    'value' => "123456789",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'address'],
                [
                    'value' => "Full registration address",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'email'],
                [
                    'value' => "",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'unique_shop_number'],
                [
                    'value' => "",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'domain'],
                [
                    'value' => "https://my-shop-domain.com",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'main_vat'],
                [
                    'value' => "20",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'virtual_pos_number'],
                [
                    'value' => "000000012345678",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'virtual_receipt_number'],
                [
                    'value' => "1",
                ]
            );

            ShopSetting::firstOrCreate(
                ['key' => 'shop_created_date'],
                [
                    'value' => date('Y-m-d'),
                ]
            );
        }
    }
