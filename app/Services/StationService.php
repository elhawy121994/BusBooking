<?php

namespace App\Services;

use App\Repositories\Interfaces\StationRepositoryInterface;
use App\Services\Interfaces\StationServiceInterface;

class StationService extends BaseService implements StationServiceInterface
{
    public function __construct(StationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function checkStationSequence(int $departStationId, int $arrivalStationId, int $lineId): bool
    {
        $stations = $this->getStationsLineByIds([$departStationId, $arrivalStationId], $lineId);
        if ($stations->count() < 2) {
            return false;
        }
        $departStation = $stations->firstWhere('station_id', $departStationId);
        $arrivalStation = $stations->firstWhere('station_id', $arrivalStationId);
        if ($departStation->rank >= $arrivalStation->rank) {
            return false;
        }
        return true;
    }

    public function checkStationsOverlap(array $reservedStationsIds, array $toBeBookedStationsIds, int $lineId): bool
    {
        return $this->repository->checkStationsOverlap($reservedStationsIds, $toBeBookedStationsIds, $lineId);
    }

    public function getStationsLineByIds(array $stationsIds, int $lineId)
    {
        return $this->repository->getStationsLineByIds($stationsIds, $lineId);
    }
}
