<?php

namespace Tests\Feature\Http;

use App\Models\Administration\Line;
use App\Models\Administration\Trip;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::first());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSingleBookStationPerSeatShouldPass()
    {
        $trip = Trip::first();
        $response = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            ["trip_id" => 1, "seat_id" => 1, "departure_line_station_id" => 2, "arrival_line_station_id" => 4]
        );
        $response->assertCreated();
        $response->assertJson(['id' => 1]);
    }

    public function testTryToBookMultipleStationsOnTheSameSeatSuccessfully()
    {
        //station ['Asyut', 'ElMenia', 'BaniSuif', 'AlFayyum', 'Giza', 'Cairo'];
        $trip = Trip::first();
        $line = Line::first();
        $stations = $line->stations;
        $fromStation1To2 = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            [
                "seat_id" => 1,
                "departure_line_station_id" => $stations[0]->id,
                "arrival_line_station_id" => $stations[1]->id]
        );
        $fromStation1To2->assertCreated();
        $fromStation1To2->assertJson(['id' => 1]);

        $fromStation2To4 = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            [
                "seat_id" => 1,
                "departure_line_station_id" => $stations[2]->id,
                "arrival_line_station_id" => $stations[4]->id]
        );
        $fromStation2To4->assertCreated();
        $fromStation2To4->assertJson(['id' => 2]);

        $fromStation4To5 = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            [
                "seat_id" => 1,
                "departure_line_station_id" => $stations[4]->id,
                "arrival_line_station_id" => $stations[5]->id]
        );
        $fromStation4To5->assertCreated();
        $fromStation4To5->assertJson(['id' => 3]);
    }

    public function testTryToBookOverlapMultipleStationsOnTheSameSeatShouldFail()
    {
        //station ['Asyut', 'ElMenia', 'BaniSuif', 'AlFayyum', 'Giza', 'Cairo'];
        $trip = Trip::first();
        $line = Line::first();
        $stations = $line->stations;
        $fromStation1To4 = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            [
                "seat_id" => 1,
                "departure_line_station_id" => $stations[0]->id,
                "arrival_line_station_id" => $stations[3]->id]
        );
        $fromStation1To4->assertCreated();
        $fromStation1To4->assertJson(['id' => 1]);

        $fromStation3To5 = $this->postJson(
            'api/v1/trips/reservations/' . $trip->id,
            [
                "seat_id" => 1,
                "departure_line_station_id" => $stations[2]->id,
                "arrival_line_station_id" => $stations[4]->id]
        );
        $fromStation3To5->assertUnprocessable();
    }
}
