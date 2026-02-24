<?php

namespace App\Http\Controllers;
use App\Models\Spot;

use Illuminate\Http\Request;

class TourpackagesController extends Controller
{
    public function destinations(){
        $spots = Spot::where('category', 'tour')->get();
       
        return view('tourpackages.destination', compact('spots'));
    }
}
