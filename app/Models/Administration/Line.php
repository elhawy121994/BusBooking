<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Line extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class, 'lines_stations', 'line_id', 'station_id')
            ->withPivot('rank')
            ->orderByPivot('rank');
    }
}
