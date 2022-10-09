<?php

namespace Database\Factories\Administration;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'type' => $this->faker->randomElement(['window', 'corridor']),
            'bus_id' => 1,
        ];
    }
}
