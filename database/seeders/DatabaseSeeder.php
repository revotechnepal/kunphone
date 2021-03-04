<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(SettingsSeeder::class);
    }
}
