<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\TripServiceInterface;

class TripController extends BaseController
{

    protected TripServiceInterface $tripService;

    public function __construct(TripServiceInterface $tripService)
    {
        $this->tripService = $tripService;
    }

}
