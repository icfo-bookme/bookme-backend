<?php

namespace App\Http\Controllers;

use App\Models\FlightRoute;
use Illuminate\Http\Request;

class FlightRouteController extends Controller
{
    public function index()
    {
        $flightRoutes = FlightRoute::all();
        return view('flight.flight_routes.index', compact('flightRoutes'));
    }

    public function create()
    {
        return view('flight_routes.create');
    }

 public function store(Request $request)
{ 
     try {
      
       $validated = $request->validate([
        'origin_city' => 'required|string|max:255',
        'destination_city' => 'required|string|max:255',
        'origin_airport_name' => 'required|string|max:255',
        'destination_airport_name' => 'required|string|max:255',
        'number_of_stops' => 'required|integer|min:0',
        'flight_duration' => 'required|string|max:255',
        'airline_icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'base_price' => 'required|numeric|min:0',
        'discount_percent' => 'nullable|numeric|between:0,100',
        'flight_type' => 'required|string|max:255',
        'popularity_score' => 'nullable|integer',
    ]);

       

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }
    

    // Handle file upload
    if ($request->hasFile('airline_icon_url')) {
        $imagePath = $request->file('airline_icon_url')->store('airline_icons', 'public');
        $validated['airline_icon_url'] = $imagePath;
    } else {
        $validated['airline_icon_url'] = null;
    }

    FlightRoute::create($validated);

    return redirect()->back()->with('success', 'Flight route created successfully.');
}

    public function show(FlightRoute $flightRoute)
    {
        return view('flight_routes.show', compact('flightRoute'));
    }

    public function edit(FlightRoute $flightRoute)
    {
        return view('flight_routes.edit', compact('flightRoute'));
    }

   public function update(Request $request, FlightRoute $flightRoute)
{
    try {
        $validated = $request->validate([
            'origin_city' => 'required|string|max:255',
            'destination_city' => 'required|string|max:255',
            'origin_airport_name' => 'required|string|max:255',
            'destination_airport_name' => 'required|string|max:255',
            'number_of_stops' => 'required|integer|min:0',
            'flight_duration' => 'required|string|max:255',
            'airline_icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'base_price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|between:0,100',
            'flight_type' => 'nullable|string|max:255',
             'popularity_score' => 'nullable|integer',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e->errors());
    }

    // Handle image replacement
    if ($request->hasFile('airline_icon_url')) {
        // Delete old image if it exists
        if ($flightRoute->airline_icon_url && \Storage::disk('public')->exists($flightRoute->airline_icon_url)) {
            \Storage::disk('public')->delete($flightRoute->airline_icon_url);
        }

        // Store new image
        $imagePath = $request->file('airline_icon_url')->store('airline_icons', 'public');
        $validated['airline_icon_url'] = $imagePath;
    } else {
        // Retain existing image path if no new image is uploaded
        $validated['airline_icon_url'] = $flightRoute->airline_icon_url;
    }

    $flightRoute->update($validated);

    return redirect()->back()->with('success', 'Flight route updated successfully.');
}


    public function destroy(FlightRoute $flightRoute)
    {
        $flightRoute->delete();
        return redirect()->back()->with('success', 'Flight route deleted.');
    }
}
