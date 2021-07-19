<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Sequence;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {





        $this->call(AdminUserSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(VendorSeeder::class);
        // $this->call(CustomerSeeder::class);
        // $this->call(AgentSeeder::class);
        // $this->call(LocationSeeder::class);
        // $this->call(ReceivinglogenterySeeder::class);
        // $this->call(PoSeeder::class);
        // $this->call(OrderSeeder::class);
    }
}
