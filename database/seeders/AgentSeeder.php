<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE AGENT
        \App\Models\Agent::factory(1000)->create();
    }
}
