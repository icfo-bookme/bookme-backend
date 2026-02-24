<?php

namespace App\Http\Controllers;
use App\Models\FeatureCategory;
use App\Models\RoomFeature;
use App\Models\Feature;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomFeatureController extends Controller
{
    // Display a listing of hotel features
public function index($id)
{ 
    $roomFeature = FeatureCategory::with('feature')->where('isactive', 1)->where('type', 'room')->get();

    $existingFeatures = RoomFeature::where('room_id', $id)->get()->keyBy('feature_id');
    $hotel_id = Room::where('id', $id)->first()->hotel_id;
  
    return view('hotel.room.room_features.index', [
        'roomFeature' => $roomFeature,
        'existingFeatures' => $existingFeatures,
        'room_id' => $id,
        'hotel_id' => $hotel_id
    ]);
}


public function store(Request $request)
{ 
    $request->validate([
        'room_id' => 'required',
        'features' => 'required|array',
    ]);

    $room_id = $request->input('room_id');
    $features = $request->input('features');

   
    RoomFeature::where('room_id', $room_id)->delete();

    foreach ($features as $featureId => $data) {
        RoomFeature::create([
            'room_id' => $room_id,
            'feature_id' => $data['feature_id'],
            'isfeature' => isset($data['isfeature']) ? 1 : 0,
            'isfeature_summary' => isset($data['isfeature_summary']) ? 1 : 0,
        ]);
    }

    return redirect()->back()->with('success', 'Room features updated successfully.');
}


    // Display the specified hotel feature
    public function show($id)
    {
        $roomFeature = RoomFeature::findOrFail($id);
        return view('hotel_features.show', compact('roomFeature'));
    }

    // Show the form for editing the specified hotel feature
    public function edit($id)
    {
        $hotelFeature = HotelFeature::findOrFail($id);
        return view('hotel_features.edit', compact('hotelFeature'));
    }

    // Update the specified hotel feature
    public function update(Request $request, $id)
    {
        $roomFeature = RoomFeature::findOrFail($id);

        $validated = $request->validate([
            'room_id' => 'required',
            'feature_id' => 'exists:features,id',
            'isfeature' => 'boolean',
            'isfeature_summary' => 'boolean',
        ]);

        $roomFeature->update($validated);
        return redirect()->route('hotel-features.index')->with('success', 'Hotel feature updated successfully!');
    }

    // Remove the specified hotel feature
    public function destroy($id)
    {
        $roomFeature = RoomFeature::findOrFail($id);
        $roomFeature->delete();
        return redirect()->route('hotel-features.index')->with('success', 'Hotel feature deleted successfully!');
    }
}