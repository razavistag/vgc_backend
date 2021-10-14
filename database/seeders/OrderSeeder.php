<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE ORDER
        \App\Models\Order::factory(100)->state(new Sequence(
            ['status' => '0'],  // Received
            ['status' => '1'],  // Working
            ['status' => '2'],  // Completed
            ['status' => '3'],  // Approved
            ['status' => '4'],  // Re-opend
            ['status' => '5'],  // Pending
            ['status' => '6'],  // Canceled
            ['status' => '7'],  // Pull stock
            ['status' => '8'],  // Need revised
        ))->create();
    }
}
