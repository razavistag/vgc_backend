<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location_name' => $this->faker->state,
            'location_address' => $this->faker->address,
            'location_city' => $this->faker->city,
            'location_zip_code' => $this->faker->postcode,
            'location_country' => $this->faker->stateAbbr,
            'location_phone' => $this->faker->e164PhoneNumber,
            'location_status' => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
