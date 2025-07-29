@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Policy</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('attendance-policies.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('attendance-policies.update',$attendancePolicy->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Company:</strong>
                    <select name="company_id" class="form-control">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ $company->id == $attendancePolicy->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Work Start Time:</strong>
                    <input type="time" name="work_start_time" value="{{ $attendancePolicy->work_start_time }}" class="form-control" placeholder="Work Start Time">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Work End Time:</strong>
                    <input type="time" name="work_end_time" value="{{ $attendancePolicy->work_end_time }}" class="form-control" placeholder="Work End Time">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Late Tolerance (Minutes):</strong>
                    <input type="number" name="late_tolerance_minutes" value="{{ $attendancePolicy->late_tolerance_minutes }}" class="form-control" placeholder="Late Tolerance (Minutes)">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Half Day Threshold (Minutes):</strong>
                    <input type="number" name="half_day_threshold_minutes" value="{{ $attendancePolicy->half_day_threshold_minutes }}" class="form-control" placeholder="Half Day Threshold (Minutes)">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Absent Threshold (Minutes):</strong>
                    <input type="number" name="absent_threshold_minutes" value="{{ $attendancePolicy->absent_threshold_minutes }}" class="form-control" placeholder="Absent Threshold (Minutes)">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
