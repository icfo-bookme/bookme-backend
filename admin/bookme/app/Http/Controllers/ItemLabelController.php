<?php

namespace App\Http\Controllers;

use App\Models\ItemLabel;
use Illuminate\Http\Request;

class ItemLabelController extends Controller
{
    public function index()
    {
        $itemLabels = ItemLabel::all(); // Fetch all labels
        return view('item_labels.index', compact('itemLabels')); // Return to Blade view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:item_labels,name|max:100',
        ]);

        ItemLabel::create($request->only('name'));

        return redirect()->route('item-labels.index')->with('success', 'Label added successfully.');
    }

    public function update(Request $request, ItemLabel $itemLabel)
    {
        $request->validate([
            'name' => 'required|max:100|unique:item_labels,name,' . $itemLabel->id,
        ]);

        $itemLabel->update($request->only('name'));

        return redirect()->route('item-labels.index')->with('success', 'Label updated successfully.');
    }

    public function destroy(ItemLabel $itemLabel)
    {
        $itemLabel->delete();

        return redirect()->route('item-labels.index')->with('success', 'Label deleted successfully.');
    }
}
