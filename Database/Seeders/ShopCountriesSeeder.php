<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopCountriesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents(database_path('countries.sql'));
        DB::unprepared($sql);
    }
}
