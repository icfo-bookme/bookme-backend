<?php

namespace App\Http\Controllers;

use App\Models\HomepageSectionSetting;
use App\Models\Spot;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;

class HomepageSectionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $settings = HomepageSectionSetting::orderBy('order')->get();
    $categories = ServiceCategory::all();
    $subcategoryforid1 = Spot::all(); // Assuming Spot is your model for category ID 1 subcategories
    
    return view('HomepageSectionSetting.index', compact('settings', 'categories', 'subcategoryforid1'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('HomepageSectionSetting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'heading' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'limit' => 'required|integer|min:1',
            'order' => 'required|integer|min:0',
            'active' => 'required',
        ]);

        HomepageSectionSetting::create($validated);

        return redirect()->back()
            ->with('success', 'Homepage section setting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomepageSectionSetting $homepageSectionSetting)
    {
        return view('homepage-section-settings.show', compact('homepageSectionSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomepageSectionSetting $homepageSectionSetting)
    {
        return view('homepage-section-settings.edit', compact('homepageSectionSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomepageSectionSetting $homepageSectionSetting)
    {
        $validated = $request->validate([
            'heading' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'limit' => 'required|integer|min:1',
            'order' => 'required|integer|min:0',
            'active' => 'required|in:yes,no',
        ]);

        $homepageSectionSetting->update($validated);

        return redirect()->back()
            ->with('success', 'Homepage section setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomepageSectionSetting $homepageSectionSetting)
    {
        $homepageSectionSetting->delete();

        return redirect()->route('homepage-section-settings.index')
            ->with('success', 'Homepage section setting deleted successfully');
    }
}