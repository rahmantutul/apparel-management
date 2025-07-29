@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Attendance Policies</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('attendance-policies.create') }}"> Create New Policy</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Company</th>
            <th>Work Start Time</th>
            <th>Work End Time</th>
            <th>Late Tolerance (Mins)</th>
            <th>Half Day Threshold (Mins)</th>
            <th>Absent Threshold (Mins)</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($policies as $policy)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $policy->company->name }}</td>
            <td>{{ $policy->work_start_time }}</td>
            <td>{{ $policy->work_end_time }}</td>
            <td>{{ $policy->late_tolerance_minutes }}</td>
            <td>{{ $policy->half_day_threshold_minutes }}</td>
            <td>{{ $policy->absent_threshold_minutes }}</td>
            <td>
                <form action="{{ route('attendance-policies.destroy',$policy->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('attendance-policies.show',$policy->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('attendance-policies.edit',$policy->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
