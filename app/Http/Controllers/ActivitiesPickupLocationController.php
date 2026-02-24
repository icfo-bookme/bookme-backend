<?php

namespace App\Http\Controllers;

use App\Models\ActivitiesPickupLocation;
use App\Models\Property;
use Illuminate\Http\Request;

class ActivitiesPickupLocationController extends Controller
{
    // List all pickup locations for a property
    public function index($property_id)
    { 
        $locations = ActivitiesPickupLocation::where('property_id', $property_id)->get();
         $property = Property::findOrFail($property_id);
        return view('activities.activities_pickup_locations.index', compact('locations', 'property_id', 'property'));
    }

    // Show create form
    public function create()
    {
        return view('activities_pickup_locations.create');
    }

    // Store new pickup location
   public function store(Request $request)
{
    $request->validate([
        'destination'   => 'required|array',
        'destination.*' => 'required|string|max:255',
        'property_id'   => 'required|integer',
    ]);

    foreach ($request->destination as $dest) {
        ActivitiesPickupLocation::create([
            'destination' => $dest,
            'property_id' => $request->property_id,
        ]);
    }

    return redirect()->route('pickup_locations.index', ['property_id' => $request->property_id])
        ->with('success', 'Pickup location(s) created successfully.');
}


    // Show edit form
    public function edit($id)
    {
        $location = ActivitiesPickupLocation::findOrFail($id);
        return view('activities_pickup_locations.edit', compact('location'));
    }

    // Update a pickup location
    public function update(Request $request, $id)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
        ]);

        $location = ActivitiesPickupLocation::findOrFail($id);
        $location->update($request->only('destination'));

        return redirect()->back()
            ->with('success', 'Pickup location updated successfully.');
    }

    // Delete a pickup location
    public function destroy($id)
    {
        $location = ActivitiesPickupLocation::findOrFail($id);
        $property_id = $location->property_id;
        $location->delete();

        return redirect()->back()
            ->with('success', 'Pickup location deleted successfully.');
    }
}
