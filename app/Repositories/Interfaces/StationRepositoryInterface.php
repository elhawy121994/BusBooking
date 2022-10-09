<?php

namespace App\Repositories\Interfaces;

interface StationRepositoryInterface extends BaseRepositoryInterface
{
    public function getStationsLineByIds(array $stationsIds, int $lineId);

    public function checkStationsOverlap(array $reservedStationsIds, array $toBeBookedStationsIds, int $lineId): bool;

}
