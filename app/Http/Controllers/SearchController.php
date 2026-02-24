<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingOrder;
use App\Models\Customer;

class SearchController extends Controller
{
    public function submit(Request $request)
{
    $request->validate([
        'number' => 'required|numeric'
    ]);
    
    $user = Customer::where('phone', $request->number)->first();

    $hotel_orders = BookingOrder::with(['bookingDetails.room.hotel'])
        ->where('service_category_id', 3)
        ->orderBy('orderno', 'desc')
        ->where('mobile_no', $request->number)
        ->get();
        
     $activities_orders = BookingOrder::with(['activitieDetails'])
        ->where('service_category_id', 6)
        ->where('mobile_no', $request->number)
        ->get();
  
   
    
    return view('search.index', compact('hotel_orders', 'activities_orders', 'user'));
}

    public function search($number)
{
    
    
    $user = Customer::where('phone', $number)->first();

    $hotel_orders = BookingOrder::with(['bookingDetails.room.hotel'])
        ->where('service_category_id', 3)
        ->orderBy('orderno', 'desc')
        ->where('mobile_no', $number)
        ->get();
        
     $activities_orders = BookingOrder::with(['activitieDetails'])
        ->where('service_category_id', 6)
        ->where('mobile_no', $number)
        ->get();
    
    return view('search.log', compact('hotel_orders', 'activities_orders', 'user'));
}




}
