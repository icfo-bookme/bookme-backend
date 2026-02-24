<?php

namespace App\Http\Controllers;

use App\Models\PropertySummaryType;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class PropertySummaryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = PropertySummaryType::all();
        $serviceCategories = ServiceCategory::all();
        return view('property_summary_type.index', compact('types','serviceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('property_summary_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|integer',
        ]);

        PropertySummaryType::create($validated);

        return redirect()->route('property-summary-types.index')
                         ->with('success', 'Property Summary Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertySummaryType $propertySummaryType)
    {
        return view('property_summary_type.show', compact('propertySummaryType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertySummaryType $propertySummaryType)
    {
        return view('property_summary_type.edit', compact('propertySummaryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertySummaryType $propertySummaryType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|integer',
        ]);

        $propertySummaryType->update($validated);

        return redirect()->route('property-summary-types.index')
                         ->with('success', 'Property Summary Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertySummaryType $propertySummaryType)
    {
        $propertySummaryType->delete();

        return redirect()->route('property-summary-types.index')
                         ->with('success', 'Property Summary Type deleted successfully.');
    }
}
