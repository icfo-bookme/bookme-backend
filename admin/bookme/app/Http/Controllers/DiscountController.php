<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
   // Show the form for creating a new discount
    public function create()
    {
        return view('discount.create');
    }
    // Store a newly created discount in the database
    public function store(Request $request)
    { 
        $request->validate([
            'unit_id' => 'required|exists:property_unit,unit_id',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'effectfrom' => 'required|date',
            'effective_till' => 'nullable|date',
        ]);

        Discount::create($request->all());

        return redirect()->back();
    }
    // Show a specific discount
    public function show(Discount $discount)
    {
        return view('discount.show', compact('discount'));
    }
    // Show the form for editing a discount
    public function edit(Discount $discount)
    {
        return view('discount.edit', compact('discount'));
    }
    // Update an existing discount in the database
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'unit_id' => 'required|exists:property_unit,unit_id',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'effectfrom' => 'required|date',
            'effective_till' => 'nullable|date',
        ]);

        $discount->update($request->all());

        return redirect()->route('discount.index')->with('success', 'Discount updated successfully!');
    }

    // Delete a discount
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discount.index')->with('success', 'Discount deleted successfully!');
    }
}
