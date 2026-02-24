<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Spot;
use App\Models\Itinerary;
use App\Models\ActivitiesPickupLocation;
use App\Models\PropertyImage;

class ActivitiesController extends Controller
{
    
    
    public function getactivitiesdestinations(){
        $destinations = Spot::where('category', 'activities')->get();
        return response()->json($destinations);
    }
    
  public function getPickupDestinations($property_id){
        $locations = ActivitiesPickupLocation::where('property_id', $property_id)->get();
        return response()->json($locations);
    }
    
public function getpropertyList($destination_id)
{
    $properties = Property::where('isactive', 1)
        ->where('destination_id', $destination_id)
        ->where('category_id', 6)
        ->with([
            'propertySummaries.summaryType',  // eager load the renamed relationship
            'propertySummaries.icons',
            'property_uinit.price',
            'property_uinit.discount'
        ])
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        
        $lowestUnit = $property->property_uinit->map(function ($unit) {
            $minPrice = $unit->price->min('price');

            if (!$minPrice) {
                return null; 
            }

            $discount = $unit->discount;

            $finalPrice = $minPrice;
            $discountValue = 0;

            if ($discount) {
                if ($discount->discount_percent > 0) {
                    $discountValue = ($minPrice * $discount->discount_percent) / 100;
                } elseif ($discount->discount_amount > 0) {
                    $discountValue = $discount->discount_amount;
                }

                $finalPrice = $minPrice - $discountValue;
            }

            return [
                'unit_id' => $unit->unit_id,
                'original_price' => $minPrice,
                'final_price'    => $finalPrice,
                'discount_percent' => $discount ? $discount->discount_percent : 0,
                'discount_amount'  => $discount ? $discount->discount_amount : 0,
            ];
        })->filter()->sortBy('original_price')->first();

        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
            'destination_id' => $property->destination_id,
            'category_id' => $property->category_id,
            'image' => $property->main_img,
            'address' => $property->address,
            'price' => $lowestUnit ? $lowestUnit['original_price'] : null,
            'final_price' => $lowestUnit ? $lowestUnit['final_price'] : null,
            'discount_percent' => $lowestUnit ? $lowestUnit['discount_percent'] : 0,
            'discount_amount'  => $lowestUnit ? $lowestUnit['discount_amount'] : 0,
            'summaries' => $property->propertySummaries->map(function ($summary) {
                return [
                    // Use the renamed relation summaryType to get actual name
                    
                    optional($summary->summaryType)->name => $summary->value,
                    'icon_name' => optional($summary->icons)->icon_name,
                    'icon_import' => optional($summary->icons)->icon_import,
                ];
            }),
        ];
    });

    return response()->json($data);
}





    public function getactivities()
{
   $properties = Property::where('isactive', 1)
        ->where('category_id', 6)
        ->with([
            'propertySummaries.icons',
            'property_uinit.price',
            'property_uinit.discount'
        ])
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        
        $lowestUnit = $property->property_uinit->map(function ($unit) {
            $minPrice = $unit->price->min('price');

            if (!$minPrice) {
                return null; 
            }

            $discount = $unit->discount;

            $finalPrice = $minPrice;
            $discountValue = 0;

            if ($discount) {
                if ($discount->discount_percent > 0) {
                    // percentage discount
                    $discountValue = ($minPrice * $discount->discount_percent) / 100;
                } elseif ($discount->discount_amount > 0) {
                    // fixed amount discount
                    $discountValue = $discount->discount_amount;
                }

                $finalPrice = $minPrice - $discountValue;
            }

            return [
                'unit_id' => $unit->unit_id,
                'original_price' => $minPrice,
                'final_price'    => $finalPrice,
                'discount_percent' => $discount ? $discount->discount_percent : 0,
                'discount_amount'  => $discount ? $discount->discount_amount : 0,
            ];
        })->filter()->sortBy('original_price')->first();

        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
             'category_id' => $property->category_id,
            'image' => $property->main_img,
            'address' => $property->address,
            'price' => $lowestUnit ? $lowestUnit['original_price'] : null,
            'final_price' => $lowestUnit ? $lowestUnit['final_price'] : null,
            'discount_percent' => $lowestUnit ? $lowestUnit['discount_percent'] : 0,
            'discount_amount'  => $lowestUnit ? $lowestUnit['discount_amount'] : 0,
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
        ->with('propertySummaries.icons')
        ->with('tourpackageRequirment')
        ->with(['facilities.facilityTypes', 'facilities.icons'])
        ->first();

    if (!$property) {
        return null;
    }

    // Get all images for this property
    $images = PropertyImage::where('property_id', $id)
        ->pluck('path'); // Adjust column name if needed

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
     $packages = PropertyUnit::with('price','discount')->where('property_id', $id)->get();

    // Group itineraries by dayno and sort by time
    $itineraryGrouped = $Itinerary->groupBy('dayno')->mapWithKeys(function ($items, $dayno) {
        $sortedItems = $items->sortBy('time'); // sort by time if needed
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

    // Prepare base data without itineraries
    $data = [
        'id' => $property->property_id,
        'property_name' => $property->property_name,
        'image' => $property->main_img,
        'images' => $images,
        'address' => $property->address,
        'summaries' => $property->propertySummaries->map(function ($summary) {
            return [
                'value' => $summary->value,
                'icon_name' => optional($summary->icons)->icon_name,
                'icon_import' => optional($summary->icons)->icon_import,
            ];
        }),
        'requirements' => optional($property->tourpackageRequirment)->requirments,
        'facilities' => $facilitiesGrouped,
    ];

    // Insert itineraries right after facilities if facilities exist
    $finalData = [];
    foreach ($data as $key => $value) {
        $finalData[$key] = $value;
        if ($key === 'facilities') {
            $finalData['itineraries'] = $itineraryGrouped;
        }
    }

    return $finalData;
}


public function getrelatedproperty($destination_id, $property_id)
{
    $properties = Property::where('isactive', 1)
        ->where('destination_id', $destination_id)
        ->where('category_id', 6)
        ->where('property_id', '!=', $property_id)
        ->with([
            'propertySummaries.icons',
            'property_uinit.price',
            'property_uinit.discount'
        ])
        ->orderBy('popularity', 'desc')
        ->get();

    $data = $properties->map(function ($property) {
        
        $lowestUnit = $property->property_uinit->map(function ($unit) {
            $minPrice = $unit->price->min('price');

            if (!$minPrice) {
                return null; 
            }

            $discount = $unit->discount;

            $finalPrice = $minPrice;
            $discountValue = 0;

            if ($discount) {
                if ($discount->discount_percent > 0) {
                    // percentage discount
                    $discountValue = ($minPrice * $discount->discount_percent) / 100;
                } elseif ($discount->discount_amount > 0) {
                    // fixed amount discount
                    $discountValue = $discount->discount_amount;
                }

                $finalPrice = $minPrice - $discountValue;
            }

            return [
                'unit_id' => $unit->unit_id,
                'original_price' => $minPrice,
                'final_price'    => $finalPrice,
                'discount_percent' => $discount ? $discount->discount_percent : 0,
                'discount_amount'  => $discount ? $discount->discount_amount : 0,
            ];
        })->filter()->sortBy('original_price')->first();

        return [
            'id' => $property->property_id,
            'property_name' => $property->property_name,
             'category_id' => $property->category_id,
            'image' => $property->main_img,
            'address' => $property->address,
            'price' => $lowestUnit ? $lowestUnit['original_price'] : null,
            'final_price' => $lowestUnit ? $lowestUnit['final_price'] : null,
            'discount_percent' => $lowestUnit ? $lowestUnit['discount_percent'] : 0,
            'discount_amount'  => $lowestUnit ? $lowestUnit['discount_amount'] : 0,
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
