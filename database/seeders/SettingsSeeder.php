<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::insert([
            [
               'site_name'=> 'KunPhone',
               'email'=>'phone@revonepal.com',
               'phone'=>'9841515151',
               'aboutus'=>'We Company'
            ]
        ]);
    }
}
