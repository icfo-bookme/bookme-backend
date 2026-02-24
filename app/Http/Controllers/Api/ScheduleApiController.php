<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleApiController extends Controller
{
    public function getUpcomingSchedules($id)
    {
        $today = Carbon::today();

        // Get all schedules where the depart_date is today or in the future
        $schedules = Schedule::whereDate('depart_date', '>=', $today)->where('property_id',$id)
            ->orderBy('depart_date')
            ->get();

        // Group by month name (e.g. "September 2025")
        $grouped = $schedules->groupBy(function ($schedule) {
            return Carbon::parse($schedule->depart_date)->format('F Y');
        });

        // Return as JSON
        return response()->json(
             $grouped
        );
    }
}
