<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'cancel_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'eta' => $this->faker->unixTime($max = 'now', $timezone = null),
            'comment' => $this->faker->text($maxNbChars = 400),
            'remark' =>  $this->faker->text($maxNbChars = 200),
            'production_auto_id' =>  $this->faker->numberBetween($min = 1, $max = 10),
            'customer_auto_id' =>  $this->faker->numberBetween($min = 1, $max = 10),
            'customer' => $this->faker->name,
            'customer_email' => $this->faker->unique()->safeEmail,
            'sales_rep_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'sales_rep' => $this->faker->name,
            'sales_rep_email' => $this->faker->unique()->safeEmail,
            'po_number' =>  $this->faker->numberBetween($min = 1000, $max = 109000),
            'factor_number' => Str::random(5),
            'receiver' =>  $this->faker->name,
            'receiver_email' =>  $this->faker->unique()->safeEmail,
            'completed_by' => $this->faker->name,
            'completed_by_email' => $this->faker->unique()->safeEmail,
            'approved_by' =>  $this->faker->name,
            'control_number' =>  $this->faker->numberBetween($min = 1000, $max = 109000),
            'production_by' => $this->faker->name,
            'production_email' => $this->faker->unique()->safeEmail,
            'company_auto_id' => $this->faker->company,
            'receiver_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),


            'num_page' =>  $this->faker->numberBetween($min = 1, $max = 10),

            'number_of_style' =>  $this->faker->numberBetween($min = 500, $max = 5000),
            'or_style' =>  $this->faker->numberBetween($min = 500, $max = 5000),
            're_style' =>  $this->faker->numberBetween($min = 500, $max = 5000),
            // 'status' => '',
            'order_type' => $this->faker->numberBetween($min = 1, $max = 3),
            'is_immediate' => $this->faker->numberBetween($min = 0, $max = 1),
            'edi_status' => $this->faker->numberBetween($min = 0, $max = 1),
            'upc_status' => $this->faker->numberBetween($min = 1, $max = 2),
            'price_ticket' => $this->faker->numberBetween($min = 0, $max = 1),
            'total_value' =>   $this->faker->numberBetween($min = 500, $max = 5000),
        ];
    }
}
