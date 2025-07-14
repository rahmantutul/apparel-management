@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-header m-0">
            Designations
            <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left">
                <i class="entypo-plus"></i> Add Designation
            </a>
        </h2>
    </div>

    <table class="table table-bordered datatable table-responsive" id="designations_table">
        <thead>
            <tr>
                <th>Designation Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($designations as $designation)
                <tr>
                    <td>{{ $designation->name }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-designation-btn" data-id="{{ $designation->id }}">
                            <i class="entypo-pencil"></i> Edit
                        </button>
                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left deleteBtn" data-id="{{ $designation->id }}">
                            <i class="entypo-cancel"></i> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Designation Name</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>

    <!-- Designation Modal -->
    <div class="modal fade" id="designation-modal">
        <div class="modal-dialog">
            <form id="designationForm">
                @csrf
                <input type="hidden" id="designation_id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Add New Designation</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="designation_name" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-designation-btn">Save Designation</button>
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
            $('#designation_id').val('');
            $('#designation_name').val('');
            $('#modal-title').text('Add New Designation');
            $('#designation-modal').modal('show', {backdrop: 'static'});
        }
    </script>
    <script>
        const deleteRoute = "{{ route('designations.destroy', ':id') }}";
        $(document).on('click', '.deleteBtn', function (e) {
            e.preventDefault();
            let designationId = $(this).data('id');
            let url = deleteRoute.replace(':id', designationId);

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
                                toastr.error(response.message || 'Failed to delete designation.');
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
            var $table = $('#designations_table');
            
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
            // Open modal for editing designation
            $(document).on('click', '.edit-designation-btn', function() {
                var designationId = $(this).data('id');
                
                $.get('/designations/' + designationId + '/edit', function(data) {
                    $('#designation_id').val(data.id);
                    $('#designation_name').val(data.name);
                    $('#modal-title').text('Edit Designation: ' + data.name);
                    $('#designation-modal').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load designation data: ' + xhr.responseJSON.message,
                        timer: 3000
                    });
                });
            });
            
            // Handle form submission
            $('#designationForm').submit(function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();
                var url = $('#designation_id').val() ? '/designations/' + $('#designation_id').val() : '/designations';
                var method = $('#designation_id').val() ? 'PUT' : 'POST';
                
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
                        $('#designation-modal').modal('hide');
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