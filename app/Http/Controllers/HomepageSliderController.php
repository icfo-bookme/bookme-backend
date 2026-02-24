<?php

namespace App\Http\Controllers;

use App\Models\HomepageSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomepageSliderController extends Controller
{
    // Show all sliders
    public function index()
    {
        $sliders = HomepageSlider::all();
        return view('Homepage.index', compact('sliders'));
    }

    // Show create form
    public function create()
    {
        return view('homepage_sliders.create');
    }

    // Store new slider
    public function store(Request $request)
    { 
    
    try {
      
        
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
           'discounts' => 'nullable|integer|max:255',
        ]);

       

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }

        // Store image in public/Homepage/slider
        $imagePath = $request->file('image')->move('Homepage/slider', time().'_'.$request->file('image')->getClientOriginalName());

        HomepageSlider::create([
            'image' => $imagePath,
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'btn_link' => $validated['btn_link'],
            'discounts' => $validated['discounts'],
        ]);

        return redirect()->back()->with('success', 'Slider created successfully.');
    }

    // Show one slider
    public function show($id)
    {
        $slider = HomepageSlider::findOrFail($id);
        return view('homepage_sliders.show', compact('slider'));
    }

    // Show edit form
    public function edit($id)
    {
        $slider = HomepageSlider::findOrFail($id);
        return view('homepage_sliders.edit', compact('slider'));
    }

    // Update existing slider
    public function update(Request $request, $id)
    {
        $slider = HomepageSlider::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
            'discounts' => 'nullable|integer|max:255',

        ]);

        // Handle optional image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            // Upload new image
            $imagePath = $request->file('image')->move('Homepage/slider', time().'_'.$request->file('image')->getClientOriginalName());
            $slider->image = $imagePath;
        }

        $slider->title = $validated['title'];
        $slider->subtitle = $validated['subtitle'];
        $slider->btn_link = $validated['btn_link'];
        $slider->discounts = $validated['discounts'];
        $slider->save();

        return redirect()->back()->with('success', 'Slider updated successfully.');
    }

    // Delete a slider
    public function destroy($id)
    {
        $slider = HomepageSlider::findOrFail($id);

        // Delete image from public directory
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->delete();

        return redirect()->back()->with('success', 'Slider deleted successfully.');
    }
}
