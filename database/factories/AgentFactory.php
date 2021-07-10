<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'agent_name' => $this->faker->firstNameMale,
            'agent_code' => $this->faker->userName(),
            'agent_email' => $this->faker->unique()->safeEmail,
        ];
    }
}
