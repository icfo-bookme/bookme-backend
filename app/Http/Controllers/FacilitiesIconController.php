<?php

namespace App\Http\Controllers;

use App\Models\FacilitiesIcon;
use App\Models\Feature;
use Illuminate\Http\Request;

class FacilitiesIconController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $facilitiesIcons  = FacilitiesIcon::where('type','hotel')->get();
         $facilities  = Feature::where('type','hotel')->get();
        return view('hotel.facilities_icons.index', compact('facilitiesIcons','facilities'));
    }
    
     public function RoomFacilities()
    { 
        $roomFacilitiesIcons    = FacilitiesIcon::where('type','room')->get();
         $roomFacilities  = Feature::where('type','room')->get();
        return view('hotel.room.facilities_icons.index', compact('roomFacilitiesIcons','roomFacilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon_class' => 'required|string|max:100',
            'facility_id' => 'required',
             'type' => 'nullable|string|max:100',
        ]);

        FacilitiesIcon::create($request->all());

        return redirect()->back()
                        ->with('success', 'Facility icon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FacilitiesIcon $facilitiesIcon)
    {
        return view('facilities_icons.show', compact('facilitiesIcon'));
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FacilitiesIcon $facilitiesIcon)
    {
        $request->validate([
            'icon_class' => 'required|string|max:100',
            'facility_id' => 'required',
        ]);

        $facilitiesIcon->update($request->all());

        return redirect()->route('facilities-icons.index')
                        ->with('success', 'Facility icon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacilitiesIcon $facilitiesIcon)
    {
        $facilitiesIcon->delete();

        return redirect()->route('facilities-icons.index')
                        ->with('success', 'Facility icon deleted successfully');
    }
}