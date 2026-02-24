<?php

namespace App\Http\Controllers;
use App\Models\Spot;

use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    public function destinations(){
       
        $spots = Spot::where('category', 'car-rental')->get();
        return view('CarRental.destination', compact('spots'));
    }
}
