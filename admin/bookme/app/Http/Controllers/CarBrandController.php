<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function index()
    {
        $carBrands = CarBrand::all();
        return view('CarRental.car_brands.index', compact('carBrands'));
    }

    public function create()
    {
        return view('car_brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:car_brand,name|max:100',
        ]);

        CarBrand::create($request->only('name'));

        return redirect()->back()->with('success', 'Car brand created successfully.');
    }

    public function edit(CarBrand $carBrand)
    {
        return view('car_brands.edit', compact('carBrand'));
    }

    public function update(Request $request, CarBrand $carBrand)
    {
        $request->validate([
            'name' => 'required|max:100|unique:car_brand,name,' . $carBrand->id,
        ]);

        $carBrand->update($request->only('name'));

        return redirect()->back()->with('success', 'Car brand updated successfully.');
    }

    public function destroy(CarBrand $carBrand)
    {
        $carBrand->delete();

        return redirect()->back()->with('success', 'Car brand deleted successfully.');
    }
}

