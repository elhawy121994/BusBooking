<?php

namespace App\Repositories\Interfaces;

interface ReservationRepositoryInterface extends  BaseRepositoryInterface
{
    public function getSeatReservations(int $seatId, int $busId, int $tripId);
}
