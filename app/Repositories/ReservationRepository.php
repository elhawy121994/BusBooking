<?php

namespace App\Repositories;

use App\Models\Administration\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;

class ReservationRepository extends BaseRepository implements ReservationRepositoryInterface
{
    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }

    public function getSeatReservations(int $seatId, int $busId, int $tripId)
    {
        return $this->model->where('seat_id', $seatId)
            ->where('bus_id', $busId)
            ->where('trip_id', $tripId)
            ->with(['departureLineStation', 'arrivalLineStation'])
            ->get();
    }
}
