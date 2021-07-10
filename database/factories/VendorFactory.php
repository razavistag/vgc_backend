<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'code' => $this->faker->userName(),
            'contact' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->firstNameMale,
            'agent_auto_id' => $this->faker->numberBetween($min = 1, $max = 50),
        ];
    }
}
