@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-header m-0">
             Shifts
            <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left">
                <i class="entypo-plus"></i> Add Shift
            </a>
        </h2>
    </div>

    <table class="table table-bordered datatable table-responsive" id="employee_shifts_table">
        <thead>
            <tr>
                <th>Shift Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Punch Start</th>
                <th>Punch End</th>
                <th>Entry Close</th>
                <th>Exit Start</th>
                <th>Late Minutes</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employeeShifts as $shift)
                <tr>
                    <td>{{ $shift->shift_name }}</td>
                    <td>{{ $shift->shift_start_time }}</td>
                    <td>{{ $shift->shift_end_time }}</td>
                    <td>{{ $shift->punch_start_time }}</td>
                    <td>{{ $shift->punch_end_time }}</td>
                    <td>{{ $shift->entry_time_close }}</td>
                    <td>{{ $shift->exit_time_start }}</td>
                    <td>{{ $shift->late_consideration_minutes }}</td>
                    <td>{{ $shift->shift_active_status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-shift-btn" data-id="{{ $shift->id }}">
                            <i class="entypo-pencil"></i> Edit
                        </button>
                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left deleteBtn" data-id="{{ $shift->id }}">
                            <i class="entypo-cancel"></i> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Shift Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Punch Start</th>
                <th>Punch End</th>
                <th>Entry Close</th>
                <th>Exit Start</th>
                <th>Late Minutes</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>

    <!-- Shift Modal -->
    <div class="modal fade" id="shift-modal">
        <div class="modal-dialog modal-lg">
            <form id="shiftForm">
                @csrf
                <input type="hidden" id="shift_id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Add New Shift</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shift_name" id="shift_name" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Shift Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="shift_start_time" id="shift_start_time" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Shift End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="shift_end_time" id="shift_end_time" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Punch Start Time</label>
                                    <input type="time" name="punch_start_time" id="punch_start_time" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Punch End Time</label>
                                    <input type="time" name="punch_end_time" id="punch_end_time" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Entry Time Close</label>
                                    <input type="time" name="entry_time_close" id="entry_time_close" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Exit Time Start</label>
                                    <input type="time" name="exit_time_start" id="exit_time_start" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Late Consideration (Minutes)</label>
                                    <input type="number" name="late_consideration_minutes" id="late_consideration_minutes" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Active Status</label>
                                    <select name="shift_active_status" id="shift_active_status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-shift-btn">Save Shift</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function showAjaxModal() {
            $('#shift_id').val('');
            $('#shiftForm')[0].reset();
            $('#modal-title').text('Add New Shift');
            $('#shift-modal').modal('show', {backdrop: 'static'});
        }
    </script>
    <script>
        const deleteRoute = "{{ route('employee-shifts.destroy', ':id') }}";
        $(document).on('click', '.deleteBtn', function (e) {
            e.preventDefault();
            let shiftId = $(this).data('id');
            let url = deleteRoute.replace(':id', shiftId);

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message || 'Failed to delete shift.');
                            }
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message || 'Something went wrong!');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var $table = $('#employee_shifts_table');
            
            $table.DataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bStateSave": true
            });
            
            $table.closest('.dataTables_wrapper').find('select').select2({
                minimumResultsForSearch: -1
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Open modal for editing shift
            $(document).on('click', '.edit-shift-btn', function() {
                var shiftId = $(this).data('id');
                
                $.get('/employee-shifts/' + shiftId + '/edit', function(data) {
                    $('#shift_id').val(data.id);
                    $('#shift_name').val(data.shift_name);
                    $('#shift_start_time').val(data.shift_start_time);
                    $('#shift_end_time').val(data.shift_end_time);
                    $('#punch_start_time').val(data.punch_start_time);
                    $('#punch_end_time').val(data.punch_end_time);
                    $('#entry_time_close').val(data.entry_time_close);
                    $('#exit_time_start').val(data.exit_time_start);
                    $('#late_consideration_minutes').val(data.late_consideration_minutes);
                    $('#shift_active_status').val(data.shift_active_status);
                    $('#modal-title').text('Edit Shift: ' + data.shift_name);
                    $('#shift-modal').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load shift data: ' + xhr.responseJSON.message,
                        timer: 3000
                    });
                });
            });
            
            // Handle form submission
            $('#shiftForm').submit(function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();
                var url = $('#shift_id').val() ? '/employee-shifts/' + $('#shift_id').val() : '/employee-shifts';
                var method = $('#shift_id').val() ? 'PUT' : 'POST';
                
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        $('#shift-modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Operation completed successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'An error occurred',
                            timer: 3000
                        });
                    }
                });
            });
        });
    </script>
@endpush