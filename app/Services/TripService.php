<?php

namespace App\Services;

use App\Models\Administration\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Services\Interfaces\ReservationServiceInterface;
use App\Services\Interfaces\TripServiceInterface;
use Illuminate\Database\Eloquent\Model;

class TripService extends BaseService implements TripServiceInterface
{
    public function __construct(TripRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getTripSeats(int $tripId)
    {
        return $this->repository->getTripSeats($tripId);
    }
}
