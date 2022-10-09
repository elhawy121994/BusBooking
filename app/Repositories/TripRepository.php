<?php

namespace App\Repositories;

use App\Models\Administration\Seat;
use App\Models\Administration\Trip;
use App\Repositories\Interfaces\TripRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TripRepository extends BaseRepository implements TripRepositoryInterface
{
    public function __construct(Trip $model)
    {
        parent::__construct($model);
    }

    public function getTripSeats(int $tripId)
    {
        $trip = $this->getById($tripId);
        return Seat::where('bus_id', $trip->id)
            ->with(['resetvations', function (Builder $query) use ($trip) {
                $query->where('bus_id', $trip->bus_id)->where('trip_id', $trip->trip_id);
            }])->with('bus.line.stations')
            ->get();
    }
}
