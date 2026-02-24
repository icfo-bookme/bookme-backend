<?php

namespace App\Http\Controllers;

use App\Models\HotelPolicy;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hotel_id)
    {
        $destination_id = Hotel::where('id',$hotel_id)->first()->destination_id;
        
        $policies = HotelPolicy::where('hotel_id', $hotel_id)->get();
        return view('hotel.hotel-policies.index', compact('policies','hotel_id','destination_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotel-policies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string',
             'icon_class' => 'required|string|max:255',
            'hotel_id' => 'required|max:255',
        ]);

        HotelPolicy::create($request->all());

        return redirect()->back()
            ->with('success', 'Policy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HotelPolicy $hotelPolicy)
    {
        return view('hotel-policies.show', compact('hotelPolicy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HotelPolicy $hotelPolicy)
    {
        return view('hotel-policies.edit', compact('hotelPolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HotelPolicy $hotelPolicy)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'hotel_id' => 'nullable|max:255',
        ]);

        $hotelPolicy->update($request->all());

        return redirect()->back()
            ->with('success', 'Policy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HotelPolicy $hotelPolicy)
    {
        $hotelPolicy->delete();

        return redirect()->back()
            ->with('success', 'Policy deleted successfully');
    }
}