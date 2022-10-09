<?php

namespace App\Repositories;

use App\Models\Administration\LineStation;
use App\Models\Administration\Station;
use App\Repositories\Interfaces\StationRepositoryInterface;

class StationRepository extends BaseRepository implements StationRepositoryInterface
{
    public function __construct(Station $model)
    {
        parent::__construct($model);
    }

    public function getStationsLineByIds(array $stationsIds, int $lineId)
    {
       return LineStation::whereIn('station_id', $stationsIds)->where('line_id', $lineId)->orderBy('rank', 'ASC')->get();
    }

    public function checkStationsOverlap(array $reservedStationsIds, array $toBeBookedStationsIds, int $lineId): bool
    {
        $toBeBookedStations =  LineStation::whereIn('station_id', $toBeBookedStationsIds)->where('line_id', $lineId)->orderBy('rank')->get();
        return LineStation::whereIn('station_id', $reservedStationsIds)
            ->whereBetween('rank', [$toBeBookedStations->first()->rank, $toBeBookedStations->last()->rank])
            ->where('line_id', $lineId)
            ->get();
    }
}
