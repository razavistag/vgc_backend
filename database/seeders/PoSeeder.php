<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE PO
        \App\Models\Po::factory(100)->create();
    }
}
