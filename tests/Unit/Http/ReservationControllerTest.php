<?php

namespace Tests\Unit\Http;

use App\Models\Administration\Line;
use App\Models\Administration\Reservation;
use App\Models\Administration\Seat;
use App\Models\Administration\Trip;
use App\Models\User;
use App\Services\Interfaces\ReservationServiceInterface;
use App\Services\Interfaces\StationServiceInterface;
use App\Services\ReservationService;
use App\Services\StationService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testErrorResponse()
    {
        $this->actingAs(User::factory()->create());
        $trip = Trip::factory()->create();
        $seat = Seat::factory()->create(['bus_id' => $trip->bus_id]);
        $departStationId = 1;
        $arrivalStationId = 4;
        $body = [
            "seat_id" => $seat->id,
            "departure_line_station_id" => $departStationId,
            "arrival_line_station_id" => $arrivalStationId
        ];
        $reservationServiceMock = Mockery::mock(ReservationServiceInterface::class);

        $reservationServiceMock->shouldReceive('canSeatBeReserved')
            ->once()
            ->andReturn(true);

        $stationServiceMock = Mockery::mock(StationServiceInterface::class);
        $stationServiceMock->shouldReceive('checkStationSequence')
            ->with($departStationId, $arrivalStationId, $trip->line_id)
            ->once()
            ->andReturn(true);


        $body['bus_id'] = $trip->bus_id;
        $body['trip_id'] = $trip->line_id;
        $body['user_id'] = 1;
        $reservationServiceMock->shouldReceive('create')
            ->with($body)
            ->once()
            ->andReturn(null);

        $this->app->instance(ReservationService::class, $reservationServiceMock);
        $this->app->instance(StationService::class, $stationServiceMock);
        $response = $this->postJson('api/v1/trips/reservations/' . $trip->id, $body);

        $response->assertStatus(500);
        $response->assertJson(['code' => 500,'message' => 'Internal error occurs']);
    }

}
