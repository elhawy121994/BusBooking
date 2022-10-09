<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lines()
    {
        return$this->belongsToMany(Line::class, 'lines_stations', 'station_id', 'line_id')->withPivot('rank');

    }
}
