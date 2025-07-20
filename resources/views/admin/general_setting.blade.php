@extends('admin.layouts.app')
@push('styles')
<style>
    .logo-upload-container {
        border: 1px dashed #ddd;
        border-radius: 4px;
        padding: 20px;
        background: #f9f9f9;
    }
    .logo-preview {
        text-align: center;
    }
    .logo-actions {
        text-align: center;
    }
    .custom-file-label::after {
        content: "Browse";
    }
</style>
@endpush

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-header m-0">
                    General Settings 
            </h2>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12" style="background: rgb(232, 235, 235); padding: 20px;">
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
                <form action="{{ route('general_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" 
                                    value="{{ old('company_name', $settings->company_name) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Email</label>
                                <input type="email" name="company_email" class="form-control" 
                                    value="{{ old('company_email', $settings->company_email) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Phone</label>
                                <input type="text" name="company_phone" class="form-control" 
                                    value="{{ old('company_phone', $settings->company_phone) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Subscription Type</label>
                                <input type="text" name="subscription_type" class="form-control" 
                                    value="{{ old('subscription_type', $settings->subscription_type) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Subscription Price</label>
                                <input type="number" step="0.01" name="subscription_price" class="form-control" 
                                    value="{{ old('subscription_price', $settings->subscription_price) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Type</label>
                                <input type="text" name="company_types" class="form-control" 
                                    value="{{ old('company_types', $settings->company_types) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Holiday Employee 1</label>
                                <input type="text" name="company_com_holiday_emp1" class="form-control" 
                                    value="{{ old('company_com_holiday_emp1', $settings->company_com_holiday_emp1) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Holiday Employee 2</label>
                                <input type="text" name="company_com_holiday_emp2" class="form-control" 
                                    value="{{ old('company_com_holiday_emp2', $settings->company_com_holiday_emp2) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Logo</label>
                                
                                <!-- Upload Area -->
                                <div class="logo-upload-container">
                                    <!-- Current Logo Preview -->
                                    @if($settings->company_logo)
                                    <div class="current-logo mb-3">
                                        <p class="text-muted small mb-1">Current Logo:</p>
                                        <div class="logo-preview">
                                            <img src="{{ asset('storage/'.$settings->company_logo) }}" 
                                                class="img-thumbnail" 
                                                style="max-width: 150px; max-height: 150px;"
                                                alt="Current Company Logo">
                                            <div class="logo-actions mt-2">
                                                <a href="{{ asset('storage/'.$settings->company_logo) }}" 
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary mr-2">
                                                    <i class="fas fa-eye"></i> View Full
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Upload Control -->
                                    <div class="upload-control">
                                        <div class="custom-file">
                                            <input type="file" 
                                                name="company_logo" 
                                                id="companyLogoInput"
                                                class="custom-file-input"
                                                accept="image/*">
                                            <label class="custom-file-label" for="companyLogoInput">
                                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                                Choose new logo...
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Recommended: 300×300px PNG with transparent background
                                        </small>
                                        
                                        <!-- Live Preview -->
                                        <div class="live-preview mt-3 d-none">
                                            <p class="text-muted small mb-1">New Logo Preview:</p>
                                            <img id="logoPreview" 
                                                class="img-thumbnail" 
                                                style="max-width: 150px; max-height: 150px;"
                                                alt="New Logo Preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Company Address</label>
                                <textarea name="company_address" class="form-control" rows="3">{{ old('company_address', $settings->company_address) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Settings</button>
                </form>
            </div>
         </div>
  
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File input change handler
        document.getElementById('companyLogoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('logoPreview');
            const previewContainer = document.querySelector('.live-preview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    previewContainer.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
                
                // Update the file input label
                const fileName = file.name.length > 20 
                    ? file.name.substring(0, 20) + '...' 
                    : file.name;
                document.querySelector('.custom-file-label').innerHTML = 
                    `<i class="fas fa-file-image mr-2"></i>${fileName}`;
            }
        });
    });
</script>
@endpush