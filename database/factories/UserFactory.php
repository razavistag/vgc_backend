<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'company' => $this->faker->company,
            'phone' => $this->faker->e164PhoneNumber,
            'attempts' => 3,
            'address' => $this->faker->address,
            'nic' => '952874691V',
            'gender' => 'MALE',
            'status' => 1,
            'access' => json_encode([
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 0 - dashboard
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 1 - order
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 2 - po
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 3 - user
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 4 - receiving log entery
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 5 - location
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 5 - location
                $this->faker->randomElement($array = array(0 => 3, 1 => 3, 2 => 3, 3 => 3, 4 => 3, 5 => 3, 6 => 3)),    // 6 - openOrder
            ]),
            'role' => 0,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'dob' => "1618349802",
            'language' => $this->faker->numberBetween($min = 1, $max = 2),
            'city' => $this->faker->numberBetween($min = 1, $max = 4),
            'location' => $this->faker->numberBetween($min = 1, $max = 4),
            'zip' => $this->faker->numberBetween($min = 1, $max = 10000),
            'account_number' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'user_type' => $this->faker->numberBetween($min = 0, $max = 3), // CUSTOMER  OR VENDOR OR SUPPLIER
            'opening_balance' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'balance' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'credit_limit' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'payment_terms' => $this->faker->numberBetween($min = 1, $max = 10),  // ?
            'sales_rep_id' => $this->faker->numberBetween($min = 1, $max = 10), // ?
            'basic_salary' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'monthly_target' => $this->faker->numberBetween($min = 1, $max = 1000000),
            'target_percentage' => $this->faker->numberBetween($min = 1, $max = 100),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
