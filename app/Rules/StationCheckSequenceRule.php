<?php

namespace App\Rules;

use App\Services\Interfaces\StationServiceInterface;
use Illuminate\Contracts\Validation\Rule;

class StationCheckSequenceRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private int $departStationId;
    private int $arrivalStationId;
    private int $lineId;

    public function __construct(int $departStationId, int $arrivalStationId, int $lineId)
    {
        $this->departStationId = $departStationId;
        $this->arrivalStationId = $arrivalStationId;
        $this->lineId = $lineId;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->departStationId === $this->arrivalStationId) {
            return false;
        }
        return (resolve(StationServiceInterface::class))
            ->checkStationSequence($this->departStationId, $this->arrivalStationId, $this->lineId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your Station Sequence Not Valid';
    }
}
