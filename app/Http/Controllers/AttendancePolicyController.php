<?php

namespace App\Http\Controllers;

use App\Models\AttendancePolicy;
use Illuminate\Http\Request;

class AttendancePolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policies = AttendancePolicy::all();
        return view('admin.attendance-policy.index', compact('policies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attendance-policy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'work_start_time' => 'required',
            'work_end_time' => 'required',
            'late_tolerance_minutes' => 'required|integer',
            'half_day_threshold_minutes' => 'required|integer',
            'absent_threshold_minutes' => 'required|integer',
        ]);

        AttendancePolicy::create($request->all());

        return redirect()->route('attendance-policies.index')
            ->with('success', 'Attendance Policy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendancePolicy $attendancePolicy)
    {
        return view('admin.attendance-policy.show', compact('attendancePolicy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendancePolicy $attendancePolicy)
    {
        return view('admin.attendance-policy.edit', compact('attendancePolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendancePolicy $attendancePolicy)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'work_start_time' => 'required',
            'work_end_time' => 'required',
            'late_tolerance_minutes' => 'required|integer',
            'half_day_threshold_minutes' => 'required|integer',
            'absent_threshold_minutes' => 'required|integer',
        ]);

        $attendancePolicy->update($request->all());

        return redirect()->route('attendance-policies.index')
            ->with('success', 'Attendance Policy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendancePolicy $attendancePolicy)
    {
        $attendancePolicy->delete();

        return redirect()->route('attendance-policies.index')
            ->with('success', 'Attendance Policy deleted successfully.');
    }
}
