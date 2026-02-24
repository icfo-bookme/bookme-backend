<?php

namespace App\Http\Controllers;

use App\Models\CountryVisa;
use Illuminate\Http\Request;

class CountryVisaController extends Controller
{
    // List all visas
    public function index()
    {
        $countryVisas  = CountryVisa::all();
        return view('country_visas.index', compact('countryVisas'));
    }

    // Show create form
    public function create()
    {
        return view('country_visas.create');
    }

  // Store new visa
public function store(Request $request)
{ 
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'popularityScore' => 'nullable',
        'description' => 'nullable|string',
        'is_active' => 'nullable|boolean', // Changed to nullable in case it's not required
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max for image
    ]);

    // Prepare data for storage, excluding the image field
    $data = $request->except('image');

    // Handle image upload if a file is provided
    if ($request->hasFile('image')) {
        // Store the image in the 'visa_images' folder in public disk
        $imagePath = $request->file('image')->store('visa_images', 'public');
        $data['image'] = $imagePath; // Add the image path to the data
    }

    // Store the visa data in the database
    try {
        CountryVisa::create($data); // Insert the data into the CountryVisa model
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error occurred while saving the visa: ' . $e->getMessage());
    }

    // Redirect back with a success message
    return redirect()->route('country-visas.index')->with('success', 'Visa created successfully!');
}


    // Show single visa
    public function show(CountryVisa $countryVisa)
    {
        return view('country_visas.show', compact('countryVisa'));
    }

    // Edit visa
    public function edit(CountryVisa $countryVisa)
    {
        return view('country_visas.edit', compact('countryVisa'));
    }

    // Update visa
     public function update(Request $request, CountryVisa $countryVisa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'popularityScore' => 'nullable',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);
    
        $data = $request->except('image');
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($countryVisa->image) {
                // Remove 'public/' prefix if it exists in the stored path
                $oldImagePath = str_replace('public/', '', $countryVisa->image);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            // Store new image
            $imagePath = $request->file('image')->store('visa_images', 'public');
            $data['image'] = $imagePath;
        }
    
        $countryVisa->update($data);
    
        return redirect()->route('country-visas.index')->with('success', 'Visa updated successfully!');
    }

    // Delete visa
    public function destroy(CountryVisa $countryVisa)
    {
        $countryVisa->delete();
        return redirect()->route('country-visas.index')->with('success', 'Visa deleted successfully!');
    }
}
