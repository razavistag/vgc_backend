<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE RANDOM USERS
        \App\Models\User::factory(25)
            ->state(new Sequence(
                ['gender' => 'MALE'],
                ['gender' => 'FEMALE'],
                ['gender' => 'OTHERS'],
                ['gender' => 'OTHERS'],
                ['role' =>  2],
                ['role' =>  3],
                ['role' =>  4],
                ['role' =>  5],
                ['role' =>  6],
                ['role' =>  7],
            ))
            ->create();
    }
}
