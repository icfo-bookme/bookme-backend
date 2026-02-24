<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Hotel_destination;
use App\Models\ItemLabel;
use App\Models\HotelCategory;
use App\Models\HotelCountry;
use App\Models\HotelPhoto;
use App\Models\HotelCategoryMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $categories = HotelCategory::all();
         $lavel = ItemLabel::all();
        $countries = HotelCountry::all();
        $hotels = Hotel::with('photos', 'category', 'user')->where('destination_id', $id)->get();
        return view('hotel.index', compact('hotels', 'categories', 'countries', 'id','lavel'));
    }
    
    public function getAllHotel(){
        $hotels = Hotel::all();
        $lavel = ItemLabel::all();
        $destinations = Hotel_destination::all();
        return view('hotel.allHotel', compact('hotels','destinations','lavel'));
    }

public function showEdit($id)
{   
    $hotel = Hotel::with('categories', 'photos')->where('id', $id)->firstOrFail();
    $destination_id = $hotel->destination_id;

    $categories = HotelCategory::all();
    $countries = HotelCountry::all();
    
    return view('hotel.edit', compact('hotel', 'categories', 'countries','destination_id'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $categories = HotelCategory::all();
        $countries = HotelCountry::all();
        return view('hotel.create', compact('categories', 'countries', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'destination_id' => 'required|integer',
            'star_rating' => 'nullable|numeric|min:0|max:5',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'country_id' => 'required|integer',
            'city' => 'nullable|string|max:100',
            'extra_discount_msg' => 'nullable|string',
            'street_address' => 'nullable|string|max:255',
            'languages_spoken' => 'nullable|string|max:255',
            'location_on_map' => 'nullable|string|max:255',
            'number_of_rooms' => 'nullable|integer',
            'Number_of_Floors' => 'nullable|integer',
            'Year_of_construction' => 'nullable|integer',
            'vat' => 'nullable|numeric',
            'service_charge' => 'nullable|numeric',
            'near_by' => 'nullable|string',
            'room_type' => 'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_ids' => 'required|json',
        ]);

        DB::beginTransaction();

        try {
            // Upload main photo if provided
            $mainPhotoPath = null;
            if ($request->hasFile('main_photo')) {
                $mainPhotoPath = $request->file('main_photo')->store('hotels/main', 'public');
            }

            // Create hotel
            $hotel = Hotel::create([
                'name' => $request->name,
                'description' => $request->description,
                'destination_id' => $request->destination_id,
                'star_rating' => $request->star_rating,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'website_url' => $request->website_url,
                'country_id' => $request->country_id,
                'city' => $request->city,
                'extra_discount_msg' => $request->extra_discount_msg,
                'street_address' => $request->street_address,
                'languages_spoken' => $request->languages_spoken,
                'location_on_map' => $request->location_on_map,
                'number_of_rooms' => $request->number_of_rooms,
                'Year_of_construction' => $request->Year_of_construction,
                'Number_of_Floors' => $request->Number_of_Floors,
                'near_by' => $request->near_by,
                'room_type' => $request->room_type,
                  'vat' => $request->vat,
                'service_charge' => $request->service_charge,
                'main_photo' => $mainPhotoPath,
                 'added_by' => Auth::id(),
            ]);

            // Handle categories
            $categoryIds = json_decode($request->input('category_ids'), true);
            if (is_array($categoryIds)) {
                foreach ($categoryIds as $categoryId) {
                    HotelCategoryMapping::create([
                        'hotel_id' => $hotel->id,
                        'category_id' => $categoryId
                    ]);
                }
            }

            // Upload additional photos if provided
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('hotels/photos', 'public');
                    HotelPhoto::create([
                        'hotel_id' => $hotel->id,
                        'photo' => $photoPath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Hotel created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create hotel: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load('photos', 'categories');
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'star_rating' => 'nullable|numeric|min:0|max:5',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'country_id' => 'required|integer',
            'extra_discount_msg' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'Number_of_Floors' => 'nullable|integer',
            'Year_of_construction' => 'nullable|integer',
            'near_by' => 'nullable|string',
            'street_address' => 'nullable|string|max:255',
            'languages_spoken' => 'nullable|string|max:255',
            'location_on_map' => 'nullable|string|max:255',
              'near_by' => 'nullable|string',
                'room_type' =>'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'integer|exists:hotel_photos,id',
            'category_ids' => 'required|json',
        ]);

        DB::beginTransaction();

        try {
            // Update main photo if provided
            if ($request->hasFile('main_photo')) {
                // Delete old main photo if exists
                if ($hotel->main_photo) {
                    Storage::disk('public')->delete($hotel->main_photo);
                }
                
                $mainPhotoPath = $request->file('main_photo')->store('hotels/main', 'public');
                $hotel->main_photo = $mainPhotoPath;
            }

            $hotel->update([
                'name' => $request->name,
                'description' => $request->description,
                'star_rating' => $request->star_rating,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'website_url' => $request->website_url,
                'country_id' => $request->country_id,
                'Year_of_construction' => $request->Year_of_construction,
                'Number_of_Floors' => $request->Number_of_Floors,
                'near_by' => $request->near_by,
                'city' => $request->city,
                  'vat' => $request->vat,
                 'room_type' => $request->room_type,
                'service_charge' => $request->service_charge,
                'extra_discount_msg' => $request->extra_discount_msg,
                'street_address' => $request->street_address,
                'languages_spoken' => $request->languages_spoken,
                'location_on_map' => $request->location_on_map,
                'main_photo' => $hotel->main_photo,
            ]);

            // Handle categories - first delete existing mappings
            HotelCategoryMapping::where('hotel_id', $hotel->id)->delete();
            
            // Then add new mappings
            $categoryIds = json_decode($request->input('category_ids'), true);
            if (is_array($categoryIds)) {
                foreach ($categoryIds as $categoryId) {
                    HotelCategoryMapping::create([
                        'hotel_id' => $hotel->id,
                        'category_id' => $categoryId
                    ]);
                }
            }

            // Delete selected photos if any
            if ($request->has('delete_photos')) {
                $photosToDelete = HotelPhoto::whereIn('id', $request->delete_photos)
                    ->where('hotel_id', $hotel->id)
                    ->get();
                
                foreach ($photosToDelete as $photo) {
                    Storage::disk('public')->delete($photo->photo);
                    $photo->delete();
                }
            }

            // Upload new additional photos if provided
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('hotels/photos', 'public');
                    HotelPhoto::create([
                        'hotel_id' => $hotel->id,
                        'photo' => $photoPath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Hotel updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update hotel: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        DB::beginTransaction();

        try {
            // Delete main photo if exists
            if ($hotel->main_photo) {
                Storage::disk('public')->delete($hotel->main_photo);
            }

            // Delete all associated photos
            $photos = $hotel->photos;
            foreach ($photos as $photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            // Delete category mappings
            HotelCategoryMapping::where('hotel_id', $hotel->id)->delete();

            // Delete the hotel
            $hotel->delete();

            DB::commit();

            return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete hotel: ' . $e->getMessage());
        }
    }
    
    public function statusUpdate(Request $request){
        $hotels = $request->input('hotels', []);
    foreach ($hotels as $hotelData) {

        Hotel::where('id', $hotelData['id'])->update([
            'is_active' => $hotelData['is_active'],
            'sort_order' => $hotelData['sort_order'],
             'label' => $hotelData['label'],
        ]);
    }

    return back()->with('success', 'Selected hotels updated successfully!');
        
    }
    
    public function filter(Request $request)
    {
        // This is only needed if you implement AJAX filtering later
        $query = Hotel::where('destination_id', $request->destination_id);
        
        if ($request->rating) {
            $query->where('star_rating', $request->rating);
        }
        
        if ($request->badge) {
            $query->where('label', $request->badge);
        }
        
        $hotels = $query->get();
        $lavel = Label::all();
        
        return response()->json([
            'html' => view('partials.hotels_rows', compact('hotels', 'lavel'))->render()
        ]);
    }
}