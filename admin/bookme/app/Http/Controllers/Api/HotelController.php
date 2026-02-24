<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HotelPhoto;
use App\Models\FeatureCategory;
use App\Models\Hotel_destination;
use App\Models\RoomImage;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\Room;
use App\Models\Feature;
use App\Models\HotelPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
   public function destroy($id)
    {
        
         $photo = HotelPhoto::find($id);
          $photo->delete();
        return response()->json([
            'success' => $photo,
            'message' => "Request received to delete photo with ID: $id"
        ]);
    }
    
    public function destroyRoom($id)
    { 
        
         $photo = RoomImage::find($id);
          $photo->delete();
        return response()->json([
            'success' => $photo,
            'message' => "Request received to delete photo with ID: $id"
        ]);
    }
    
  public function getAminities()
{
    // Fetch all features where type is 'hotel'
    $aminities = Feature::where('type', 'hotel')->get();

    // Return the amenities as a JSON response with proper key
    return response()->json(
        $aminities
    );
}

    
public function hotelAll()
{
   $hotels = Hotel::with('rooms')
    ->where('is_active', 1)
    ->orderByRaw('CASE WHEN sort_order = 0 THEN 1 ELSE 0 END, sort_order DESC')
    ->get();



    $formatted = $hotels->map(function ($hotel) {
        $rooms = $hotel->rooms;

        $roomsWithFinalPrice = $rooms->map(function ($room) {
            $discount = $room->discount ?? 0; // fixed typo: 'discount'
            $finalPrice = $room->price - ($room->price * $discount / 100);
            return [
                'price' => $room->price,
                'final_price' => round($finalPrice),
                'discount' =>$room->discouont,
            ];
        });

        $lowest = $roomsWithFinalPrice->sortBy('final_price')->first();

        return [
            'hotel_id' => $hotel->id,
            'hotel_name' => $hotel->name,
             'star_rating' => $hotel->star_rating,
            'image' => $hotel->main_photo,
             'street_address' => $hotel->street_address,
            'lowest_price' => $lowest['final_price'] ?? null,
            'original_price' => $lowest['price'] ?? null,
            'discount' => $lowest['discount'] ?? null,
            'sort_order' => $hotel->sort_order,
        ];
    });

    // Optional: force zero-based reindexing
    return response()->json($formatted->values());
}



public function hotelList($destination_id)
{
    $hotels = Hotel::with([
        'hotelFeatures' => function ($query) {
            $query->where('isfeature_summary', 1)->with(['feature.icon']);
        },
        'facilitiesFeatures' => function ($query) {
            $query->where('isfeature', 1)->with(['feature.icon']);
        },
        'rooms'
    ])
    ->where('destination_id', $destination_id)->where('is_active', 1)->orderBy('sort_order', 'desc') 
    ->get();

    $formatted = $hotels->map(function ($hotel) {
        $rooms = $hotel->rooms;

        // Calculate final prices for all rooms
        $roomsWithFinalPrice = $rooms->map(function ($room) {
            $discount = $room->discouont ?? 0; // Assuming 'discouont' is correct DB field
            $finalPrice = $room->price - ($room->price * $discount / 100);
            return [
                'price' => $room->price,
                'final_price' => round($finalPrice),
                'discount' => $discount
            ];
        });

        // Get the room with the lowest final price
        $lowest = $roomsWithFinalPrice->sortBy('final_price')->first();

        return [
            'id' => $hotel->id,
             'label' => $hotel->label,
            'name' => $hotel->name,
            'star' => $hotel->star_rating,
            'location' => $hotel->city,
            'street_address' => $hotel->street_address,
            'extra_discount_msg' => $hotel->extra_discount_msg,
            'img' => $hotel->main_photo,
            'regular_price' => $lowest['price'] ?? null,
            'price_after_discount' => $lowest['final_price'] ?? null,
            'discount' => $lowest['discount'] ?? null,

            // Summary features (isfeature_summary == 1)
            'summary' => $hotel->hotelFeatures->map(function ($hf) {
                return [
                    'id' => optional($hf->feature)->id,
                    'name' => optional($hf->feature)->name,
                    'type' => optional($hf->feature)->type,
                    'icon_class' => optional(optional($hf->feature)->icon)->icon_class
                ];
            })->filter(fn($item) => !is_null($item['id']))->values(),

            // Facilities features (isfeature == 1)
            'facilities' => $hotel->facilitiesFeatures->map(function ($hf) {
                return [
                    'id' => optional($hf->feature)->id,
                    'name' => optional($hf->feature)->name,
                    'type' => optional($hf->feature)->type,
                    'icon_class' => optional(optional($hf->feature)->icon)->icon_class
                ];
            })->filter(fn($item) => !is_null($item['id']))->values()
        ];
    });

    return response()->json($formatted);
}



public function hotelListbyid($id)
{
    $destination_id = Hotel::where('id', $id)->first()->destination_id;

    $hotels = Hotel::with([
        'hotelFeatures' => function ($query) {
            $query->where('isfeature_summary', 1)->with(['feature.icon']);
        },
        'facilitiesFeatures' => function ($query) {
            $query->where('isfeature', 1)->with(['feature.icon']);
        },
        'rooms'
    ])
    ->where('destination_id', $destination_id)
    ->where('is_active', 1)
    ->get();

    $formatted = $hotels->map(function ($hotel) {
        $rooms = $hotel->rooms;

        // Calculate final prices for all rooms
        $roomsWithFinalPrice = $rooms->map(function ($room) {
            $discount = $room->discouont ?? 0; // Assuming 'discouont' is correct DB field
            $finalPrice = $room->price - ($room->price * $discount / 100);
            return [
                'price' => $room->price,
                'final_price' => round($finalPrice),
                'discount' => $discount
            ];
        });

        // Get the room with the lowest final price
        $lowest = $roomsWithFinalPrice->sortBy('final_price')->first();

        return [
            'id' => $hotel->id,
            'label' => $hotel->label,
            'name' => $hotel->name,
            'star' => $hotel->star_rating,
            'location' => $hotel->city,
            'street_address' => $hotel->street_address,
            'extra_discount_msg' => $hotel->extra_discount_msg,
            'img' => $hotel->main_photo,
            'regular_price' => $lowest['price'] ?? null,
            'price_after_discount' => $lowest['final_price'] ?? null,
            'discount' => $lowest['discount'] ?? null,

            // Summary features (isfeature_summary == 1)
            'summary' => $hotel->hotelFeatures->map(function ($hf) {
                return [
                    'id' => optional($hf->feature)->id,
                    'name' => optional($hf->feature)->name,
                    'type' => optional($hf->feature)->type,
                    'icon_class' => optional(optional($hf->feature)->icon)->icon_class
                ];
            })->filter(fn($item) => !is_null($item['id']))->values(),

            // Facilities features (isfeature == 1)
            'facilities' => $hotel->facilitiesFeatures->map(function ($hf) {
                return [
                    'id' => optional($hf->feature)->id,
                    'name' => optional($hf->feature)->name,
                    'type' => optional($hf->feature)->type,
                    'icon_class' => optional(optional($hf->feature)->icon)->icon_class
                ];
            })->filter(fn($item) => !is_null($item['id']))->values()
        ];
    });

    // 👉 Force requested hotel ($id) to come first
    $formatted = $formatted->sortByDesc(function ($hotel) use ($id) {
        return (int) $hotel['id'] === (int) $id;
    })->values();

    return response()->json($formatted);
}




public function hotelDetails($hotel_id)
{
    //  Get hotel with all hotelFeatures and rooms
    $hotel = Hotel::with([
            'hotelFeatures' => function ($query) {
                $query->with(['feature.icon']);
            },
            'rooms', 'photos'
        ])
        ->where('id', $hotel_id)
        ->firstOrFail();
        
    $policies = HotelPolicy:: where('hotel_id', $hotel_id)->get();
    
   
    $generalCategory = FeatureCategory::where('name', 'General')->first();
    $generalCategoryId = $generalCategory?->id;

    //  Summary features from hotelFeatures where isfeature_summary = 1
   $features = $hotel->hotelFeatures->filter(function ($hf) use ($generalCategoryId) {
    return 
           $hf->isfeature == 1 && // must be marked as isfeature
           $hf->feature &&
           $hf->feature->isactive &&
           $hf->feature->category_id == $generalCategoryId;
})->map(function ($hf) {
    return [
        'id' => $hf->feature->id,
        'name' => $hf->feature->name,
        'type' => $hf->feature->type,
        'category_id' => $hf->feature->category_id,
        'icon_class' => optional($hf->feature->icon)->icon_class
    ];
})->take(6)->values();



    $categories = FeatureCategory::where('type', 'hotel')
        ->active()
        ->with(['feature.icon']) // eager load active features with icons
        ->get();

    $hotelFeatureIds = $hotel->hotelFeatures
        ->filter(fn($hf) => $hf->isfeature == 1 && $hf->feature && $hf->feature->isactive)
        ->pluck('feature_id')
        ->toArray();

 
    $categoryWiseFeatures = $categories->map(function ($category) use ($hotelFeatureIds) {
        $filteredFeatures = $category->feature->filter(function ($feature) use ($hotelFeatureIds) {
            return in_array($feature->id, $hotelFeatureIds);
        });

        return [
            'category_name' => $category->name,
            'features' => $filteredFeatures->map(function ($feature) {
                return [
                    'id' => $feature->id,
                    'name' => $feature->name,
                    'type' => $feature->type,
                    'icon_class' => optional($feature->icon)->icon_class
                ];
            })->values()
        ];
    })->filter(function ($category) {
        return $category['features']->isNotEmpty(); // remove empty categories
    })->values();

    
    

   
    $response = [
        'id' => $hotel->id,
        'name' => $hotel->name,
        'destination_id' => $hotel->destination_id,
        'label' => $hotel->label,
        'star' => $hotel->star_rating,
        'location' => $hotel->city,
        'address' => $hotel->street_address,
        'extra_discount_msg' => $hotel->extra_discount_msg,
        'img' => $hotel->main_photo,
        'near_by' => $hotel->near_by,
        'description' => $hotel->description,
        'number_of_rooms' => $hotel->number_of_rooms,
        'Number_of_Floors' => $hotel->Number_of_Floors,
        'Year_of_construction' => $hotel->Year_of_construction,
        'summary' => $features,
        'total_rooms' => $hotel->rooms->count(),
        'polices' => $policies,
        'images' => $hotel->photos,
        'category_wise_features' => $categoryWiseFeatures,
    ];

    return response()->json($response);
}

public function hotelRoom($hotel_id)
{
    $cacheKey = 'hotel_rooms_' . $hotel_id;
    $ttl = 12 * 60 * 60; // 12 hours in seconds

    $roomData = Cache::remember($cacheKey, $ttl, function () use ($hotel_id) {
        // Get all rooms for the hotel with their features and images
        
        $hotel = Hotel::findOrFail($hotel_id);

        $rooms = Room::with([
            'roomFeatures' => function ($q) {
                $q->where('isfeature', 1)->with(['feature.icon']);
            },
            'images', 'roomType'
        ])->where('hotel_id', $hotel_id)->get();

        $categories = FeatureCategory::with(['feature.icon'])
            ->where('type', 'room')
            ->active()
            ->get();

        return $rooms->map(function ($room) use ($categories, $hotel) {
            $roomFeatureIds = $room->roomFeatures->pluck('feature.id');

            $featureSummaries = [];
            $featuresByCategory = $categories->map(function ($category) use ($roomFeatureIds, $room, &$featureSummaries) {
                $matchingFeatures = $category->feature->filter(function ($feature) use ($roomFeatureIds) {
                    return $roomFeatureIds->contains($feature->id);
                });

                if ($matchingFeatures->isEmpty()) {
                    return null;
                }

                $roomFeatures = $room->roomFeatures->filter(function ($roomFeature) use ($matchingFeatures) {
                    return $matchingFeatures->contains('id', $roomFeature->feature_id);
                });

                $summaryFeatures = $roomFeatures->filter(function ($roomFeature) {
                    return $roomFeature->isfeature_summary;
                })->map(function ($roomFeature) {
                    return [
                        'id' => $roomFeature->feature->id,
                        'name' => $roomFeature->feature->name,
                        'icon_class' => optional($roomFeature->feature->icon)->icon_class
                    ];
                });

                if ($summaryFeatures->isNotEmpty()) {
                    $featureSummaries = array_merge($featureSummaries, $summaryFeatures->toArray());
                }

                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'features' => $roomFeatures->map(function ($roomFeature) {
                        return [
                            'id' => $roomFeature->feature->id,
                            'name' => $roomFeature->feature->name,
                            'isfeature_summary' => $roomFeature->isfeature_summary,
                            'icon_class' => optional($roomFeature->feature->icon)->icon_class
                        ];
                    })
                ];
            })->filter()->values();

            return [
                'id' => $room->id,
                'room_name' => $room->name,
                'destination_id' => $hotel->destination_id,
                'room_type' => $room->roomType->name ?? null,
                'description' => $room->description,
                'price' => $room->price,
                'final_price' => round($room->price - ($room->price * ($room->discouont ?? 0) / 100)),
                'discount' => $room->discouont,
                'breakfast_status' => $room->breakfast_status,
                'max_adults' => $room->max_adults,
                'complementary_child_occupancy' => $room->complementary_child_occupancy,
                'extra_bed_available' => $room->extra_bed_available,
                'max_guests_allowed' => $room->max_guests_allowed,
                'smoking_status' => $room->smoking_status,
                'room_characteristics' => $room->room_characteristics,
                'room_size_sqft' => $room->room_size_sqft,
                'room_view' => $room->room_view,
                'main_image' => $room->main_image,
                'images' => $room->images,
                'extra_discount_msg' => $hotel->extra_discount_msg,
                'features_by_category' => $featuresByCategory,
                'feature_summary' => $featureSummaries
            ];
        });
    });

    return response()->json($roomData);
}

  public function hotelImages($hotel_id){
    $images = HotelPhoto::where('hotel_id', $hotel_id)->get();
    return response()->json($images);
    
}  
    
    
      public function hotelDestination(){
        return response()->json(
           Hotel_destination::all()
        );
    }
    
       public function hotelCategories(){
        return response()->json(
           HotelCategory::all()
        );
    }
    
    
       public function success()
{
    $hotels = Hotel::leftJoin('rooms', 'rooms.hotel_id', '=', 'hotels.id')
        ->select(
            'hotels.id',
            'hotels.name',
            'hotels.star_rating',
            'hotels.street_address',
            'hotels.city',
            'hotels.main_photo',
            DB::raw('MIN(rooms.price) as price')
        )
        ->where('hotels.is_active', 1)
        ->where('hotels.destination_id', 702)
        ->groupBy(
            'hotels.id',
            'hotels.name',
            'hotels.star_rating',
            'hotels.street_address',
            'hotels.city',
            'hotels.main_photo'
        )
        ->orderBy('price', 'asc')
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'Hotel list fetched successfully',
        'data' => $hotels
    ], 200);
}
    
    
    
    
    
    
    
    
    
}
