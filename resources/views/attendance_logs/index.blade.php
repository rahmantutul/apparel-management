@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-header m-0">
             Attendance Logs
            <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left">
                <i class="entypo-plus"></i> Add Attendance Log
            </a>
        </h2>
    </div>

    <table class="table table-bordered datatable table-responsive" id="attendance_logs_table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee ID</th>
                <th>Attendance Date</th>
                <th>Attendance Time</th>
                <th>Extra</th>
                <th>Punch Type</th>
                <th>Status 1</th>
                <th>Status 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceLogs as $log)
                <tr>
                    <td>{{ $log->sn }}</td>
                    <td>{{ $log->emp_id }}</td>
                    <td>{{ $log->attendance_date }}</td>
                    <td>{{ $log->attendance_time }}</td>
                    <td>{{ $log->extra }}</td>
                    <td>{{ $log->punch_type }}</td>
                    <td>{{ $log->status_1 }}</td>
                    <td>{{ $log->status_2 }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-log-btn" data-id="{{ $log->id }}">
                            <i class="entypo-pencil"></i> Edit
                        </button>
                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left deleteBtn" data-id="{{ $log->id }}">
                            <i class="entypo-cancel"></i> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>SN</th>
                <th>Employee ID</th>
                <th>Attendance Date</th>
                <th>Attendance Time</th>
                <th>Extra</th>
                <th>Punch Type</th>
                <th>Status 1</th>
                <th>Status 2</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>

    <!-- Attendance Log Modal -->
    <div class="modal fade" id="attendance-log-modal">
        <div class="modal-dialog modal-lg">
            <form id="attendanceLogForm">
                @csrf
                <input type="hidden" id="log_id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Add New Attendance Log</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SN <span class="text-danger">*</span></label>
                                    <input type="text" name="sn" id="sn" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>User ID <span class="text-danger">*</span></label>
                                    <input type="number" name="user_id" id="user_id" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Attendance Date <span class="text-danger">*</span></label>
                                    <input type="date" name="attendance_date" id="attendance_date" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Attendance Time <span class="text-danger">*</span></label>
                                    <input type="time" name="attendance_time" id="attendance_time" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Extra</label>
                                    <input type="text" name="extra" id="extra" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Punch Type <span class="text-danger">*</span></label>
                                    <select name="punch_type" id="punch_type" class="form-control" required>
                                        <option value="1">RFID</option>
                                        <option value="2">Password</option>
                                        <option value="3">Face</option>
                                        <option value="4">Fingerprint</option>
                                        <option value="5">Manual</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Status 1</label>
                                    <input type="text" name="status_1" id="status_1" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Status 2</label>
                                    <input type="text" name="status_2" id="status_2" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-log-btn">Save Attendance Log</button>
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
            $('#log_id').val('');
            $('#attendanceLogForm')[0].reset();
            $('#modal-title').text('Add New Attendance Log');
            $('#attendance-log-modal').modal('show', {backdrop: 'static'});
        }
    </script>
    <script>
        const deleteRoute = "{{ route('attendance-logs.destroy', ':id') }}";
        $(document).on('click', '.deleteBtn', function (e) {
            e.preventDefault();
            let logId = $(this).data('id');
            let url = deleteRoute.replace(':id', logId);

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
                                toastr.error(response.message || 'Failed to delete attendance log.');
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
            var $table = $('#attendance_logs_table');
            
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
            // Open modal for editing attendance log
            $(document).on('click', '.edit-log-btn', function() {
                var logId = $(this).data('id');
                
                $.get('/attendance-logs/' + logId + '/edit', function(data) {
                    $('#log_id').val(data.id);
                    $('#sn').val(data.sn);
                    $('#user_id').val(data.user_id);
                    $('#attendance_date').val(data.attendance_date);
                    $('#attendance_time').val(data.attendance_time);
                    $('#extra').val(data.extra);
                    $('#punch_type').val(data.punch_type);
                    $('#status_1').val(data.status_1);
                    $('#status_2').val(data.status_2);
                    $('#modal-title').text('Edit Attendance Log: ' + data.sn);
                    $('#attendance-log-modal').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load attendance log data: ' + xhr.responseJSON.message,
                        timer: 3000
                    });
                });
            });
            
            // Handle form submission
            $('#attendanceLogForm').submit(function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();
                var url = $('#log_id').val() ? '/attendance-logs/' + $('#log_id').val() : '/attendance-logs';
                var method = $('#log_id').val() ? 'PUT' : 'POST';
                
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
                        $('#attendance-log-modal').modal('hide');
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