<?php

namespace App\Services;

use App\Models\Administration\LineStation;
use App\Models\Administration\Reservation;
use App\Models\Administration\Trip;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Services\Interfaces\ReservationServiceInterface;
use App\Services\Interfaces\StationServiceInterface;
use App\Services\Interfaces\TripServiceInterface;

class ReservationService extends BaseService implements ReservationServiceInterface
{
    protected StationServiceInterface $stationService;
    protected TripServiceInterface $tripService;

    public function __construct(
        ReservationRepositoryInterface $repository,
        StationServiceInterface        $stationService,
        TripServiceInterface           $tripService
    )
    {
        parent::__construct($repository);
        $this->stationService = $stationService;
        $this->tripService = $tripService;
    }

    public function canSeatBeReserved(
        int  $seatId,
        int  $departStationId,
        int  $arrivalStationId,
        Trip $trip
    ): bool
    {
        $reservations = $this->repository->getSeatReservations($seatId, $trip->bus_id, $trip->id);
        $lineStations = $this->stationService->getStationsLineByIds([$departStationId, $arrivalStationId], $trip->line_id);
        $departureStation = $lineStations->first();
        $arrivalStation = $lineStations->last();
        foreach ($reservations as $reservation) {
            if (
                $this->checkIfBookStationInsideReserved($reservation, $departureStation, $arrivalStation) ||
                $this->checkIfReservedInsideBookStationI($reservation, $departureStation, $arrivalStation) ||
                $this->checkStationOverlap($reservation, $departureStation, $arrivalStation)
            ) {
                return false;
            }
        }
        return true;
    }

    private function checkIfBookStationInsideReserved(
        Reservation $reservation,
        LineStation $departureStation,
        LineStation $arrivalStation
    ): bool
    {
        return ($reservation->departureLineStation->rank <= $departureStation->rank &&
            $reservation->arrivalLineStation->rank >= $arrivalStation->rank);
    }

    private function checkIfReservedInsideBookStationI(
        Reservation $reservation,
        LineStation $departureStation,
        LineStation $arrivalStation
    ): bool
    {
        return ($departureStation->rank <= $reservation->departureLineStation->rank &&
            $arrivalStation->rank >= $reservation->arrivalLineStation->rank);
    }

    private function checkStationOverlap(
        Reservation $reservation,
        LineStation $departureStation,
        LineStation $arrivalStation
    ): bool
    {
        return (
                $departureStation->rank > $reservation->departureLineStation->rank &&
                $departureStation->rank < $reservation->arrivalLineStation->rank
            ) ||
            (
                $arrivalStation->rank > $reservation->departureLineStation->rank &&
                $arrivalStation->rank < $reservation->arrivalLineStation->rank
            );
    }
}
