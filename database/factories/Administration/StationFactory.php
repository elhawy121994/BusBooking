<?php

namespace Database\Factories\Administration;

use App\Models\Administration\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    protected $model = Station::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>  $this->faker->unique()->city,
            'distance' => $this->faker->numberBetween(50, 300)
        ];
    }
}
