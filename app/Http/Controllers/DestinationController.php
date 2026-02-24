<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel_destination;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    // Show all spots
    public function index()
    {
        $spots = Hotel_destination::all();
        return view('hotel.hotel_destination.index', compact('spots'));
    }

    // Store a new spot
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $validated;
        
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('hotel_destinations', 'public');
        }

        Hotel_destination::create($data);

        return redirect()->back()->with('success', 'Spot added successfully!');
    }

    // Show the form to edit a specific spot
    public function edit(Hotel_destination $hotel_destination)
    {
        return view('hotel.hotel_destination.edit', compact('hotel_destination'));
    }

    // Update an existing spot
    public function update(Request $request, Hotel_destination $hotel_destination)
    {  
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $validated;
        
        if ($request->hasFile('img')) {
            // Delete old image if exists
            if ($hotel_destination->img) {
                Storage::disk('public')->delete($hotel_destination->img);
            }
            $data['img'] = $request->file('img')->store('hotel_destinations', 'public');
        }

        $hotel_destination->update($data);

        return redirect()->back()->with('success', 'Spot updated successfully!');
    }

    // Delete a spot
    public function destroy(Hotel_destination $hotel_destination)
    {
        if ($hotel_destination->img) {
            Storage::disk('public')->delete($hotel_destination->img);
        }
        
        $hotel_destination->delete();

        return redirect()->back()->with('success', 'Spot deleted successfully!');
    }
}