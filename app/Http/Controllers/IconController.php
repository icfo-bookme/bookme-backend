<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $icons = Icon::latest()->get();
        return view('icons.show', compact('icons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('icons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon_name' => 'required|string|max:255',
            'icon_import' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('icons', 'public');
            $validated['image'] = $imagePath;
        }

        Icon::create($validated);

        return redirect()->route('icons.index')
            ->with('success', 'Icon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Icon $icon)
    {
        return view('icons.show', compact('icon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Icon $icon)
    {
        return view('icons.edit', compact('icon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Icon $icon)
    {
        $validated = $request->validate([
            'icon_name' => 'required|string|max:255',
            'icon_import' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($icon->image && Storage::disk('public')->exists($icon->image)) {
                Storage::disk('public')->delete($icon->image);
            }
            
            $imagePath = $request->file('image')->store('icons', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep the existing image if no new image is uploaded
            unset($validated['image']);
        }

        $icon->update($validated);

        return redirect()->route('icons.index')
            ->with('success', 'Icon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Icon $icon)
    {
        // Delete the associated image file
        if ($icon->image && Storage::disk('public')->exists($icon->image)) {
            Storage::disk('public')->delete($icon->image);
        }

        $icon->delete();

        return redirect()->route('icons.index')
            ->with('success', 'Icon deleted successfully.');
    }
}