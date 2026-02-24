<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Spot;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\PropertyUnit;
use App\Models\Itinerary;
use App\Models\PropertyImage;

class CarController extends Controller
{
      
     public function getCarModel(){
        $models = CarModel::all();
        return response()->json($models);
    }
    
      public function getCarBrand(){
        $brands = CarBrand::all();
        return response()->json($brands);
    }
    
      public function getCarRentaldestinations(){
        $destinations = Spot::where('category', 'car-rental')->get();
        return response()->json($destinations);
    }

public function propertyList($destination_id)
{
    $properties = Property::where('isactive', 1)
        ->where('destination_id', $destination_id)
        ->where('category_id', 7)
        ->with([
            'propertySummaries.summaryType',  // eager load the renamed relationship
            'propertySummaries.icons',
            'property_uinit.price',
            'property_uinit.discount',
            'CarPrice',
            'brand'
        ])
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
            'image' => $property->main_img,
            'brand' => $property->brand,
            // Include car pricing at root level
            'price_upto_4_hours' => optional($property->CarPrice)->price_upto_4_hours,
            'price_upto_6_hours' => optional($property->CarPrice)->price_upto_6_hours,
            'kilometer_price' => optional($property->CarPrice)->kilometer_price,

            // Summaries with icons
            'summaries' => $property->propertySummaries->map(function ($summary) {
                $summaryName = optional($summary->summaryType)->name;

                // Replace spaces with underscores in the summary name
                $key = str_replace(' ', '_', $summaryName);

                return [
                    'name' =>  optional($summary->summaryType)->name ,
                    $key => $summary->value,
                    'icon_name' => optional($summary->icons)->icon_name,
                    'icon_import' => optional($summary->icons)->icon_import,
                ];
            }),
        ];
    });

    return response()->json($data);
}


public function AllCars()
{
    $properties = Property::where('isactive', 1)
        ->where('category_id', 7)
        ->with('propertySummaries.icons', 'CarPrice')
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
            'image' => $property->main_img,

            // Include car pricing at root level
            'price_upto_4_hours' => optional($property->CarPrice)->price_upto_4_hours,
            'price_upto_6_hours' => optional($property->CarPrice)->price_upto_6_hours,
            'kilometer_price' => optional($property->CarPrice)->kilometer_price,

            // Summaries with icons
            'summaries' => $property->propertySummaries->map(function ($summary) {
                return [
                    'value' => $summary->value,
                    'icon_name' => optional($summary->icons)->icon_name,
                    'icon_import' => optional($summary->icons)->icon_import,
                ];
            }),
        ];
    });

    return response()->json($data);
}


}
