<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\ServiceCategory ;
use App\Models\Destination ;
use App\Models\CarBrand;
use App\Models\BrandProperty ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all(); // Retrieve all properties
        
        $categories = ServiceCategory::all();
        $destinations = Destination::all();
        return view('properties.index', compact('properties', 'categories', 'destinations')); // Load view
    }

    public function spotwiseProperty($category, $spot_id)
    { 
        $category_id = ServiceCategory::whereRaw('LOWER(category_name) = ?', [strtolower($category)])->firstOrFail()->category_id;
        $properties = Property::where('destination_id', $spot_id)->where('category_id',$category_id)->get();  
       
        $images = null;
   
        $destinations = Destination::all();
        $brands = CarBrand::all();
     if($category=='visa'){
            return view('visa.properties.index', compact('properties', 'category_id', 'destinations', 'spot_id'));
        };
         if($category=='hotel'){
            return view('hotel.properties.index', compact('properties', 'category_id', 'destinations', 'spot_id'));
        };
        
          if($category=='tour packages'){
            return view('tourpackages.properties.index', compact('properties', 'category_id', 'destinations', 'spot_id'));
        };
        
             if($category=='activities'){
            return view('activities.properties.index', compact('properties', 'category_id', 'destinations', 'spot_id'));
        };
        
         if($category=='car rental'){
            return view('CarRental.properties.index', compact('properties', 'category_id', 'destinations', 'spot_id','brands'));
        };
        // Return the properties view with the appropriate data
        return view('properties.index', compact('properties', 'category_id', 'destinations', 'spot_id','images'));
    }
    
    public function create(){
        $properties = Property::all();
        return response()->json([
            'success'=>true,
            'message' => "",
            'data'=> $properties
        ]);
    }
    public function store(Request $request)
    {   
        try {
          $data=  $request->validate([
                'category_id' => 'required|integer',
                'destination_id' => 'required|integer',
                'popularity' => 'nullable|integer',
                'property_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'city_district' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'lat_long' => 'nullable|string|max:255', 
                'main_img' => 'required|image|mimes:jpg,png,jpeg,webp,avif|max:2048',
                'isactive' => 'required|boolean',
                'discout' => 'nullable|string',
                'price' => 'nullable|integer',
                'meta_description' => 'nullable',
                'kewords' => 'nullable',
                'specialkeywords' => 'nullable',
            ]);

        }  catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); 
        }
        // Store the uploaded image
        $filePath = $request->file('main_img')->store('properties', 'public');

        // Create a new property entry
      $property =   Property::create([
            'category_id' => $request->category_id,
            'destination_id' => $request->destination_id,
            'added_by' => Auth::id(),
            'property_name' => $request->property_name,
            'description' => $request->description,
            'district_city' => $request->{'city_district'},
            'address' => $request->address,
            'lat_long' => $request->{'lat_long'},
            'main_img' => $filePath,
            'isactive' => $request->isactive,
            'popularity' =>  $request->popularity,
            'discout' =>  $request->discout,
             'price' =>  $request->price ?? 0,
            'meta_description' => $request->meta_description,
            'kewords' => $request->kewords,
            'specialkeywords' => $request->specialkeywords,
           
        ]);
        if ($request->brand_id) {
    BrandProperty::create([
        'property_id' => $property->property_id,
        'brand_id' => $request->brand_id,
        'model_id' => $request->model_id,
    ]);
}

        session()->flash('success', 'Property added successfully!');
        // Redirect to properties index with success message
        return redirect()->back();

    }

   
    public function update(Request $request, $id)
    {
        
        $property = Property::findOrFail($id);
        
        // Validate incoming request data
        $validated = $request->validate([
            'destination_id' => 'nullable|integer',
            'property_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city_district' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'lat_long' => 'nullable|string|max:255',
            'isactive' => 'nullable|boolean',
            'popularity' => 'nullable|integer',
            'main_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'discout' => 'nullable',
            'price' => 'nullable|integer',
            'meta_description' => 'nullable|string',
             'kewords' => 'nullable|string',
            'specialkeywords' => 'nullable|string',
        ]);
    
        // Handle the popularity field, ensuring it gets stored as 1 or 0
        // $popularity = $request->has('popularity') ? $request->popularity : 0;
    
        // Handle file upload for main_img
        if ($request->hasFile('main_img')) {
            // Delete the old image if it exists
            if ($property->main_img && Storage::disk('public')->exists($property->main_img)) {
                Storage::disk('public')->delete($property->main_img);
            }
    
            // Store the new image
            $imagePath = $request->file('main_img')->store('properties', 'public');
            $property->main_img = $imagePath; // Update the image path in the database
        }
    
        // Update other fields
        $property->destination_id = $validated['destination_id'] ?? null;
        $property->property_name = $validated['property_name'];
        $property->description = $validated['description'] ?? null;
        $property->district_city = $validated['city_district'] ?? null;
        $property->address = $validated['address'] ?? null;
        $property->lat_long = $validated['lat_long'] ?? null;
        $property->isactive = $request->boolean('isactive');
        $property->discout = $validated['discout'] ?? null;
        $property->price = $validated['price'] ?? 0;
        $property->popularity = $validated['popularity'] ?? null; 
        $property->meta_description = $validated['meta_description'] ?? null; 
        $property->kewords = $validated['kewords'] ?? null; 
        $property->specialkeywords = $validated['specialkeywords'] ?? null; 
        $property->save();
    
        return redirect()->back()
                         ->with('success', 'Property updated successfully!');
    }
    
    

    public function destroy(Property $property)
    {
        // Delete the property and its associated image
        if ($property->main_img) {
            Storage::delete($property->main_img);
        }

        $property->delete();

        // Redirect to properties index with success message
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully!');
    }
}
