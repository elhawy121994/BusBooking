<?php

namespace Database\Factories\Administration;

use App\Models\Administration\Bus;
use App\Models\Administration\Reservation;
use App\Models\Administration\Seat;
use App\Models\Administration\Station;
use App\Models\Administration\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seat_id' => (Seat::factory()->create())->id,
            'trip_id' => (Trip::factory()->create())->id,
            'bus_id' => (Bus::factory()->create())->id,
            'departure_line_station_id' => (Station::factory()->create())->id,
            'arrival_line_station_id' => (Station::factory()->create())->id,
            'user_id' => (User::factory()->create())->id,
        ];
    }
}
