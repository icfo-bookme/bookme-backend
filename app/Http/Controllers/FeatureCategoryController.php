<?php

namespace App\Http\Controllers;

use App\Models\FeatureCategory;
use Illuminate\Http\Request;

class FeatureCategoryController extends Controller
{
    public function index()
    {
        $categories = FeatureCategory::where('type','hotel')->get();
        return view('hotel.feature-categories.index', compact('categories'));
    }

    public function roomCategory()
    {
        $categories = FeatureCategory::where('type','room')->get();
        return view('hotel.room.category', compact('categories'));
    }

    public function create()
    {
        return view('feature-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'isactive' => 'boolean'
        ]);

        FeatureCategory::create($request->all());

        return redirect()->back()
                        ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'isactive' => 'boolean'
        ]);
        
        $featureCategory = FeatureCategory::findOrFail($id);
        $featureCategory->update([
            'name' => $request->name,
            'isactive' => $request->isactive,
        ]);

        return redirect()->back()
                        ->with('success', 'Category updated successfully.');
    }

    public function destroy(FeatureCategory $featureCategory)
    {
        $featureCategory->delete();

        return redirect()->back()
                        ->with('success', 'Category deleted successfully.');
    }
}