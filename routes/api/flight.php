<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightController;



Route::get('/flight/route/{type}', [FlightController::class, 'getFlightRoutes']);