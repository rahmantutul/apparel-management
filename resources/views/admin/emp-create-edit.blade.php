@extends('admin.layouts.app')

@push('styles')
<style>
    /* Toggle Switch Styles */
    .toggle-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #4e73df;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    
    /* User Header Styles */
    .user-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .user-title {
        color: blue;
        display: flex;
        align-items: center;
        margin: 0;
    }
    
    .image-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="employee-form">
        <div class="form-header">
            <h2>
                {{ isset($employee) ? 'Edit Employee' : 'Add New Employee' }}
                <a href="{{ route('employees.index') }}"class="btn btn-primary btn-icon icon-left">
                    <i class="fas fa-list"></i> Go to List
                </a>
            </h2>
           @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    @if(session('employee_id'))
                        <a href="{{ route('employees.show', session('employee_id')) }}" class="alert-link">
                            View Employee
                        </a>
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($employee))
                @method('PUT')
            @endif

            <div class="row" style="background: #f1f0f0; padding: 20px; border-radius: 10px; margin-top: 20px;">
                <!-- Personal Information Column -->
                <div class="col-lg-6">
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 style="color: blue"><i class="fas fa-user mr-2"></i> Personal Information</h5>
                        </div>
                        <hr style="border-color: #000; border-width: 1px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="emp_name" name="emp_name" required
                                            value="{{ old('emp_name', $employee->emp_name ?? '') }}" placeholder="John Doe">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_id">Employee ID</label>
                                        <input type="text" class="form-control" id="emp_id" name="emp_id" value="{{ old('emp_id', $employee->emp_id ?? '') }}" placeholder="EMP-001">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_gender">Gender</label>
                                        <select class="form-control" id="emp_gender" name="emp_gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'other') ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_date_of_birth">Date of Birth</label>
                                        <input type="date" class="form-control" id="emp_date_of_birth" name="emp_date_of_birth"
                                            value="{{ old('emp_date_of_birth', $employee->emp_date_of_birth ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_marital_status">Marital Status</label>
                                        <select class="form-control" id="emp_marital_status" name="emp_marital_status">
                                            <option value="">Select Status</option>
                                            <option value="single" {{ (old('emp_marital_status', $employee->emp_marital_status ?? '') == 'single') ? 'selected' : '' }}>Single</option>
                                            <option value="married" {{ (old('emp_marital_status', $employee->emp_marital_status ?? '') == 'married') ? 'selected' : '' }}>Married</option>
                                            <option value="divorced" {{ (old('emp_marital_status', $employee->emp_marital_status ?? '') == 'divorced') ? 'selected' : '' }}>Divorced</option>
                                            <option value="widowed" {{ (old('emp_marital_status', $employee->emp_marital_status ?? '') == 'widowed') ? 'selected' : '' }}>Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_blood_group">Blood Group</label>
                                        <select class="form-control" id="emp_blood_group" name="emp_blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'A+') ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'A-') ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'B+') ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'B-') ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'AB+') ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'AB-') ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'O+') ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ (old('emp_blood_group', $employee->emp_blood_group ?? '') == 'O-') ? 'selected' : '' }}>O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_email">Email</label>
                                        <input type="email" class="form-control" id="emp_email" name="emp_email"
                                            value="{{ old('emp_email', $employee->emp_email ?? '') }}" placeholder="john.doe@example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_religion">Religion</label>
                                        <input type="text" class="form-control" id="emp_religion" name="emp_religion"
                                            value="{{ old('emp_religion', $employee->emp_religion ?? '') }}" placeholder="Christian">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_national_id">National ID</label>
                                        <input type="text" class="form-control" id="emp_national_id" name="emp_national_id"
                                            value="{{ old('emp_national_id', $employee->emp_national_id ?? '') }}" placeholder="1234567890">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 style="color: blue"><i class="fas fa-address-book mr-2"></i> Contact Information</h5>
                        </div>
                        <hr style="border-color: #000; border-width: 1px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_contact_number">Contact Number</label>
                                        <input type="text" class="form-control" id="emp_contact_number" name="emp_contact_number"
                                            value="{{ old('emp_contact_number', $employee->emp_contact_number ?? '') }}" placeholder="+1234567890">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_emergency_contact">Emergency Contact</label>
                                        <input type="text" class="form-control" id="emp_emergency_contact" name="emp_emergency_contact"
                                            value="{{ old('emp_emergency_contact', $employee->emp_emergency_contact ?? '') }}" placeholder="+1234567890">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_present_address">Present Address</label>
                                        <textarea class="form-control" id="emp_present_address" name="emp_present_address" rows="3" placeholder="123 Main St, City, Country">{{ old('emp_present_address', $employee->emp_present_address ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_permanent_address">Permanent Address</label>
                                        <textarea class="form-control" id="emp_permanent_address" name="emp_permanent_address" rows="3" placeholder="123 Main St, City, Country">{{ old('emp_permanent_address', $employee->emp_permanent_address ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!isset($employee) || !$employee->user)
                        <!-- User Account Card (Updated) -->
                        <div class="card form-card">
                            <!-- For User Account Toggle -->
                            <div class="card-header user-header">
                                <h5 class="user-title">
                                    <i class="fas fa-user-circle mr-2"></i> &nbsp; User Account
                                </h5>
                                <div class="toggle-container">
                                    <label class="mb-0">Create login account:</label>
                                    <label class="toggle-switch">
                                        <input type="checkbox" id="create_user_account" name="create_user_account" value="1"
                                            {{ old('create_user_account', isset($employee->user) ? 'checked' : '') ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                            <hr style="border-color: #000; border-width: 1px;">

                            <div id="user_account_fields" style="{{ old('create_user_account', isset($employee->user)) ? '' : 'display: none;' }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username <span class="text-danger">*</span></label>
                                                <input type="text" id="username" name="username" class="form-control" 
                                                    value="{{ old('username', $employee->user->username ?? '') }}"
                                                    {{ old('create_user_account', isset($employee->user)) ? 'required' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_id">Role <span class="text-danger">*</span></label>
                                                <select class="form-control" id="role_id" name="role_id" 
                                                    {{ old('create_user_account', isset($employee->user)) ? 'required' : '' }}>
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ (old('role_id', $employee->user->role_id ?? '') == $role->id) ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!isset($employee) || !$employee->user)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" id="password" name="password" class="form-control" 
                                                    {{ old('create_user_account', isset($employee->user)) ? 'required' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" 
                                                    {{ old('create_user_account', isset($employee->user)) ? 'required' : '' }}>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Employment Information Column -->
                <div class="col-lg-6" >
                    <!-- Employment Information -->
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 style="color: blue"><i class="fas fa-briefcase mr-2"></i> Employment Information</h5>
                        </div>
                        <hr style="border-color: #000; border-width: 1px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department <span class="text-danger">*</span></label>
                                        <select class="form-control" id="department_id" name="department_id" required>
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ (old('department_id', $employee->department_id ?? '') == $department->id) ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="designation_id">Designation <span class="text-danger">*</span></label>
                                        <select class="form-control" id="designation_id" name="designation_id" required>
                                            <option value="">Select Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{ $designation->id }}" {{ (old('designation_id', $employee->designation_id ?? '') == $designation->id) ? 'selected' : '' }}>
                                                    {{ $designation->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shift_id">Shift</label>
                                        <select class="form-control" id="shift_id" name="shift_id">
                                            <option value="">Select Shift</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{ $shift->id }}" {{ (old('shift_id', $employee->shift_id ?? '') == $shift->id) ? 'selected' : '' }}>
                                                    {{ $shift->shift_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_joining_date">Joining Date</label>
                                        <input type="date" class="form-control" id="emp_joining_date" name="emp_joining_date"
                                            value="{{ old('emp_joining_date', $employee->emp_joining_date ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_status">Status</label>
                                        <select class="form-control" id="emp_status" name="emp_status">
                                            <option value="active" {{ (old('emp_status', $employee->emp_status ?? 'active') == 'active') ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ (old('emp_status', $employee->emp_status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                                            <option value="on_leave" {{ (old('emp_status', $employee->emp_status ?? '') == 'on_leave') ? 'selected' : '' }}>On Leave</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_starting_salary">Starting Salary</label>
                                        <input type="number" step="0.01" class="form-control" id="emp_starting_salary" name="emp_starting_salary"
                                            value="{{ old('emp_starting_salary', $employee->emp_starting_salary ?? '') }}" placeholder="0.00">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_salary_payment_method">Salary Payment Method</label>
                                        <select class="form-control" id="emp_salary_payment_method" name="emp_salary_payment_method">
                                            <option value="">Select Method</option>
                                            <option value="cash" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
                                            <option value="bank" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'bank') ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="check" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'check') ? 'selected' : '' }}>Check</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_bank_account">Bank Account Number</label>
                                        <input type="text" class="form-control" id="emp_bank_account" name="emp_bank_account"
                                            value="{{ old('emp_bank_account', $employee->emp_bank_account ?? '') }}" placeholder="1234567890">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group d-flex align-items-center" style="margin-top: 20px !important">
                                        <label class="mb-0 mr-3">Resigned:</label>
                                        <label class="toggle-switch-for-resignation">
                                            <input type="checkbox" id="emp_is_resigned" name="emp_is_resigned" 
                                                value="1" {{ old('emp_is_resigned', $employee->emp_is_resigned ?? false) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group" id="resignation_date_group" style="{{ old('emp_is_resigned', $employee->emp_is_resigned ?? false) ? '' : 'display: none;' }}">
                                        <label for="emp_resignation_date">Resignation Date</label>
                                        <input type="date" class="form-control" id="emp_resignation_date" name="emp_resignation_date"
                                            value="{{ old('emp_resignation_date', $employee->emp_resignation_date ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 style="color: blue"><i class="fas fa-info-circle mr-2"></i> Additional Information</h5>
                        </div>
                        <hr style="border-color: #000; border-width: 1px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_father_name">Father Name</label>
                                        <input type="text" class="form-control" id="emp_father_name" name="emp_father_name"
                                            value="{{ old('emp_father_name', $employee->emp_father_name ?? '') }}" placeholder="Father's Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_mother_name">Mother Name</label>
                                        <input type="text" class="form-control" id="emp_mother_name" name="emp_mother_name"
                                            value="{{ old('emp_mother_name', $employee->emp_mother_name ?? '') }}" placeholder="Mother's Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_qualification">Qualification</label>
                                        <input type="text" class="form-control" id="emp_qualification" name="emp_qualification"
                                            value="{{ old('emp_qualification', $employee->emp_qualification ?? '') }}" placeholder="Bachelor's Degree">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emp_experience">Experience</label>
                                        <input type="text" class="form-control" id="emp_experience" name="emp_experience"
                                            value="{{ old('emp_experience', $employee->emp_experience ?? '') }}" placeholder="5 years">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="emp_short_bio">Short Bio</label>
                                <textarea class="form-control" id="emp_short_bio" name="emp_short_bio" rows="3" placeholder="Brief description about the employee">{{ old('emp_short_bio', $employee->emp_short_bio ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Files Section -->
                    <div class="card form-card">
                        <div class="card-header">
                            <h5 style="color: blue"><i class="fas fa-file mr-2"></i> Documents & Images</h5>
                        </div>
                        <hr style="border-color: #000; border-width: 1px;">
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emp_image">Profile Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="emp_image" name="emp_image">
                                        <label class="custom-file-label" for="emp_image">Choose file</label>
                                    </div>
                                    @if(isset($employee) && $employee->emp_image)
                                        <div class="mt-3">
                                            <img src="{{ asset('storage/' . $employee->emp_image) }}" alt="Profile Image" class="image-preview">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emp_file">Documents (CV, Certificates, etc.)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="emp_file" name="emp_file">
                                        <label class="custom-file-label" for="emp_file">Choose file</label>
                                    </div>
                                    @if(isset($employee) && $employee->emp_file)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $employee->emp_file) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-eye mr-1"></i> View Document
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary submit-btn px-5 py-2">
                                <i class="fas fa-save mr-2"></i> {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                            </button>
                        </div>
                    </div>
            </div>

            
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle user account fields
    document.getElementById('create_user_account').addEventListener('change', function() {
        const fields = document.getElementById('user_account_fields');
        const requiredFields = fields.querySelectorAll('[required]');
        
        if (this.checked) {
            fields.style.display = 'block';
            requiredFields.forEach(field => field.required = true);
        } else {
            fields.style.display = 'none';
            requiredFields.forEach(field => field.required = false);
        }
    });

    // Toggle resignation date field
    document.getElementById('emp_is_resigned').addEventListener('change', function() {
        document.getElementById('resignation_date_group').style.display = this.checked ? 'block' : 'none';
    });

    // Update file input labels
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function() {
            let fileName = this.files[0] ? this.files[0].name : 'Choose file';
            this.nextElementSibling.textContent = fileName;
        });
    });
</script>
@endpush