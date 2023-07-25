<?php

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopStatesSeeder extends Seeder
{
    public function run()
    {
        $sql = file_get_contents('Modules' . DIRECTORY_SEPARATOR . 'Shop' . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'states.sql');
        DB::unprepared($sql);
    }
}
