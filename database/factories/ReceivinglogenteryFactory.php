<?php

namespace Database\Factories;

use App\Models\Receivinglogentery;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceivinglogenteryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receivinglogentery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->numberBetween($min = 0, $max = 4),
            'division' => $this->faker->numberBetween($min = 0, $max = 3),
            'vendor' => $this->faker->numberBetween($min = 1, $max = 10),
            'amt_shipment' => $this->faker->numberBetween($min = 1000, $max = 7000),
            'container' => $this->faker->numberBetween($min = 1000, $max = 7000),
            'po' => $this->faker->numberBetween($min = 1000, $max = 7000),
            'etd_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'eta_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'est_eta_war_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'actual_eta_war_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'tally_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'sys_rec_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'appointment_no' => $this->faker->numberBetween($min = 500, $max = 7000),
            'trucker' => $this->faker->numberBetween($min = 500, $max = 7000),
            'carton' => $this->faker->numberBetween($min = 500, $max = 7000),
            'pcs' => $this->faker->numberBetween($min = 500, $max = 7000),
            'wh_charge' => $this->faker->numberBetween($min = 500, $max = 7000),
            'miss' => $this->faker->numberBetween($min = 1, $max = 100),
            'current_note' => $this->faker->text($maxNbChars = 200),
            'status_note' => $this->faker->text($maxNbChars = 200),
        ];

        // STATUS => 0. unloading 1.receiving 2.storing 3.packing 4.loading
    }
}
