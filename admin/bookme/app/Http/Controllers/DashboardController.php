<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Property;
use App\Models\FlightRoute;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\TourConsultationRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // Count data
        $totalHotel = Hotel::count();
        $totaltourpackages = Property::where('category_id', 5)->count();
        $activities = Property::where('category_id', 6)->count();
        $cars = Property::where('category_id', 7)->count();

        // Destination-wise property count
        $tanguarhaorProperty = Property::where('category_id', 1)->where('destination_id', 1)->count();
        $sundarbanProperty   = Property::where('category_id', 1)->where('destination_id', 2)->count();
        $saintmartinProperty = Property::where('category_id', 1)->where('destination_id', 3)->count();

        // Flight route count
        $flightRoute = FlightRoute::count();

        // Latest records (limit 7)
        $customers = Customer::latest()->take(7)->get();
        $expenses = Expense::latest()->take(7)->get();
        $getacall = TourConsultationRequest::latest()->take(7)->get();

        return view('dashboard', compact(
            'totalHotel',
            'totaltourpackages',
            'activities',
            'cars',
            'tanguarhaorProperty',
            'sundarbanProperty',
            'saintmartinProperty',
            'flightRoute',
            'customers',
            'expenses',
            'getacall'
        ));
    }
}
