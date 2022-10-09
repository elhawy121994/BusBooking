<?php

namespace App\Http\Requests;

use App\Rules\CanReserveSeatRule;
use App\Rules\StationCheckSequenceRule;
use App\Services\Interfaces\TripServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReservationRequest extends FormRequest
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
        $trip = (resolve(TripServiceInterface::class))->getById($this->route()->parameter('tripId'));
        $this->merge(['bus_id' => $trip->bus_id]);
        $this->merge(['trip_id' => $trip->id]);
        $this->merge(['user_id' => auth()->user()->id]);

        return [
            'arrival_line_station_id' => ['bail', 'required', 'integer'],
            'departure_line_station_id' => [
                'bail',
                'required',
                'integer',
                new StationCheckSequenceRule(
                    $this->get('departure_line_station_id'),
                    $this->get('arrival_line_station_id'),
                    $trip->line_id
                )
            ],
            'seat_id' => [
                'bail',
                'required',
                Rule::exists('seats', 'id')->where('bus_id', $trip->bus_id),
                new CanReserveSeatRule(
                    $this->get('departure_line_station_id'),
                    $this->get('arrival_line_station_id'),
                    $trip
                )
            ],
        ];
    }
}
