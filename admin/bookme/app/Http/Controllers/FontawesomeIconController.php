<?php

namespace App\Http\Controllers;

use App\Models\FontawesomeIcon;
use Illuminate\Http\Request;

class FontawesomeIconController extends Controller
{
    // Display all icons
    public function index()
    {
        $icons = FontawesomeIcon::all();
        return view('icons.index', compact('icons'));
    }

    // Show form to create a new icon
    public function create()
    {
        return view('icons.create');
    }

    // Store new icon
    public function store(Request $request)
    {
        $request->validate([
            'icon_class' => 'required|string|max:100',
        ]);

        FontawesomeIcon::create($request->all());
        return redirect()->route('icons.index')->with('success', 'Icon added.');
    }
public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'icon_class' => 'required|string|max:100',
    ]);

    // Find the icon and update it
    $icon = FontawesomeIcon::findOrFail($id);
    $icon->update([
        'icon_class' => $request->icon_class,
    ]);

    return redirect()->route('icons.index')->with('success', 'Icon updated successfully.');
}

   // Delete an icon
public function destroy($id)
{
    $icon = FontawesomeIcon::findOrFail($id);
    $icon->delete();

    return redirect()->route('icons.index')->with('success', 'Icon deleted successfully.');
}

}

