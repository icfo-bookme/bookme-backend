<?php

namespace App\Http\Controllers;
use App\Models\FeatureCategory;
use App\Models\HotelFeature;
use App\Models\Feature;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelFeatureController extends Controller
{
    // Display a listing of hotel features
public function index($id)
{
    $hotelFeatures = FeatureCategory::with('feature')->where('isactive', 1)->where('type', 'hotel')->get();
    $hotel = Hotel::where('id',$id)->first();
   
    $existingFeatures = HotelFeature::where('hotel_id', $id)->get()->keyBy('feature_id');

    return view('hotel.hotel_features.index', [
        'hotelFeatures' => $hotelFeatures,
        'existingFeatures' => $existingFeatures,
        'hotelId' => $id,
        'destination_id' => $hotel->destination_id
    ]);
}


public function store(Request $request)
{
    $request->validate([
        'hotel_id' => 'required|exists:hotels,id',
        'features' => 'required|array',
    ]);

    $hotelId = $request->input('hotel_id');
    $features = $request->input('features');

   
    HotelFeature::where('hotel_id', $hotelId)->delete();

    foreach ($features as $featureId => $data) {
        HotelFeature::create([
            'hotel_id' => $hotelId,
            'feature_id' => $data['feature_id'],
            'isfeature' => isset($data['isfeature']) ? 1 : 0,
            'isfeature_summary' => isset($data['isfeature_summary']) ? 1 : 0,
        ]);
    }

    return redirect()->back()->with('success', 'Hotel features updated successfully.');
}


    // Display the specified hotel feature
    public function show($id)
    {
        $hotelFeature = HotelFeature::findOrFail($id);
        return view('hotel_features.show', compact('hotelFeature'));
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
        $hotelFeature = HotelFeature::findOrFail($id);

        $validated = $request->validate([
            'hotel_id' => 'exists:hotels,id',
            'feature_id' => 'exists:features,id',
            'isfeature' => 'boolean',
            'isfeature_summary' => 'boolean',
        ]);

        $hotelFeature->update($validated);
        return redirect()->route('hotel-features.index')->with('success', 'Hotel feature updated successfully!');
    }

    // Remove the specified hotel feature
    public function destroy($id)
    {
        $hotelFeature = HotelFeature::findOrFail($id);
        $hotelFeature->delete();
        return redirect()->route('hotel-features.index')->with('success', 'Hotel feature deleted successfully!');
    }
}