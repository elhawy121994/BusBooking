<?php

namespace App\Repositories\Interfaces;

interface TripRepositoryInterface extends BaseRepositoryInterface
{
    public function getTripSeats(int $tripId);
}
