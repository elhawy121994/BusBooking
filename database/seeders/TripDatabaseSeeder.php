<?php

namespace Database\Seeders;

use App\Models\Administration\Bus;
use App\Models\Administration\Line;
use App\Models\Administration\Seat;
use App\Models\Administration\Station;
use App\Models\Administration\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TripDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => "Mahmoud Ali",
            'email' => "test@example.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $line = Line::factory()->create(['name' => 'Assyut-Cairo-east-road']);
        $bus = Bus::factory()->create();
        Seat::factory()->count($bus->number_of_seats)->for($bus)->create();
        $trip = Trip::factory()->create(['line_id' => $line->id, 'bus_id' => $bus->id]);
        $lineStops = ['Asyut', 'ElMenia', 'BaniSuif', 'AlFayyum', 'Giza', 'Cairo'];
        foreach ($lineStops as $key => $stop) {
            $station = Station::firstOrCreate(['name' => $stop, 'distance' => (50 + $key + 8 * 1.2)]);
            $station->lines()->attach($line->id, ['rank' => $key, 'arrival_time' => Carbon::parse($trip->arrival_time)->addHours($key)]);
        }
    }
}
