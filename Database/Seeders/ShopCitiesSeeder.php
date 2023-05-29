<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopCitiesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents('Modules\Shop\Database\cities.sql');
        DB::unprepared($sql);
    }
}
