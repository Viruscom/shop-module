<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopCountriesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents('Modules\Shop\Database\countries.sql');
        DB::unprepared($sql);
    }
}
