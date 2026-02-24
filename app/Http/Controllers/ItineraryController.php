<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Property;

class ItineraryController extends Controller
{
    // Show all itineraries
    public function index()
    {
        $itineraries = Itinerary::all();
        return view('tourpackages.itineraries.index', compact('itineraries'));
    }

   public function create($property_id)
{
     $destination_id = Property::where('property_id', $property_id)->First()->destination_id;
    return view('tourpackages.itineraries.create', compact('property_id','destination_id'));
}

 public function store(Request $request)
{ 
    $request->validate([
        'itineraries.*.dayno' => 'required|integer|min:1',
        'itineraries.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    foreach ($data['itineraries'] as $key => $item) {
        $itineraryData = [
            'dayno' => $item['dayno'],
            'property_id' => $request->property_id,
            'time' => $item['time'] ?? null,
            'name' => $item['name'] ?? null,
            'value' => $item['value'] ?? null,
            'location' => $item['location'] ?? null,
            'duration' => $item['duration'] ?? null,
        ];

        // Handle image upload if present (store in public directory)
        if ($request->hasFile("itineraries.$key.image")) {
            $image = $request->file("itineraries.$key.image");
            $imageName = 'itinerary_' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/itineraries'), $imageName);
            $itineraryData['image'] = 'images/itineraries/' . $imageName;
        }

        Itinerary::create($itineraryData);
    }

    return redirect()->back()->with('success', 'Itineraries added successfully.');
}

    // Show single itinerary
    public function show(Itinerary $itinerary)
    {
        return view('itineraries.show', compact('itinerary'));
    }

   public function edit($property_id)
{
    $itineraries = Itinerary::where('property_id', $property_id)->get()->groupBy('dayno');
     $destination_id = Property::where('property_id', $property_id)->First()->destination_id;
    return view('tourpackages.itineraries.edit', compact('itineraries','destination_id'));
}


    // Update itinerary
  public function update(Request $request, Itinerary $itinerary)
{
    $request->validate([
        'dayno' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only([
        'dayno',
        'time',
        'name',
        'value',
        'location',
        'duration',
        'property_id',
    ]);

    // Handle image update
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($itinerary->image && file_exists(public_path($itinerary->image))) {
            unlink(public_path($itinerary->image));
        }

        // Upload new image
        $image = $request->file('image');
        $imageName = 'itinerary_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/itineraries'), $imageName);

        $data['image'] = 'images/itineraries/' . $imageName;
    }

    $itinerary->update($data);

    return redirect()->back()->with('success', 'Itinerary updated successfully.');
}

    // Delete itinerary
    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect()->route('itineraries.index');
    }
}
