@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Employee List
            <a href="{{ route('employees.create') }}"class="btn btn-primary btn-icon icon-left">
                <i class="fas fa-list"></i> Create Employee
            </a>
        </h2>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
               @if(session('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><i class="fa fa-check-circle"></i> Success!</strong> 
                        {{ session('success') }}
                        @if(session('employee_id'))
                            <a href="{{ route('employees.show', session('employee_id')) }}" class="btn btn-default btn-xs">
                                <i class="fa fa-user"></i> View Employee
                            </a>
                        @endif
                    </div>
                @endif
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Employee</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Join Date</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr id="employee-{{ $employee->id }}">
                            <td>{{ $employee->id }}</td>
                            <td style="width: 20%">
                                <div class="media">
                                    @if($employee->emp_image)
                                        <div class="media-left">
                                            <img src="{{ asset('storage/'.$employee->emp_image) }}" 
                                                class="media-object img-circle" width="40" height="40" alt="Employee Image">
                                        </div>
                                    @else
                                        <div class="media-left">
                                            <div class="avatar-placeholder img-circle" 
                                                style="width:40px;height:40px;background:#eee;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="media-body">
                                        <strong>{{ $employee->emp_name }}</strong>
                                        <div class="text-muted small">{{ $employee->emp_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->designation->name ?? '-' }}</td>
                            <td>{{ $employee->department->name ?? '-' }}</td>
                            <td>
                                {{ $employee->emp_contact_number }}<br>
                                <small class="text-muted">{{ $employee->emp_emergency_contact }}</small>
                            </td>
                            <td>
                                <span class="badge badge-{{ $employee->emp_status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($employee->emp_status) }}
                                </span>
                                @if($employee->emp_is_resigned)
                                <div class="small text-muted">Resigned: {{ $employee->emp_resignation_date?->format('d M Y') }}</div>
                                @endif
                            </td>
                            <td>{{ $employee->emp_joining_date ? \Carbon\Carbon::parse($employee->emp_joining_date)->format('d M Y') : '-' }}</td>
                            <td>{{ number_format($employee->emp_starting_salary, 2) }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-default btn-sm btn-icon icon-left" data-id="{{ $employee->id }}">
                                    <i class="entypo-pencil"></i> Edit
                                </a>

                                <a href="#" class="btn btn-danger btn-sm btn-icon icon-left delete-btn"  data-id="{{ $employee->id }}">
                                    <i class="entypo-cancel"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        const employeeId = $(this).data('id');
        const deleteUrl = `{{ route('employees.destroy', ':id') }}`.replace(':id', employeeId);
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#employee-' + employeeId).fadeOut(300, function() {
                                $(this).remove();
                            });
                            Swal.fire(
                                'Deleted!',
                                'Employee has been deleted.',
                                'success'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endpush