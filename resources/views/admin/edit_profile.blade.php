@extends('admin.layouts.app')
@push('styles')
@endpush
@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-header m-0">
                    Edit personal Info 
            </h2>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8" style="background: rgb(235, 243, 247); padding: 20px;">
                <form id="editUserForm">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" id="edit-user-id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit-name" class="form-control" value="{{ $user->name }}" required>
                                <input type="hidden" name="id" id="edit-user-id" class="form-control" value="{{ $user->id }}" required>
                                <input type="hidden" name="role" class="form-control" value="{{ $roleId }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="edit-username" class="form-control" value="{{ $user->username }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="edit-email" class="form-control" value="{{ $user->email }}"  required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" id="edit-phone" class="form-control" value="{{ $user->phone }}">
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
                
                    <button type="submit" class="btn btn-info">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
         </div>
  
@endsection
@push('scripts')
    <script>
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
             Swal.fire({
                title: 'Updating Profile...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let formData = $(this).serialize();
            let userId = $('#edit-user-id').val();
            $.ajax({
                url: "{{ route('profile.update', ['id' => $user->id]) }}",
                type: 'put',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Profile updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#edit-user-modal').modal('hide');
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Update failed. Please try again.';
                    
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
@endpush