<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlider;
use Illuminate\Http\Request;

class CarouselSliderController extends Controller
{
    // Custom GET API by destination ID
    public function getByDestinationId($destination_id)
    {
        $sliders = CarouselSlider::where('destination_id', $destination_id)->get();
        return response()->json($sliders);
    }

    // Show all sliders
    public function index($destination_id)
    { 
        $sliders = CarouselSlider::where('destination_id', $destination_id)->get();
       
        // Check if the destination ID is valid
        return view('carousel_slider.index', compact('sliders','destination_id'));
    }

    // Show create form
    public function create()
    {
        return view('carousel_slider.create');
    }

    // Store new slider
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|integer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('carousel_images', 'public');
            $requestData = $request->all();
            $requestData['image'] = $imagePath;
    
            CarouselSlider::create($requestData);
        }
    
        return redirect()->back()->with('message', 'Slider created successfully.');
    }
    

    // Show a single slider
    public function show($id)
    {
        $slider = CarouselSlider::findOrFail($id);
        return view('carousel_slider.show', compact('slider'));
    }

    // Show edit form
    public function edit($id)
    {
        $slider = CarouselSlider::findOrFail($id);
        return view('carousel_slider.edit', compact('slider'));
    }

    // Update slider
    public function update(Request $request, $id)
    {
        $slider = CarouselSlider::findOrFail($id);
    
        $request->validate([
            'destination_id' => 'required|integer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = $request->all();
    
        // Handle image upload if a new one is provided
        if ($request->hasFile('image')) {
            // Delete old image from storage
            if ($slider->image && \Storage::disk('public')->exists($slider->image)) {
                \Storage::disk('public')->delete($slider->image);
            }
    
            // Store new image
            $data['image'] = $request->file('image')->store('carousel_images', 'public');
        }
    
        $slider->update($data);
    
          return redirect()->back()->with('message', 'Slider updated successfully.');
    }
    

    // Delete slider
    public function destroy($id)
    {
        CarouselSlider::destroy($id);
        return redirect()->back()->with('message', 'Slider deleted successfully.');
    }
}

