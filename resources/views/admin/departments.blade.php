@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-header m-0">
            Departments
            <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left">
                <i class="entypo-plus"></i> Add Department
            </a>
        </h2>
    </div>

    <table class="table table-bordered datatable table-responsive" id="departments_table">
        <thead>
            <tr>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-department-btn" data-id="{{ $department->id }}">
                            <i class="entypo-pencil"></i> Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>

    <!-- Department Modal -->
    <div class="modal fade" id="department-modal">
        <div class="modal-dialog">
            <form id="departmentForm">
                @csrf
                <input type="hidden" id="department_id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Add New Department</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="department_name" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-department-btn">Save Department</button>
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
            $('#department_id').val('');
            $('#department_name').val('');
            $('#modal-title').text('Add New Department');
            $('#department-modal').modal('show', {backdrop: 'static'});
        }
    </script>
    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var $table = $('#departments_table');
            
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
            // Open modal for editing department
            $(document).on('click', '.edit-department-btn', function() {
                var departmentId = $(this).data('id');
                
                $.get('/departments/' + departmentId + '/edit', function(data) {
                    $('#department_id').val(data.id);
                    $('#department_name').val(data.name);
                    $('#modal-title').text('Edit Department: ' + data.name);
                    $('#department-modal').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load department data: ' + xhr.responseJSON.message,
                        timer: 3000
                    });
                });
            });
            
            // Handle form submission
            $('#departmentForm').submit(function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();
                var url = $('#department_id').val() ? '/departments/' + $('#department_id').val() : '/departments';
                var method = $('#department_id').val() ? 'PUT' : 'POST';
                
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
                        $('#department-modal').modal('hide');
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