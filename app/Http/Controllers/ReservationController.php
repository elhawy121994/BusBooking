<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequest;
use App\Services\Interfaces\ReservationServiceInterface;

class ReservationController extends BaseController
{

    protected $reservationService;

    public function __construct(ReservationServiceInterface $reservationService)
    {
        $this->middleware('auth:api');
        $this->reservationService = $reservationService;
    }

    public function create(CreateReservationRequest $request, int $tripId)
    {
        $data = $request->all();
        $reservation = $this->reservationService->create($data);
         if (empty($reservation->id)) {
             return $this->errorResponse(500, "Internal error occurs");
         }
         return $this->created(['id' => $reservation->id, 'status' => true]);
    }
}
