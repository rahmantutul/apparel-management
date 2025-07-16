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

<form method="POST" action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($employee))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto d-flex align-items-center">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emp_id">Employee ID</label>
                                <input type="text" class="form-control" id="emp_id" name="emp_id" 
                                    value="{{ old('emp_id', $employee->emp_id ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="emp_name" name="emp_name" required
                                    value="{{ old('emp_name', $employee->emp_name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_email">Email</label>
                                <input type="email" class="form-control" id="emp_email" name="emp_email"
                                    value="{{ old('emp_email', $employee->emp_email ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_gender">Gender</label>
                                <select class="form-control" id="emp_gender" name="emp_gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ (old('emp_gender', $employee->emp_gender ?? '') == 'other') ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="emp_date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="emp_date_of_birth" name="emp_date_of_birth"
                                    value="{{ old('emp_date_of_birth', $employee->emp_date_of_birth ?? '') }}">
                            </div>

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

                            <div class="form-group">
                                <label for="emp_religion">Religion</label>
                                <input type="text" class="form-control" id="emp_religion" name="emp_religion"
                                    value="{{ old('emp_religion', $employee->emp_religion ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_national_id">National ID</label>
                                <input type="text" class="form-control" id="emp_national_id" name="emp_national_id"
                                    value="{{ old('emp_national_id', $employee->emp_national_id ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emp_contact_number">Contact Number</label>
                                <input type="text" class="form-control" id="emp_contact_number" name="emp_contact_number"
                                    value="{{ old('emp_contact_number', $employee->emp_contact_number ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_emergency_contact">Emergency Contact</label>
                                <input type="text" class="form-control" id="emp_emergency_contact" name="emp_emergency_contact"
                                    value="{{ old('emp_emergency_contact', $employee->emp_emergency_contact ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_present_address">Present Address</label>
                                <textarea class="form-control" id="emp_present_address" name="emp_present_address" rows="3">{{ old('emp_present_address', $employee->emp_present_address ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="emp_permanent_address">Permanent Address</label>
                                <textarea class="form-control" id="emp_permanent_address" name="emp_permanent_address" rows="3">{{ old('emp_permanent_address', $employee->emp_permanent_address ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Employment Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Employment Information</h5>
                        </div>
                        <div class="card-body">
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

                            <div class="form-group">
                                <label for="shift_id">Shift</label>
                                <select class="form-control" id="shift_id" name="shift_id">
                                    <option value="">Select Shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ (old('shift_id', $employee->shift_id ?? '') == $shift->id) ? 'selected' : '' }}>
                                            {{ $shift->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="emp_joining_date">Joining Date</label>
                                <input type="date" class="form-control" id="emp_joining_date" name="emp_joining_date"
                                    value="{{ old('emp_joining_date', $employee->emp_joining_date ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_status">Status</label>
                                <select class="form-control" id="emp_status" name="emp_status">
                                    <option value="active" {{ (old('emp_status', $employee->emp_status ?? 'active') == 'active') ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ (old('emp_status', $employee->emp_status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                                    <option value="on_leave" {{ (old('emp_status', $employee->emp_status ?? '') == 'on_leave') ? 'selected' : '' }}>On Leave</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="emp_starting_salary">Starting Salary</label>
                                <input type="number" step="0.01" class="form-control" id="emp_starting_salary" name="emp_starting_salary"
                                    value="{{ old('emp_starting_salary', $employee->emp_starting_salary ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_salary_payment_method">Salary Payment Method</label>
                                <select class="form-control" id="emp_salary_payment_method" name="emp_salary_payment_method">
                                    <option value="">Select Method</option>
                                    <option value="cash" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
                                    <option value="bank" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'bank') ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="check" {{ (old('emp_salary_payment_method', $employee->emp_salary_payment_method ?? '') == 'check') ? 'selected' : '' }}>Check</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="emp_bank_account">Bank Account Number</label>
                                <input type="text" class="form-control" id="emp_bank_account" name="emp_bank_account"
                                    value="{{ old('emp_bank_account', $employee->emp_bank_account ?? '') }}">
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="emp_is_resigned" name="emp_is_resigned" 
                                    value="1" {{ old('emp_is_resigned', $employee->emp_is_resigned ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="emp_is_resigned">Resigned</label>
                            </div>

                            <div class="form-group" id="resignation_date_group" style="{{ old('emp_is_resigned', $employee->emp_is_resigned ?? false) ? '' : 'display: none;' }}">
                                <label for="emp_resignation_date">Resignation Date</label>
                                <input type="date" class="form-control" id="emp_resignation_date" name="emp_resignation_date"
                                    value="{{ old('emp_resignation_date', $employee->emp_resignation_date ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emp_father_name">Father Name</label>
                                <input type="text" class="form-control" id="emp_father_name" name="emp_father_name"
                                    value="{{ old('emp_father_name', $employee->emp_father_name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_mother_name">Mother Name</label>
                                <input type="text" class="form-control" id="emp_mother_name" name="emp_mother_name"
                                    value="{{ old('emp_mother_name', $employee->emp_mother_name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_qualification">Qualification</label>
                                <input type="text" class="form-control" id="emp_qualification" name="emp_qualification"
                                    value="{{ old('emp_qualification', $employee->emp_qualification ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_experience">Experience</label>
                                <input type="text" class="form-control" id="emp_experience" name="emp_experience"
                                    value="{{ old('emp_experience', $employee->emp_experience ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="emp_short_bio">Short Bio</label>
                                <textarea class="form-control" id="emp_short_bio" name="emp_short_bio" rows="3">{{ old('emp_short_bio', $employee->emp_short_bio ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Files -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Files</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emp_image">Profile Image</label>
                                <input type="file" class="form-control-file" id="emp_image" name="emp_image">
                                @if(isset($employee) && $employee->emp_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $employee->emp_image) }}" alt="Profile Image" width="100">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="emp_file">Documents (CV, Certificates, etc.)</label>
                                <input type="file" class="form-control-file" id="emp_file" name="emp_file">
                                @if(isset($employee) && $employee->emp_file)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $employee->emp_file) }}" target="_blank">View Document</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
        </button>
    </div>
</form>
@endsection

@push('scripts')
    <script>
        document.getElementById('emp_is_resigned').addEventListener('change', function() {
            document.getElementById('resignation_date_group').style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endpush