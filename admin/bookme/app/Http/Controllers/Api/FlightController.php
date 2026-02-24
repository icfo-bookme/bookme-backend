<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlightRoute;

class FlightController extends Controller
{
    public function getFlightRoutes($type){
        $routes = FlightRoute::where('flight_type', $type)->orderBy('popularity_score', 'desc')->get();
        return response()->json($routes);
    }
}
