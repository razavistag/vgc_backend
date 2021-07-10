<?php

namespace Database\Factories;

use App\Models\Po;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Po::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'po_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'po_request_date' => $this->faker->unixTime($max = 'now', $timezone = null),

            'vendor_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'vendor_code' => $this->faker->userName(),
            'vendor_email' => $this->faker->unique()->safeEmail,
            'vendor' => $this->faker->name,

            'agent_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'agent' => $this->faker->name,
            'agent_email' => $this->faker->unique()->safeEmail,
            'agent_code' => $this->faker->userName(),

            'customer_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'customer' => $this->faker->name,
            'customer_email' => $this->faker->unique()->safeEmail,

            'receiver_auto_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receiver' => $this->faker->name,
            'receiver_email' => $this->faker->unique()->safeEmail,

            'cus_po_number' =>   $this->faker->numberBetween($min = 1000, $max = 109000),
            'po_number' =>   $this->faker->numberBetween($min = 1000, $max = 109000),
            'qty' =>   $this->faker->numberBetween($min = 500, $max = 5000),
            'number_of_style' =>   $this->faker->numberBetween($min = 1, $max = 50),
            'total_value' =>   $this->faker->numberBetween($min = 1000, $max = 5000),
            'company_auto_id' =>   $this->faker->numberBetween($min = 1, $max = 50),
            'company' => $this->faker->numberBetween($min = 1, $max = 3),

            'style' =>   Str::random(5) . '_' . $this->faker->numberBetween($min = 1, $max = 50),
            'priority' =>   $this->faker->numberBetween($min = 0, $max = 1),
            'status' =>   $this->faker->numberBetween($min = 0, $max = 8),
            'control_number' =>  $this->faker->numberBetween($min = 1000, $max = 109000),
            'house_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'cancel_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'ex_fty_date' => $this->faker->unixTime($max = 'now', $timezone = null),
            'po_subject' =>  'PO/KI/' .  $this->faker->numberBetween($min = 1, $max = 1000),
            'completed_by' => $this->faker->numberBetween($min = 1, $max = 10),
            'completed_by_email' => $this->faker->unique()->safeEmail,
            'approved_by' => $this->faker->numberBetween($min = 1, $max = 10),
            'beneficiary' => $this->faker->name,
            'hanger'  =>   $this->faker->numberBetween($min = 0, $max = 1),
            'hanger_cost'  =>   '',
            'payment_term'  => $this->faker->numberBetween($min = 1, $max = 6),
            'payment_term'  => $this->faker->numberBetween($min = 1, $max = 6),
            'port_of_entry'  => $this->faker->numberBetween($min = 1, $max = 6),
            'ship_via'  => $this->faker->numberBetween($min = 1, $max = 6),
            'cost_type'  => $this->faker->numberBetween($min = 1, $max = 6),
            'warehouse'  => $this->faker->numberBetween($min = 1, $max = 6),

            // 'payment_term'  => $this->faker->randomElement([
            //     'S03 : NET 45',
            //     'S07 : NET 75',
            //     'S17 : 3% NET 10 EOM',
            //     'S19 : NET 30',
            //     'S27 : HOUSE CREDIT',
            //     'S46 : Pre Payment',
            //     'S55 : 20% NET30',
            //     'S58 : 3%NET10EOM+30',
            // ]),
            // 'load_port'  => $this->faker->randomElement([
            //     'Bangladesh',
            //     'Korea',
            //     'CN : Yantian',
            //     'Dailan China',
            //     'Madagascar',
            // ]),
            // 'port_of_entry'  => $this->faker->randomElement([
            //     'CAD : Canada',
            //     'CH : China',
            //     'DXB : Dubai International Air Port',
            //     'JFK : JFK Air Port',
            //     'MON : Montreal Canada',
            //     'LGB : Long Beach CA',
            // ]),
            // 'ship_via'  => $this->faker->randomElement([
            //     'NEW : NEW LOGISTICS',
            //     'FEDEX : FEDERAL EXPRESS',
            //     'RIGHT : RIGHT MOVE',
            //     'TRUCK : TRUCK',
            //     'Rally : Rally Truck',
            // ]),

            // 'cost_type'  => $this->faker->randomElement([
            //     'CIF : Cost Insured Freight',
            //     'DDP : Delivered Duty Paid',
            //     'DOM : Domestic Venders',
            //     'FOB : Freight on Board',
            // ]),
            // 'warehouse'  => $this->faker->randomElement([
            //     'A&B : A&B Garment Inc',
            //     'POEL : PORT OF ENTRY',
            //     'SPE : Speedup Logistics INC 2',
            //     'SVE : SHIP TO VENDOR',
            //     'UNC : UNITED ADVANCE CUTTING',
            // ]),








        ];
    }
}
