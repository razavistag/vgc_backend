<?php

namespace Database\Factories;

use App\Models\Vendorfactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorfactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendorfactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'factory_name' =>  $this->faker->name,
            'vendor_name' =>  $this->faker->name,
            'factory_code' =>  $this->faker->userName(),
            'factory_mobile' =>  $this->faker->e164PhoneNumber,
            'factory_email'  => $this->faker->unique()->safeEmail,
            'factory_address' => $this->faker->address,
            'vendor_auto_id' => $this->faker->numberBetween($min = 2, $max = 10),
        ];
    }
}
