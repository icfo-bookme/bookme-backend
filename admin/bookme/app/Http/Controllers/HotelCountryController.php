<?php

namespace App\Http\Controllers;

use App\Models\HotelCountry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HotelCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = HotelCountry::orderBy('name')->get();
        return view('hotel.country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotel.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:hotel_countries,name',
        ]);

        HotelCountry::create($request->only('name'));

        return redirect()->route('hotel.countries.index')
            ->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hotelCountry = HotelCountry::findOrFail($id);
        return view('hotel.countries.show', compact('hotelCountry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hotelCountry = HotelCountry::findOrFail($id);
        return view('hotel.countries.edit', compact('hotelCountry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hotelCountry = HotelCountry::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('hotel_countries', 'name')->ignore($hotelCountry->id),
            ],
        ]);

        $hotelCountry->update([
            'name' => $request->name,
        ]);

        return redirect()->route('hotel.countries.index')
            ->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hotelCountry = HotelCountry::findOrFail($id);

        // Check if country has any hotels before deleting
        if ($hotelCountry->hotels()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete country with associated hotels');
        }

        $hotelCountry->delete();

        return redirect()->route('hotel.countries.index')
            ->with('success', 'Country deleted successfully');
    }
}
