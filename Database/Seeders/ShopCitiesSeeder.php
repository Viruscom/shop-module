<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopCitiesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents('Modules' . DIRECTORY_SEPARATOR . 'Shop' . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'cities.sql');
        DB::unprepared($sql);
    }
}
