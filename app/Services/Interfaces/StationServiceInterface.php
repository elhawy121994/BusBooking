<?php

namespace App\Services\Interfaces;

interface StationServiceInterface extends BaseServiceInterface
{
    public function checkStationSequence(int $departStationId, int $arrivalStationId, int $lineId): bool;

    public function checkStationsOverlap(array $reservedStationsIds, array $toBeBookedStationsIds, int $lineId): bool;

    public function getStationsLineByIds(array $stationsIds, int $lineId);
}
