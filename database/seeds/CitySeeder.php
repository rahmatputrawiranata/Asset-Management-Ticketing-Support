<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'id' => 1,
                'regions_id' => 1,
                'name' => 'Jakarta Pusat',
            ],
            [
                'id' => 2,
                'regions_id' => 1,
                'name' => 'jakarta Utara'
            ],
            [
                'id' => 3,
                'regions_id' => 1,
                'name' => 'Jakarta Timur'
            ],
            [
                'id' => 4,
                'regions_id' => 1,
                'name' => 'Jakarta Barat'
            ],
            [
                'id' => 5,
                'regions_id' => 2,
                'name' => 'Surabaya'
            ],
            [
                'id' => 6,
                'regions_id' => 2,
                'name' => 'Kediri'
            ],
            [
                'id' => 7,
                'regions_id' => 3,
                'name' => 'Bandung'
            ]
        );

        City::insert($data);
    }
}
