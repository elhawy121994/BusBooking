<?php

namespace App\Rules;

use App\Models\Administration\Trip;
use App\Services\Interfaces\ReservationServiceInterface;
use App\Services\ReservationService;
use Illuminate\Contracts\Validation\Rule;

class CanReserveSeatRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private int $departStationId;
    private int $arrivalStationId;
    private Trip $trip;

    public function __construct(int $departStationId, int $arrivalStationId, Trip $trip)
    {
        $this->departStationId = $departStationId;
        $this->arrivalStationId = $arrivalStationId;
        $this->trip = $trip;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
         return (resolve(ReservationServiceInterface::class))
            ->canSeatBeReserved($value, $this->departStationId, $this->arrivalStationId, $this->trip);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Seat Already Booked On This Stations';
    }
}
