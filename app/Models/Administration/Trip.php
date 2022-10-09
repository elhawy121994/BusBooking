<?php

namespace App\Models\Administration;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * Class OrganizationType
     *
     * @property int $id
     * @property string $name
     * @property Carbon|null $departure_time
     * @property Carbon|null $arrival_time
     * @property integer|null $line_id
     * @property integer|null $bus_id
     * @property Carbon|null $created_ay
     * @property Carbon|null $deleted_at
     *
     * @package App\Models
     */
    use HasFactory;

    protected $guarded = [];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
