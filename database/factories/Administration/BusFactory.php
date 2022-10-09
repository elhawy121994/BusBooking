<?php

namespace Database\Factories\Administration;

use App\Models\Administration\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Bus::class;

    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['Mercedes VIP', 'Reno Business', 'Honda Hi Line', 'Mercedes Benz Turbo']),
            'number' => $this->faker->randomNumber(5),
            'number_of_seats' => $this->faker->randomElement([10, 12, 50, 100]),
        ];
    }
}
