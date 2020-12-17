<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new User();
        $data->name = 'Admin Asset Management';
        $data->username = 'admin';
        $data->email = 'admin@admin.com';
        $data->phone = '62811111111';
        $data->password = Hash::make('admin');
        $data->save();
    }
}
