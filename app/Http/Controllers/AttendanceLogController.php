<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use App\Traits\Loggable;

class AttendanceLogController extends Controller
{
    use Loggable;

    public function __construct()
    {
        $this->middleware('permission:view_attendance_logs', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_attendance_logs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_attendance_logs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_attendance_logs', ['only' => ['destroy']]);
    }

    public function index()
    {
        $attendanceLogs = AttendanceLog::all();
        return view('attendance_logs.index', compact('attendanceLogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sn' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'attendance_time' => 'required|date_format:H:i:s',
            'extra' => 'nullable|string|max:255',
            'punch_type' => 'required|integer|between:1,5',
            'status_1' => 'nullable|string|max:255',
            'status_2' => 'nullable|string|max:255',
        ]);
        
        AttendanceLog::create($request->all());
        
        return response()->json(['message' => 'Attendance Log created successfully']);
    }

    public function edit(AttendanceLog $attendanceLog)
    {
        return response()->json($attendanceLog);
    }

    public function update(Request $request, AttendanceLog $attendanceLog)
    {
        $request->validate([
            'sn' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'attendance_time' => 'required|date_format:H:i:s',
            'extra' => 'nullable|string|max:255',
            'punch_type' => 'required|integer|between:1,5',
            'status_1' => 'nullable|string|max:255',
            'status_2' => 'nullable|string|max:255',
        ]);
        
        $attendanceLog->update($request->all());
        
        return response()->json(['message' => 'Attendance Log updated successfully']);
    }

    public function destroy(AttendanceLog $attendanceLog)
    {
        $attendanceLog->delete();
        return response()->json([
            'success' => true,
            'message' => 'Attendance Log deleted successfully'
        ]);
    }
}
