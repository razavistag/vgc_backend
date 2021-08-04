<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorfactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE FACOTRIES
        \App\Models\Vendorfactory::factory(20)->create();
    }
}
