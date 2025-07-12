@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-header m-0">
                    Users 
                    <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left ">
                        <i class="entypo-plus"></i> Add Role
                    </a>
            </h2>
            
        </div>

    	<table class="table table-bordered datatable table-responsive" id="roles_table">
			<thead>
				 <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
			</thead>
			<tbody>
                @foreach($roles as $role)
                    <tr>
                       <td>{{ $role->name }}</td>
                       <td class="py-2" style="width: 80%">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($role->permissions as $permission)
                                      <span class="badge bg-primary text-white rounded-pill px-2 py-1">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-default btn-sm btn-icon icon-left edit-role-btn" data-id="{{ $role->id }}">
                                    <i class="entypo-pencil"></i> Edit
                            </button>
                        </td>
                    </tr>
                @endforeach	
			</tbody>
			<tfoot>
				 <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
			</tfoot>
		</table>
       <!-- Add User Modal -->

      <div class="modal fade" id="role-modal">
        <div class="modal-dialog">
            <form id="roleForm">
                @csrf
                <input type="hidden" id="role_id" name="id">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Add New Role</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Role Name Field -->
                        <div class="form-group">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="role_name" class="form-control" required>
                        </div>
                        
                        <!-- Permissions Section with Select All -->
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label>Permissions</label>
                                <button type="button" id="selectAllPermissions" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-check-circle"></i> Select All
                                </button>
                            </div>
                            
                            <div class="row permission-checkboxes">
                                @foreach($permissions as $permission)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" 
                                                value="{{ $permission->name }}" 
                                                id="permission-{{ $permission->id }}"
                                                class="form-check-input permission-checkbox">
                                            <label for="permission-{{ $permission->id }}" 
                                                class="form-check-label">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-role-btn">Save Role</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-user-modal">
        <div class="modal-dialog">
            <form id="editUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-user-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                   <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="edit-name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="edit-username" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="edit-email" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" id="edit-phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>New Password <small>(leave blank to keep current)</small></label>
                                    <input type="password" name="password" id="edit-password" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="edit-password-confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@push('scripts')
	<script type="text/javascript">
		function showAjaxModal()
		{
			jQuery('#role-modal').modal('show', {backdrop: 'static'});
			
			jQuery.ajax({
				url: "data/ajax-content.txt",
				success: function(response)
				{
					jQuery('#role-modal .modal-body').html(response);
				}
			});
		}
	</script>
    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var $table1 = jQuery( '#roles_table' );
            
            $table1.DataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bStateSave": true
            });
            
            $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
                minimumResultsForSearch: -1
            });
        } );
    </script>
    <script>
        $(document).ready(function() {
            // Select All functionality
            $('#selectAllPermissions').click(function() {
                const checkboxes = $('.permission-checkbox');
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                
                if (allChecked) {
                    // If all are checked, uncheck all
                    checkboxes.prop('checked', false);
                    $(this).html('<i class="fas fa-check-circle"></i> Select All');
                } else {
                    // If not all checked, check all
                    checkboxes.prop('checked', true);
                    $(this).html('<i class="fas fa-times-circle"></i> Deselect All');
                }
            });
            
            // Update Select All button when individual checkboxes change
            $('.permission-checkboxes').on('change', '.permission-checkbox', function() {
                const checkboxes = $('.permission-checkbox');
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                
                $('#selectAllPermissions').html(
                    allChecked 
                        ? '<i class="fas fa-times-circle"></i> Deselect All'
                        : '<i class="fas fa-check-circle"></i> Select All'
                );
            });
            
            // When editing a role, update Select All button state
            $(document).on('click', '.edit-role-btn', function() {
                setTimeout(() => {
                    const checkboxes = $('.permission-checkbox');
                    const allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                    
                    $('#selectAllPermissions').html(
                        allChecked 
                            ? '<i class="fas fa-times-circle"></i> Deselect All'
                            : '<i class="fas fa-check-circle"></i> Select All'
                    );
                }, 100);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Open modal for new role
            $('#add-role-btn').click(function() {
                $('#role_id').val('');
                $('#role_name').val('');
                $('.permission-checkbox').prop('checked', false);
                $('#modal-title').text('Add New Role');
                $('#role-modal').modal('show');
            });
            
            // Open modal for editing role
            $(document).on('click', '.edit-role-btn', function() {
                var roleId = $(this).data('id');
                
                $.get('/roles/' + roleId + '/edit', function(data) {
                    $('#role_id').val(data.role.id);
                    $('#role_name').val(data.role.name);
                    $('#modal-title').text('Edit Role: ' + data.role.name);
                    
                    // Uncheck all checkboxes first
                    $('.permission-checkbox').prop('checked', false);
                    
                    // Check the permissions this role has
                    data.role.permissions.forEach(function(permission) {
                        $('.permission-checkbox[value="' + permission.name + '"]').prop('checked', true);
                    });
                    
                    $('#role-modal').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load role data: ' + xhr.responseJSON.message,
                        timer: 3000
                    });
                });
            });
            
            // Handle form submission
            $('#roleForm').submit(function(e) {
                e.preventDefault();
                
                var formData = $(this).serialize();
                var url = $('#role_id').val() ? '/roles/' + $('#role_id').val() : '/roles';
                var method = $('#role_id').val() ? 'PUT' : 'POST';
                
                // Show loading indicator
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
                        $('#role-modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Operation completed successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Refresh after success
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