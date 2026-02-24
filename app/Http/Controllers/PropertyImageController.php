<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'property_id' => 'required|integer',
            'path' => 'required|array',
            'path.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp |max:2048', 
            'caption.*' => 'string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('path')) {
            foreach ($request->file('path') as $index => $file) {
                $imagePath = $file->store('images', 'public');
                
                // Store each image data in the database
                PropertyImage::create([
                    'property_id' => $request->property_id,
                    'path' => $imagePath,  // Store the file path in the database
                    
                ]);
            }
        }

        // Redirect or return response
        return redirect()->back()->with('success', 'Property images added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($propertyId)
    { 
        $property = Property::where('property_id', $propertyId)->firstOrFail();
        $propertyImages = PropertyImage::where('property_id', $propertyId)->get();
    $category_id = $property->category_id;
        return view('property_images.show', compact('propertyImages', 'propertyId', 'property', 'category_id'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($image_id)
    {
        
        $propertyImage = PropertyImage::findOrFail($image_id);

        if ($propertyImage->path && file_exists(storage_path('app/public/' . $propertyImage->path))) {
            unlink(storage_path('app/public/' . $propertyImage->path));  // Delete the image file
        }

        $propertyImage->delete();

        return redirect()->back()->with('success', 'Property image deleted successfully.');
    }
}
