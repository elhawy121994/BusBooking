<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(ReservationController::class)->prefix('v1/trips/reservations/')->group(function () {
    Route::post('/{tripId}', 'create');
});

Route::controller(TripController::class)->prefix('v1/trips/seats')->group(function () {
    Route::post('/{tripId}', 'getTripSeats');
});

Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
