<?php

use App\Models\Region;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
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
                'countries_id' => 1,
                'name' => 'DKI Jakarta',
            ],
            [
                'id' => 2,
                'countries_id' => 1,
                'name' => 'Jawa Timur'
            ],
            [
                'id' => 3,
                'countries_id' => 1,
                'name' => 'Jawa Barat'
            ]
        );

        Region::insert($data);
    }
}
