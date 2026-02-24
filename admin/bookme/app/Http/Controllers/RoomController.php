<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function create(Hotel $hotel)
    {   
        $roomType = RoomType::all();
       
        return view('hotel.room.create', compact('hotel','roomType'));
    }

   public function index($hotel)
{
    $hotels = Hotel::where('id',$hotel)->first();
    $rooms = Room::where('hotel_id', $hotel)->get();
    $destination_id = $hotels->destination_id;
    return view('hotel.room.index', compact('rooms', 'hotel', 'destination_id'));
}

    
    
    
    
    
    
    
    public function store(Request $request, $hotelId)
    { 
        try {
      
        $validated =  $request->validate([
             'name' => 'required|string',
            'max_adults' => 'required|integer|min:1',
            'complementary_child_occupancy' => 'required|integer',
            'extra_bed_available' => 'required|integer',
            'max_guests_allowed' => 'required|integer|min:0',
            'room_type' => 'required|string|max:255',
            'smoking_status' => 'required|boolean',
            'room_characteristics' => 'nullable|string',
            'room_size_sqft' => 'nullable|numeric|min:0',
            'room_view' => 'nullable|string|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'breakfast_status' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);


    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }

        // Handle main image upload
        $mainImagePath = $request->file('main_image')->store('room_images', 'public');

        // Create the room
        $room = Room::create([
            'hotel_id' => $hotelId,
            'name' => $request->name,
            'max_adults' => $request->max_adults,
            'complementary_child_occupancy' => $request->complementary_child_occupancy,
            'extra_bed_available' => $request->extra_bed_available,
            'max_guests_allowed' => $request->max_guests_allowed,
            'room_type' => $request->room_type,
            'smoking_status' => $request->smoking_status,
            'room_characteristics' => $request->room_characteristics,
            'room_size_sqft' => $request->room_size_sqft,
            'room_view' => $request->room_view,
            'breakfast_status' => $request->breakfast_status,
            'main_image' => $mainImagePath,
            'description' => $request->description,
            'price' => $request->price,
            'discouont' => $request->discount,
        ]);

        // Handle additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->back()
            ->with('success', 'Room created successfully!');
    }

    public function edit($id)
    {   
         $roomType = RoomType::all();
        $room = Room::with('images')->findOrFail($id);
        $hotel_id = $room->hotel_id;
       
        return view('hotel.room.edit', compact('room', 'roomType','hotel_id'));
    }

    public function update(Request $request, $id)
    { 
        try {
      
        $validated =  $request->validate([
            'name' => 'required|string',
            'max_adults' => 'required|integer|min:1',
            'complementary_child_occupancy' => 'required|integer',
            'extra_bed_available' => 'required|boolean',
            'max_guests_allowed' => 'required|integer|min:0',
            'room_type' => 'required|string|max:255',
            'smoking_status' => 'required|boolean',
            'room_characteristics' => 'nullable|string',
            'room_size_sqft' => 'nullable|numeric|min:0',
            'room_view' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric|min:0',
            'discouont' => 'nullable|numeric|min:0|max:100',
             'breakfast_status' => 'required|string',
        ]);


    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); 
    }

        $room = Room::findOrFail($id);

        // Update main image if provided
        if ($request->hasFile('main_image')) {
            // Delete old image
            Storage::disk('public')->delete($room->main_image);
            
            $mainImagePath = $request->file('main_image')->store('room_images', 'public');
            $room->main_image = $mainImagePath;
        }

        // Update room details
        $room->update([
             'name' => $request->name,
            'max_adults' => $request->max_adults,
            'complementary_child_occupancy' => $request->complementary_child_occupancy,
            'extra_bed_available' => $request->extra_bed_available,
            'max_guests_allowed' => $request->max_guests_allowed,
            'room_type' => $request->room_type,
            'smoking_status' => $request->smoking_status,
            'room_characteristics' => $request->room_characteristics,
            'room_size_sqft' => $request->room_size_sqft,
            'room_view' => $request->room_view,
            'description' => $request->description,
            'price' => $request->price,
            'breakfast_status' => $request->breakfast_status,
            'discouont' => $request->discouont,
        ]);

        // Handle additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->back()
            ->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $hotelId = $room->hotel_id;

        // Delete main image
        Storage::disk('public')->delete($room->main_image);

        // Delete additional images
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $room->delete();

        return redirect()->back()
            ->with('success', 'Room deleted successfully!');
    }
}