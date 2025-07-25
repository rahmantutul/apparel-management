<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_attendance_logs', ['only' => ['index', 'show']]);
        $this->middleware('permission:create_attendance_logs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_attendance_logs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_attendance_logs', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('attendance_logs.index');
    }
}
