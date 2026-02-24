<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the room types.
     */
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('hotel.room.room-types.index', compact('roomTypes'));
    }

    /**
     * Store a newly created room type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name',
        ]);

        RoomType::create($validated);

        return redirect()->back()->with('success', 'Room type created successfully.');
    }

    /**
     * Update the specified room type in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name,' . $roomType->id,
        ]);

        $roomType->update($validated);

        return redirect()->back()->with('success', 'Room type updated successfully.');
    }

    /**
     * Remove the specified room type from storage.
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->back()->with('success', 'Room type deleted successfully.');
    }

    /**
     * Toggle the active status of the room type.
     */
    public function toggleStatus(RoomType $roomType)
    {
        $roomType->update(['isActive' => !$roomType->isActive]);
        return redirect()->back()->with('success', 'Room type status updated successfully.');
    }
}
