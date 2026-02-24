<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\FeatureCategory;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::where('type','hotel')->get();
        $categories = FeatureCategory::where('type','hotel')->get();
        return view('hotel.features.index', compact('features','categories'));
    }
    
     public function roomIndex()
    {
        $features = Feature::where('type','room')->get();
        $categories = FeatureCategory::where('type','room')->get();
        return view('hotel.room.features.index', compact('features','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'isactive' => 'sometimes|boolean'
        ]);

        Feature::create($validated);

        return redirect()->back()
            ->with('success', 'Feature created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'isactive' => 'boolean',
            'type' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $feature = Feature::findOrFail($id);
        $feature->update($validated);

        return redirect()->back()
            ->with('success', 'Feature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        $feature->delete();

        return redirect()->back()
            ->with('success', 'Feature deleted successfully.');
    }
}