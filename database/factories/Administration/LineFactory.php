<?php

namespace Database\Factories\Administration;

use App\Models\Administration\Line;
use App\Models\Administration\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->country() . "-" . $this->faker->city ."-". $this->faker->city
        ];
    }
}
