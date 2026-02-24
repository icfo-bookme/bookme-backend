<?php

namespace App\Http\Controllers;

use App\Models\CarPrice;
use Illuminate\Http\Request;

class CarPriceController extends Controller
{
    // Display all car prices
    public function index($id)
    {
        $carPrices = CarPrice::where('property_id', $id)->get();
        return view('CarRental.car_prices.index', compact('carPrices', 'id'));
    }

    // Show create form
    public function create()
    {
        return view('CarRental.car_prices.create');
    }

    // Store new car price
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer',
            'price_upto_4_hours' => 'required|numeric',
            'price_upto_6_hours' => 'required|numeric',
            'kilometer_price' => 'required|numeric',
        ]);

        CarPrice::create($request->all());

        return redirect()->back()->with('success', 'Car price created successfully.');
    }

    

    // Update car price
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required|integer',
            'price_upto_4_hours' => 'required|numeric',
            'price_upto_6_hours' => 'required|numeric',
            'kilometer_price' => 'required|numeric',
        ]);

        $carPrice = CarPrice::findOrFail($id);
        $carPrice->update($request->all());

        return redirect()->back()->with('success', 'Car price updated successfully.');
    }

    // Delete car price
    public function destroy($id)
    {
        CarPrice::destroy($id);
        return redirect()->back()->with('success', 'Car price deleted.');
    }
}

