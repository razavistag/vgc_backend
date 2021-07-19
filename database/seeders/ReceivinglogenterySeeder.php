<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceivinglogenterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE RECEIVING LOG ENTERY
        \App\Models\Receivinglogentery::factory(1000)->create();
    }
}
