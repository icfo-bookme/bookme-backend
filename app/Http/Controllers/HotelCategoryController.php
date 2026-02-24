<?php

namespace App\Http\Controllers;

use App\Models\HotelCategory;
use Illuminate\Http\Request;

class HotelCategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = HotelCategory::all();
        return view('hotel.category.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        return view('hotel_categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        HotelCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('hotel-categories.index')->with('success', 'Category created successfully.');
    }

    // Show single category (optional)
    public function show(HotelCategory $hotelCategory)
    {
        return view('hotel_categories.show', compact('hotelCategory'));
    }

    // Show edit form
    public function edit(HotelCategory $hotelCategory)
    {
        return view('hotel_categories.edit', compact('hotelCategory'));
    }

    // Update existing category
    public function update(Request $request, HotelCategory $hotelCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $hotelCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('hotel-categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete a category
    public function destroy(HotelCategory $hotelCategory)
    {
        $hotelCategory->delete();
        return redirect()->route('hotel-categories.index')->with('success', 'Category deleted successfully.');
    }
}
