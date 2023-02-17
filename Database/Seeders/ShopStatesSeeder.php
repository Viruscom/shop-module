<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopStatesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents(database_path('states.sql'));
        DB::unprepared($sql);
    }
}
