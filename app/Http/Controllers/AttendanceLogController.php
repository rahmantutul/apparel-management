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
            'emp_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'attendance_time' => 'required|date_format:H:i:s',
            'extra' => 'nullable|string|max:255',
            'punch_type' => 'required|integer|between:1,5',
            'status_1' => 'nullable|string|max:255',
            'status_2' => 'nullable|string|max:255',
        ]);
        
        $attendanceLog = new AttendanceLog();
        $attendanceLog->sn = $request->sn;
        $attendanceLog->emp_id = $request->emp_id;
        $attendanceLog->attendance_date = $request->attendance_date;
        $attendanceLog->attendance_time = $request->attendance_time;
        $attendanceLog->extra = $request->extra;
        $attendanceLog->punch_type = $request->punch_type;
        $attendanceLog->status_1 = $request->status_1;
        $attendanceLog->status_2 = $request->status_2;
        $attendanceLog->save();
        
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
            'emp_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'attendance_time' => 'required|date_format:H:i:s',
            'extra' => 'nullable|string|max:255',
            'punch_type' => 'required|integer|between:1,5',
            'status_1' => 'nullable|string|max:255',
            'status_2' => 'nullable|string|max:255',
        ]);
        
        $attendanceLog->sn = $request->sn;
        $attendanceLog->emp_id = $request->emp_id;
        $attendanceLog->attendance_date = $request->attendance_date;
        $attendanceLog->attendance_time = $request->attendance_time;
        $attendanceLog->extra = $request->extra;
        $attendanceLog->punch_type = $request->punch_type;
        $attendanceLog->status_1 = $request->status_1;
        $attendanceLog->status_2 = $request->status_2;
        $attendanceLog->save();
        
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
