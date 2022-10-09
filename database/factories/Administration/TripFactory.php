<?php

namespace Database\Factories\Administration;

use App\Models\Administration\Bus;
use App\Models\Administration\Line;
use App\Models\Administration\Trip;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'departure_time' => $this->faker->dateTimeBetween('now')->add(new DateInterval("P5D")),
            'arrival_time' =>  $this->faker->dateTimeBetween('now')->add(new DateInterval("P5DT5H")),
            'line_id' => (Line::factory()->create())->id,
            'bus_id' => (Bus::factory()->create())->id
            ];
    }
}
