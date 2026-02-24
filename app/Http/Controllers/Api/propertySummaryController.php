<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\CountryVisa;
use App\Models\PropertyUnit;

class propertySummaryController extends Controller
// property api for home
{
  
   public function apiCreate($destination_id){

    $property_summary = Property::where('isactive', 1)->where('destination_id', $destination_id)->where('category_id', 1)->with('propertySummaries.icons','property_uinit.price','property_uinit.discount')->get();
    return response()->json($property_summary);
}
   public function apiCreateForAll($category_id,$destination_id){
   
   $property_summary = Property::where('isactive', 1)
    ->where('destination_id', $destination_id)
    ->where('category_id', $category_id)
    ->with([
            'country',
            'propertySummaries.icons',
            'property_uinit.price',
            'facilities' => function ($query) {
                $query->orderBy('serialno', 'desc'); 
            }
        ])
    ->firstOrFail();
    return response()->json($property_summary);
}
public function apiCreate1()
{
    $property_summary = Property::where('isactive', 1) ->where('destination_id', 1)
        ->with([
            'propertySummaries.icons',
            'property_unit.price'
        ])
        ->get();

    return response()->json($property_summary);
}
  public function isPopular($destination_id){

    $property_summary = Property::where('isactive', 1)->where('destination_id', $destination_id)->with('propertySummaries.icons','property_uinit.price') ->orderBy('popularity', 'desc')->get();
    return response()->json($property_summary);
}
// property images api for home
public function apiForPropertyImages($property_id){

    $Images = PropertyImage::where('property_id', $property_id)->get();

    return response()->json($Images);
}
// property with id api for home
public function apiForPropertySummary($property_id)
{
    $property_summary = Property::with('propertySummaries.icons')  
                                ->where('property_id', $property_id)  
                                ->get();  
   
    return response()->json($property_summary);  
}
// property facilities api for home
public function apiForPropertyFacilities($property_id)
{
    $property_summary = Property::with([
        'facilities.icons',
        'facilities.facilityTypes'
    ])->where('property_id', $property_id)->first();

    if (!$property_summary) {
        return response()->json(['message' => 'Property not found'], 404);
    }

    // Transform and group facilities by their facility_typename
    $groupedFacilities = $property_summary->facilities->groupBy(function ($facility) {
        return $facility->facilityTypes->facility_typename ?? 'Unknown';
    })->map(function ($group, $key) {
        return [
            'facility_type' => $key,
            'facilities' => $group->map(function ($facility) {
                return [
                    'facility_name' => $facility->facilty_name,
                    'value' => $facility->value,
                    'img' => $facility->img,
                    'icon' => $facility->icons->icon_name ?? null,
                ];
            })->values() // Ensure facilities is an array
        ];
    })->values(); // Ensure grouped facilities is an array

    // Prepare final response structure
    $response = [
        'property_id' => $property_summary->property_id,
        'property_name' => $property_summary->property_name,
        'description' => $property_summary->description,
        'facilities' => $groupedFacilities->toArray(), // Convert to plain array
    ];

    return response()->json($response);
}
public function apiForPropertyUnit($property_id){

    $units = PropertyUnit::with('price','discount')-> where('property_id', $property_id)->get();

    return response()->json($units);
}
public function getAllCountry(){
    $countries = CountryVisa::with('properties.propertySummaries', 'properties.property_uinit.price')
        ->where('is_active', true)
        ->orderBy('popularityScore', 'desc')
        ->get();
    
    return response()->json($countries);
}


public function getCountry($id){
    $countries = CountryVisa::findOrFail($id);
    return response()->json($countries);
}
public function getCountries(){
    $countries = CountryVisa::all();
    return response()->json($countries);
}
public function getShipProperties($id)
{
    $properties = Property::where('category_id', $id)
        ->get(['property_id', 'property_name'])
        ->map(function ($property) {
            $property->type = 'property'; 
            return $property;
        });

    return response()->json($properties);
}



}
