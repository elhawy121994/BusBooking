<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function departureLineStation(): BelongsTo
    {
        return $this->belongsTo(LineStation::class, 'departure_line_station_id');
    }

    public function arrivalLineStation(): BelongsTo
    {
        return $this->belongsTo(LineStation::class, 'arrival_line_station_id');
    }
}
