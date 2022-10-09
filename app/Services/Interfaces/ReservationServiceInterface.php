<?php

namespace App\Services\Interfaces;

use App\Models\Administration\Trip;

interface ReservationServiceInterface extends BaseServiceInterface
{
    public function canSeatBeReserved(
        int $seatId,
        int $departStationId,
        int $arrivalStationId,
        Trip $trip
    ): bool;
}
