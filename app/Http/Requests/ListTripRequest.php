<?php

namespace App\Http\Requests;

use App\Rules\CanReserveSeatRule;
use App\Rules\StationCheckSequenceRule;
use App\Services\Interfaces\TripServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure_time' => ['nullable', 'date_format:Y-m-d H:i:s', 'after_or_equal:' . date(DATE_ATOM)],
            'arrival_time' => ['nullable', 'date_format:Y-m-d H:i:s|', 'after:departure_time']
        ];
    }
}
