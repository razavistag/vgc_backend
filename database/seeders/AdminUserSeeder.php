<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE DEFAULT USERS
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'company' => 'vistag',
            'phone' => '+94777123456',
            'attempts' => 3,
            'address' => '67832 Cole Spurs Port Jo, MS 02342',
            'nic' => '952874691V',
            'gender' => 'MALE',
            'status' => 1,
            'access' => json_encode([
                0 => 4,      // 0 - dashboard
                1 => 4,      // 1 - order
                2 => 4,      // 2 - po
                3 => 4,      // 3 - user
                4 => 4,      // 4 - receiving log entery
                5 => 4,      // 5 - location
            ]),
            'role' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

            'dob' => "1618349802",
            'language' => 1,
            'city' => 1,
            'location' => 1,
            'zip' => '20820',
            'account_number' => '259874568',
            'user_type' => 2, // CUSTOMER  OR VENDOR OR SUPPLIER
            'opening_balance' => '2000',
            'balance' => '0',
            'credit_limit' => '5000',
            'payment_terms' => 1,  // ?
            'sales_rep_id' => 0, // ?
            'basic_salary' => 60000,
            'monthly_target' => 0,
            'target_percentage' => 0,
        ]);
    }
}
