<?php

namespace App\Http\Controllers;

use App\Models\PropertyFacility;
use App\Models\Property;
use App\Models\Icon;
use App\Models\PropertyFacilityType;
use Illuminate\Http\Request;

class AddFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $facilities = PropertyFacility::all();
        return view('property_facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('property_facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    { 
         
      $data =  $request->validate([
            'property_id' => 'required|integer',
            'facility_type' => 'nullable|string|max:255',
            'facility_name' => 'nullable|string|max:255',
            'value' => 'required|string',
            'icon' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'isactive' => 'required|boolean',
            'serialno' => 'nullable|string|max:255',
        ]);

        // Store the image if it exists
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('facility_images', 'public');
        } else {
            $imagePath = null;
        }

        // Create the new property facility record
       $inserteData = PropertyFacility::create([
            'property_id' => $request->property_id,
            'facility_type' => $request->facility_type,
            'facilty_name' => $request->facility_name,
            'value' => $request->value,
            'icon' => $request->icon,
            'img' => $imagePath,
            'isactive' => $request->isactive,
            'serialno' => $request->serialno,
        ]);
     
        return redirect()->back()
        ->with('success', 'Facility updated successfully.');
       
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    
    $property = Property::with('facilities')->findOrFail($id);
    $category_id = $property->category_id;
    $facilitiestype = PropertyFacilityType::where('property_category', $property->category_id)->get();
    $icons = Icon::all();
    return view('facilities.show', compact('property', 'id', 'facilitiestype', 'icons', 'category_id'));
}
    public function showVisa(string $id)
{
    
    $property = Property::with('facilities')->findOrFail($id);
    $facilitiestype = PropertyFacilityType::where('property_category', $property->category_id)->get();
    $icons = Icon::all();
    return view('visa.facilities.show', compact('property', 'id', 'facilitiestype', 'icons'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facility = PropertyFacility::findOrFail($id);
        return view('property_facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {  
        $data = $request->validate([
            'facility_type' => 'nullable|string|max:255',
            'facility_name' => 'nullable|string|max:255',
            'serialno' => 'nullable',
            'icon' => 'nullable|string',
            'value' => 'required|string',
        ]);

        $facility = PropertyFacility::where('id', $id)->firstOrFail();
        $facility->update([  
            'facilty_name' => $data['facility_name']??null, 
            'facility_type' => $data['facility_type']??null, 
            'value' => $data['value'],  
            'icon' => $data['icon'] ?? null, 
            'serialno' => $data['serialno'] ?? 0, 
        ]);
       
        return redirect()->back()
    ->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facility = PropertyFacility::findOrFail($id);
        if ($facility->img && file_exists(storage_path('app/public/' . $facility->img))) {
            unlink(storage_path('app/public/' . $facility->img));
        }

        $facility->delete();
        return redirect()->back()
                         ->with('success', 'Facility deleted successfully.');
    }
}