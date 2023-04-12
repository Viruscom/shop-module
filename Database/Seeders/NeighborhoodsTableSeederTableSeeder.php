<?php

namespace Modules\Shop\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class NeighborhoodsTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sofia_neighborhoods = array(
            'Банишора',
            'Бели брези',
            'Борово',
            'Бояна',
            'Бухтоносци',
            'Център',
            'Дървеница',
            'Дианабад',
            'Драгалевци',
            'Факултета',
            'Гео Милев',
            'Горубляне',
            'Хаджи Димитър',
            'Иван Вазов',
            'Изток',
            'Изгрев',
            'Карпузица',
            'Княжево',
            'Красна поляна',
            'Красно село',
            'Кремиковци',
            'Левски',
            'Люлин',
            'Люлин 1',
            'Люлин 2',
            'Люлин 3',
            'Люлин 4',
            'Люлин 5',
            'Младост 1',
            'Младост 2',
            'Младост 3',
            'Младост 4',
            'Младост 5',
            'Младост 6',
            'Младост 7',
            'Надежда',
            'Оборище',
            'Овча купел',
            'Подуяне',
            'Редута',
            'Сердика',
            'Слатина',
            'Студентски град',
            'Суходол',
            'Света Троица',
            'Витоша',
            'Враждебна',
            'Яворов',
        );

        foreach ($sofia_neighborhoods as $neighborhood) {
            DB::table('neighborhoods')->insert([
                                                    'name' => $neighborhood
                                                ]);
        }
    }
}
