<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Traits\Loggable;
class ShiftController extends Controller
{
     use Loggable;
    public function index()
    {
        $employeeShifts = Shift::all();
        return view('admin.shifts', compact('employeeShifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shift_name' => 'required|unique:shifts',
            'shift_start_time' => 'required',
            'shift_end_time' => 'required',
            'punch_start_time' => 'nullable',
            'punch_end_time' => 'nullable',
            'entry_time_close' => 'nullable',
            'exit_time_start' => 'nullable',
            'late_consideration_minutes' => 'nullable|integer',
            'shift_active_status' => 'nullable|boolean'
        ]);
        
        Shift::create($request->all());
        
        return response()->json(['message' => 'Shift created successfully']);
    }

    public function edit(Shift $employeeShift)
    {
        return response()->json($employeeShift);
    }

    public function update(Request $request, Shift $employeeShift)
    {
        $request->validate([
            'shift_name' => 'required|unique:shifts,shift_name,'.$employeeShift->id,
            'shift_start_time' => 'required',
            'shift_end_time' => 'required',
            'punch_start_time' => 'nullable',
            'punch_end_time' => 'nullable',
            'entry_time_close' => 'nullable',
            'exit_time_start' => 'nullable',
            'late_consideration_minutes' => 'nullable|integer',
            'shift_active_status' => 'nullable|boolean'
        ]);
        
        $employeeShift->update($request->all());
        
        return response()->json(['message' => 'Shift updated successfully']);
    }

    public function destroy(Shift $employeeShift)
    {
        $employeeShift->delete();
        return response()->json([
            'success' => true,
            'message' => 'Shift deleted successfully'
        ]);
    }
}