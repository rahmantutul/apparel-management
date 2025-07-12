@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-header m-0">
                    Users 
                    <a href="javascript:;" onclick="showAjaxModal();" class="btn btn-primary btn-icon icon-left ">
                        <i class="entypo-plus"></i> Add User
                    </a>
            </h2>
            
        </div>

    	<table class="table table-bordered datatable table-responsive" id="users_table">
			<thead>
				 <tr>
                    <th data-hide="id">SL.No</th>                    
                    <th data-hide="name">Name</th>
                    <th data-hide="username">Username</th>
                    <th data-hide="phone">Email</th>
                    <th data-hide="phone,tablet">Phone</th>
                    <th data-hide="created_at">Joined Date</th>
                    <th data-hide="role">Role</th>
                    <th data-hide="action">Action</th>
                </tr>
			</thead>
			<tbody>
                    @foreach($users as $key => $user)
                        <tr class="odd gradeX" id="user-{{ $user->id }}">
                            <td>{{ $key + 1 }}</td>                            
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="center">{{ $user->phone ?? '-' }}</td>
                            <td class="center">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="center">
                                @if($user->roles->count() > 0)
                                    <span class="badge">{{ $user->roles->first()->name }}</span>
                                @else
                                    <span class="badge">No Role</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-default btn-sm btn-icon icon-left editBtn" data-id="{{ $user->id }}">
                                    <i class="entypo-pencil"></i> Edit
                                </a>

                               <a href="#" class="btn btn-danger btn-sm btn-icon icon-left deleteBtn" data-id="{{ $user->id }}">
                                    <i class="entypo-cancel"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach				
			</tbody>
			<tfoot>
				 <tr>
                    <th data-hide="id">SL.No</th>                    
                    <th data-hide="name">Name</th>
                    <th data-hide="username">Username</th>
                    <th data-hide="phone">Email</th>
                    <th data-hide="phone,tablet">Phone</th>
                    <th data-hide="created_at">Joined Date</th>
                    <th data-hide="role">Role</th>
                    <th data-hide="action">Action</th>
                </tr>
			</tfoot>
		</table>
       <!-- Add User Modal -->

      <div class="modal fade" id="add-user-modal">
        <div class="modal-dialog">
            <form id="addUserForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Save User</button>
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
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" id="edit-role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
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
			jQuery('#add-user-modal').modal('show', {backdrop: 'static'});
			
			jQuery.ajax({
				url: "data/ajax-content.txt",
				success: function(response)
				{
					jQuery('#add-user-modal .modal-body').html(response);
				}
			});
		}
	</script>
    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var $table1 = jQuery( '#users_table' );
            
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
        const deleteRoute = "{{ route('users.destroy', ':id') }}";

        $(document).on('click', '.deleteBtn', function (e) {
            e.preventDefault();
            let userId = $(this).data('id');
            let url = deleteRoute.replace(':id', userId);

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
                                $('#user-' + userId).fadeOut(300, function () {
                                    $(this).remove();
                                });

                                toastr.success(response.message || 'User deleted successfully!');
                            } else {
                                toastr.error('Failed to delete user.');
                            }
                        },
                        error: function () {
                            toastr.error('Something went wrong!');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#addUserForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("users.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            // Close modal
                            $('#add-user-modal').modal('hide');
                            $('#addUserForm')[0].reset();

                            // Success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'User Added',
                                text: response.message,
                                timer: 1000,
                                showConfirmButton: false
                            });
                            console.log(response.user);
                            // Append row to table (adjust column match)
                          let serial = $('#users_table tbody tr').length + 1;
                           $('#users_table tbody').prepend(`
                                <tr id="user-${response.user.id}" class="odd gradeX">
                                    <td>${serial}</td>
                                    <td>${response.user.name}</td>
                                    <td>${response.user.username}</td>
                                    <td>${response.user.email}</td>
                                    <td class="center">${response.user.phone ?? '-'}</td>
                                    <td class="center">${response.user.created_at_formatted}</td>
                                    <td>
                                        <a href="#" class="btn btn-default btn-sm btn-icon icon-left editBtn" data-id="${response.user.id}">
                                            <i class="entypo-pencil"></i> Edit
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left deleteBtn" data-id="${response.user.id}">
                                            <i class="entypo-cancel"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message ?? 'Something went wrong', 'error');
                    }
                });
            });
        });
    </script>
    <script>
        const updateUserRoute = '{{ route("users.update", ":id") }}';

        // Load user data
            $(document).on('click', '.editBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');

                $.get('/users/' + id + '/edit', function (user) {
                   console.log(user);
                    // Check each field one by one
                    $('#edit-user-id').val(user.id);
                    console.log('ID set to:', user.id);
                    
                    $('#edit-name').val(user.name); 
                    console.log('Name set to:', user.name);
                    
                    $('#edit-username').val(user.username);
                    console.log('Username set to:', user.username);
                    
                    $('#edit-email').val(user.email);
                    console.log('Email set to:', user.email);
                    
                    $('#edit-phone').val(user.phone);
                    console.log('Phone set to:', user.phone);
                    
                    // Role selection
                    if (user.roles && user.roles.length > 0) {
                        console.log('Setting role to:', user.roles[0].id);
                        $('#edit-role').val(user.roles[0].id).trigger('change');
                    } else {
                        console.log('No roles found');
                        $('#edit-role').val('').trigger('change');
                    }
                    
                    // Clear passwords
                    $('#edit-password').val('');
                    $('#edit-password-confirmation').val('');

                    $('#edit-user-modal').modal('show');
                });
            });

            // Submit updated user
            $('#editUserForm').submit(function (e) {
                e.preventDefault();
                let id = $('#edit-user-id').val();
                let route = updateUserRoute.replace(':id', id);
                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#edit-user-modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // This executes after the Swal timer completes
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON?.message ?? 'Update failed.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

    </script>

@endpush