<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
   public function index($id)
{
    // fetch all schedules for a property, or whatever scope you need
    $schedules = Schedule::where('property_id', $id)
        ->orderBy('depart_date')
        ->get();

    // group by month-year string, e.g. "2025‑09"
    $grouped = $schedules->groupBy(function($schedule) {
        return Carbon::parse($schedule->depart_date)->format('Y‑m');
    });

    // also prepare "display names" for tabs, e.g. "September 2025"
    $tabs = [];
    foreach ($grouped as $monthKey => $items) {
        // monthKey is like "2025‑09"
        $dt = Carbon::createFromFormat('Y‑m', $monthKey);
        $tabs[$monthKey] = $dt->format('F Y'); // "September 2025", etc.
    }

    return view('shipwebsite.schedules.index', [
        'groupedSchedules' => $grouped,
        'tabs' => $tabs,
        'property_id' => $id,
    ]);
}

    /**
     * Show the form for creating new schedules.
     */
    public function create()
    {
        // You'll need to pass available properties from DB
        $properties = \App\Models\Property::all();
        return view('schedules.create', compact('properties'));
    }

    /**
     * Store one or more newly created schedules in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'schedules' => 'required|array|min:1',
            'schedules.*.property_id' => 'required|integer',
            'schedules.*.depart_date' => 'required|date',
            'schedules.*.depart_time' => 'required|date_format:H:i',
            'schedules.*.return_date' => 'required|date',
            'schedules.*.return_time' => 'required|date_format:H:i',
        ]);

        $schedules = $data['schedules'];

        Schedule::insert(array_map(function ($schedule) {
            $schedule['created_at'] = now();
            $schedule['updated_at'] = now();
            return $schedule;
        }, $schedules));

        return redirect()->back()
                         ->with('success', 'Schedules added successfully.');
    }

    /**
     * Display the specified schedule.
     */
    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Schedule $schedule)
    {
        $properties = \App\Models\Property::all();
        return view('schedules.edit', compact('schedule', 'properties'));
    }

    /**
     * Update the specified schedule in storage.
     */
public function update(Request $request)
{ 
    try {
        $validated = $request->validate([
            'depart_date' => 'required|date',
            'depart_time' => 'required',
            'return_date' => 'required|date',
            'return_time' => 'required',
        ]);
           
        $schedule = Schedule::findOrFail($request->id);
 
        $schedule->update($validated);

        return redirect()->back()->with('success', 'Schedule updated successfully.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput();
    }
}


    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->back()
                         ->with('success', 'Schedule deleted successfully.');
    }
}
