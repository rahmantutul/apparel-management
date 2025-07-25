<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function index()
    {
        return view('attendance_logs.index');
    }
}
