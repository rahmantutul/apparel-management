@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Policy</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('attendance-policies.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Company:</strong>
                {{ $attendancePolicy->company->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Work Start Time:</strong>
                {{ $attendancePolicy->work_start_time }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Work End Time:</strong>
                {{ $attendancePolicy->work_end_time }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Late Tolerance (Minutes):</strong>
                {{ $attendancePolicy->late_tolerance_minutes }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Half Day Threshold (Minutes):</strong>
                {{ $attendancePolicy->half_day_threshold_minutes }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Absent Threshold (Minutes):</strong>
                {{ $attendancePolicy->absent_threshold_minutes }}
            </div>
        </div>
    </div>
@endsection
