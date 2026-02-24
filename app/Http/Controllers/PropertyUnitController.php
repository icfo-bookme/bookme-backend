<?php

namespace App\Http\Controllers;

use App\Models\PropertyUnit;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyUnitController extends Controller
{
    /**
     * Display a listing of all property units.
     */
    public function index()
    {
        $units = PropertyUnit::all();
        if ($units->isEmpty()) {
            return response()->json(['message' => 'No property units found.'], 404);
        }

        return response()->json($units);
    }
    /**
     * Store a newly created property unit in storage.
     */
    public function store(Request $request)
    {  
            try {
                
                $validated = $request->validate([
                    'property_id' => 'nullable|integer',
                    'unit_category' => 'nullable|string',
                    'unit_name' => 'nullable|string',
                    'unit_type' => 'nullable|string',
                    'fee_type' => 'nullable|string',
                    'unit_no' => 'nullable|string',
                    'Validity' => 'nullable|string',
                    'Max_Stay' => 'nullable|string',
                    'description' => 'nullable|string',
                    'person_allowed' => 'nullable|integer',
                    'additionalbed' => 'nullable|boolean',
                    'mainimg' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp,avif|max:2048',
                    'isactive' => 'required|boolean',
                ]);
        
            } catch (\Illuminate\Validation\ValidationException $e) {
                
                dd($e->errors());  // This will display the validation error messages
            }
     
        // Handle the image upload if a file is provided
        $imagePath = null;
        if ($request->hasFile('mainimg')) {
            $imagePath = $request->file('mainimg')->store('property_images', 'public');
        }
    
        // Create the property unit
      $data=  propertyUnit::create([
            'property_id' => $validated['property_id'],  
            'unit_category' => $validated['unit_category']?? null,
            'unit_name' => $validated['unit_name'] ?? null,
            'unit_type' => $validated['unit_type'] ?? null,
            'Validity' => $validated['Validity'] ?? null,
            'Max_Stay' => $validated['Max_Stay'] ?? null,
            'description' => $validated['description'] ?? null,
            'unit_no' => $validated['unit_no'] ?? null,
            'person_allowed' => $validated['person_allowed'] ?? null,
            'additionalbed' => $validated['additionalbed'] ?? null,
            'fee_type' => $validated['fee_type'] ?? null,
            'mainimg' => $imagePath,
            'isactive' => $validated['isactive'],
        ]);
       
        // Redirect or return response
        return redirect()->back()
        ->with('success', 'Property unit created successfully');

    }
    
    /**
     * Display the specified property unit.
     */
 
public function show($property_id)
{
   
    $property = Property::with('property_uinit.discount', 'property_uinit.price')->findOrFail($property_id);
     
    return view('property_units.show', compact('property_id', 'property'));
}
public function showvisa($property_id)
{
   
    $property = Property::with('property_uinit.discount', 'property_uinit.price')->findOrFail($property_id);
 
    return view('visa.property_units.show', compact('property_id', 'property'));
}
    /**
     * Display property units by property_id.
     */
    public function showByPropertyId($property_id)
    {
        $units = PropertyUnit::where('property_id', $property_id)->get();
        if ($units->isEmpty()) {
            return response()->json(['message' => 'No units found for this property.'], 404);
        }

        return response()->json($units);
    }

    /**
     * Update the specified property unit in storage.
     */
public function update(Request $request, $id)
{  
    try {
        $validated = $request->validate([
            'property_id' => 'nullable|integer|exists:properties,id',
            'unit_category' => 'nullable|in:room,seat',
            'unit_no' => 'nullable|string|max:50',
            'unit_name' => 'nullable|string|max:100',
            'unit_type' => 'nullable|string|max:50',
            'Validity' => 'nullable|string|max:100',
            'Max_Stay' => 'nullable|string|max:50',
            'fee_type' => 'nullable|string',
            'person_allowed' => 'nullable|integer|min:1',
            'additionalbed' => 'nullable|boolean',
            'mainimg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Updated validation for image
            'isactive' => 'nullable|boolean',
            'description' => 'nullable|string',
            'discount_amount' => 'nullable|numeric',
            'discount_percent' => 'nullable|numeric|between:0,100',
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }

    // Find the unit
    $unit = PropertyUnit::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('mainimg')) {
        // Delete previous image if it exists
        if ($unit->mainimg) {
            $oldImagePath = public_path('storage/' . $unit->mainimg);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Store new image
        $imagePath = $request->file('mainimg')->store('property_images', 'public');
        $validated['mainimg'] = $imagePath;
    } else {
        // Keep the existing image if no new image is uploaded
        unset($validated['mainimg']);
    }

    // Update the unit
    $unit->update($validated);

    // Handle discount update
    if ($request->has('discount_percent') || $request->has('discount_amount')) {
        $discountData = [
            'discount_percent' => $request->discount_percent,
            'discount_amount' => $request->discount_amount,
        ];

        $unit->discount()->updateOrCreate(
            ['unit_id' => $unit->unit_id],
            $discountData
        );
    }

    // Handle price update
    if ($request->has('price')) {
        $price = [
            'price' => $request->price,
        ];

        $unit->price()->updateOrCreate(
            ['unit_id' => $unit->unit_id],
            $price
        );
    }
    if ($request->has('round_trip_price')) {
        $round_trip_price = [
            'round_trip_price' => $request->round_trip_price,
        ];

        $unit->price()->updateOrCreate(
            ['unit_id' => $unit->unit_id],
            $round_trip_price
        );
    }

    return redirect()->back()->with('success', 'Unit updated successfully');
}
    /**
     * Remove the specified property unit from storage.
     */
    public function destroy($id)
    {
        // Find the unit and delete it
        $unit = PropertyUnit::findOrFail($id);
        $unit->delete();

         return redirect()->back()->with('success', 'Property unit updated successfully.');
    }
}
