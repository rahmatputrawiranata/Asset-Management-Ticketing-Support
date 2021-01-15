<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            BranchSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            WorkerSeeder::class,
            ProgressCodeMasterDataSeeder::class,
        ]);
    }
}
