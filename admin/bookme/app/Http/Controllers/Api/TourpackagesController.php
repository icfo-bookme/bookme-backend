<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Spot;
use App\Models\CarModel;
use App\Models\BrandProperty;
use App\Models\PropertyUnit;
use App\Models\Itinerary;
use App\Models\PropertyImage;

class TourpackagesController extends Controller
{
    
    
    public function gettourdestinations(){
        $destinations = Spot::where('category', 'tour')->get();
        return response()->json($destinations);
    }
    
    
    
    public function propertyList($destination_id)
{
    $properties = Property::where('isactive', 1)
        ->where('destination_id', $destination_id)
        ->where('category_id', 5)
        ->with('propertySummaries.icons') // only summaries and icons
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
            
            'image' => $property->main_img,
            'address' => $property->address,
            'price' => $property->price,
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


    public function propertyListAll()
{
    $properties = Property::where('isactive', 1)
        ->where('category_id', 5)
        ->with('propertySummaries.icons') // only summaries and icons
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
              'category_id' => $property->category_id,
            'image' => $property->main_img,
            'address' => $property->address,
            'price' => $property->price,
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





public function propertyDetails($id)
{
    // Fetch the property with related summaries, facilities, and icons
    $property = Property::where('property_id', $id)
        ->with('propertySummaries.summaryType', 'propertySummaries.icons')
        ->with('tourpackageRequirment')
        ->with(['facilities.facilityTypes', 'facilities.icons'])
        ->first();

    if (!$property) {
        return null;
    }

    // Get all images for this property
    $images = PropertyImage::where('property_id', $id)->pluck('path');

    // Load related car models with property info (only include if property_id is found)
    $models = null;
    $brand = BrandProperty::where('property_id', $id)->first();

    if ($brand) {
        $models = CarModel::with('brandProperty')
            ->where('brand_id', $brand->brand_id)
            ->get()
            ->map(function ($model) {
                $brandProperty = $model->brandProperty;

                // if property_id is not set, return null so we can filter later
                if (!$brandProperty || !$brandProperty->property_id) {
                    return null;
                }

                $relatedProperty = Property::find($brandProperty->property_id);

                if (!$relatedProperty) {
                    return null;
                }

                return [
                    'id' => $model->id,
                    'brand_id' => $model->brand_id,
                    'model_name' => $model->model_name,
                    'status' => $model->status,
                    'property_id' => $brandProperty->property_id,
                    'property_name' => $relatedProperty->property_name,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                    'brand_property' => $brandProperty,
                ];
            })
            ->filter() // ✅ remove null entries (no property_id)
            ->values(); // reindex the collection
    }

    // Get all packages (units) with price and discount
    $units = PropertyUnit::with('price', 'discount')
        ->where('property_id', $id)
        ->get();

    // Format the package data
    $packages = $units->map(function ($unit) {
        $regularPrice = optional($unit->price->first())->price ?? 0;
        $discount = optional($unit->discount);
        $discountedPrice = $regularPrice;

        if ($discount) {
            if ($discount->discount_percent > 0) {
                $discountedPrice = $regularPrice - (($discount->discount_percent / 100) * $regularPrice);
            } elseif ($discount->discount_amount > 0) {
                $discountedPrice = $regularPrice - $discount->discount_amount;
            }
        }

        return [
            'id' => $unit->unit_id,
            'package_name' => $unit->unit_name,
            'duration' => $unit->unit_no,
            'person_allowed' => $unit->person_allowed,
            'image' => $unit->mainimg,
            'description' => $unit->description,
            'package_type' => $unit->unit_type,
            'regular_price' => $regularPrice,
            'discount_amount' => $discount->discount_amount ?? 0,
            'discount_percentage' => $discount->discount_percent ?? 0,
            'discounted_price' => round(max($discountedPrice, 0), 2),
        ];
    });

    // Group facilities by type
    $facilitiesGrouped = $property->facilities
        ->groupBy(function ($facility) {
            return optional($facility->facilityTypes)->facility_typename ?? 'Unknown';
        })
        ->map(function ($facilitiesGroup) {
            return $facilitiesGroup->map(function ($facility) {
                return [
                    'value' => $facility->value ?? null,
                    'icon' => optional($facility->icons)->icon_import ?? null,
                ];
            })->values();
        });

    // Fetch itineraries for the property
    $Itinerary = Itinerary::where('property_id', $id)->get();

    // Group itineraries by day number and sort by time
    $itineraryGrouped = $Itinerary->groupBy('dayno')->mapWithKeys(function ($items, $dayno) {
        $sortedItems = $items->sortBy('time');
        return [
            'Day' . $dayno => $sortedItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'time' => $item->time,
                    'name' => $item->name,
                    'value' => $item->value,
                    'location' => $item->location,
                    'duration' => $item->duration,
                    'image' => $item->image,
                ];
            })->values()
        ];
    });

    // Prepare main response data
    $data = [
        'id' => $property->property_id,
        'property_name' => $property->property_name,
        'destination_id' => $property->destination_id,
        'category_id' => $property->category_id,
        'image' => $property->main_img,
        'images' => $images,
        'models' => $models && $models->isNotEmpty() ? $models : null, 
        'address' => $property->address,
        'summaries' => $property->propertySummaries->map(function ($summary) {
            return [
                'name' => optional($summary->summaryType)->name,
                'value' => $summary->value,
                'icon_name' => optional($summary->icons)->icon_name,
                'icon_import' => optional($summary->icons)->icon_import,
            ];
        }),
        'requirements' => optional($property->tourpackageRequirment)->requirments,
        'facilities' => $facilitiesGrouped,
        'packages' => $packages,
    ];

    // Insert itineraries after facilities
    $finalData = [];
    foreach ($data as $key => $value) {
        $finalData[$key] = $value;
        if ($key === 'facilities') {
            $finalData['itineraries'] = $itineraryGrouped;
        }
    }

    return $finalData;
}



















}
