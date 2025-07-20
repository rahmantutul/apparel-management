<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index()
    {
        // Fetch saved holidays
        $holidays = Holiday::pluck('holiday_date')->toArray();
        return view('admin.holiday', compact('holidays'));
    }

    public function toggle(Request $request)
    {
        $date = $request->date;

        // If the date exists, remove it; otherwise, add it
        $holiday = Holiday::where('holiday_date', $date)->first();
        if ($holiday) {
            $holiday->delete();
            $status = 'removed';
        } else {
            Holiday::create(['holiday_date' => $date]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
