<?php

namespace App\Http\Controllers;
use App\Models\Spot;
use App\Models\PropertySummary;
use App\Models\Property;
use App\Models\Icon;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;

class activitiesController extends Controller
{
    public function index()
    {
        $spots = Spot::where('category', 'activities')->get();
       
        return view('activities.destination', compact('spots'));
    } //
    
    public function getPropertySummary($property_id)
{
    
    $property = Property::findOrFail($property_id);  
    $summaries = PropertySummary::where('property_id', $property_id)->get();  
    $icons = Icon::all();
   
    return view('activities.property-summary.show', compact('property', 'summaries', 'property_id', 'icons'));
}


public function Packages($property_id)
{
   
    $property = Property::with('property_uinit.discount', 'property_uinit.price')->findOrFail($property_id);
     
    return view('activities.property_units.show', compact('property_id', 'property'));
}
}
