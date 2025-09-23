@extends('layouts.admin')

@section('title', 'Add New Employee')
@section('page-title', 'Add New Employee')
@section('page-description', 'Create a new employee record with all details')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Employee Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="employeeCreateTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-create-tab" data-bs-toggle="tab" data-bs-target="#basic-create" type="button" role="tab">Basic Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="family-create-tab" data-bs-toggle="tab" data-bs-target="#family-create" type="button" role="tab">Family Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bank-create-tab" data-bs-toggle="tab" data-bs-target="#bank-create" type="button" role="tab">Bank Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="qualifications-create-tab" data-bs-toggle="tab" data-bs-target="#qualifications-create" type="button" role="tab">Qualifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="experience-create-tab" data-bs-toggle="tab" data-bs-target="#experience-create" type="button" role="tab">Experience</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="addresses-create-tab" data-bs-toggle="tab" data-bs-target="#addresses-create" type="button" role="tab">Addresses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payroll-create-tab" data-bs-toggle="tab" data-bs-target="#payroll-create" type="button" role="tab">Payroll</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-create-tab" data-bs-toggle="tab" data-bs-target="#documents-create" type="button" role="tab">Documents</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-4" id="employeeCreateTabsContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic-create" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="employee_code" class="form-label">Employee Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('employee_code') is-invalid @enderror" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required>
                                    @error('employee_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                                    @error('hire_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department') }}">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <!-- Family Details Tab -->
                        <div class="tab-pane fade" id="family-create" role="tabpanel">
                            <div id="family-container">
                                <div class="family-entry mb-3 border p-3 rounded">
                                    <h6 class="mb-3">Family Member 1</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Relation</label>
                                            <select class="form-select" name="relations[]">
                                                <option value="">Select Relation</option>
                                                <option value="father" {{ old('relations.0') == 'father' ? 'selected' : '' }}>Father</option>
                                                <option value="mother" {{ old('relations.0') == 'mother' ? 'selected' : '' }}>Mother</option>
                                                <option value="spouse" {{ old('relations.0') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                                <option value="son" {{ old('relations.0') == 'son' ? 'selected' : '' }}>Son</option>
                                                <option value="daughter" {{ old('relations.0') == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                                <option value="brother" {{ old('relations.0') == 'brother' ? 'selected' : '' }}>Brother</option>
                                                <option value="sister" {{ old('relations.0') == 'sister' ? 'selected' : '' }}>Sister</option>
                                                <option value="emergency" {{ old('relations.0') == 'emergency' ? 'selected' : '' }}>Emergency Contact</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="family_names[]" value="{{ old('family_names.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" name="contact_numbers[]" value="{{ old('contact_numbers.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Aadhar Number</label>
                                            <input type="text" class="form-control" name="aadhars[]" value="{{ old('aadhars.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-family">Remove</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">PAN Number</label>
                                            <input type="text" class="form-control" name="pans[]" value="{{ old('pans.0') }}">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Aadhar File</label>
                                            <input type="file" class="form-control" name="aadhar_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">PAN File</label>
                                            <input type="file" class="form-control" name="pan_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-family">Add Family Member</button>
                        </div>

                        <!-- Bank Details Tab -->
                        <div class="tab-pane fade" id="bank-create" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="branch_name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control @error('branch_name') is-invalid @enderror" id="branch_name" name="branch_name" value="{{ old('branch_name') }}">
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Qualifications Tab -->
                        <div class="tab-pane fade" id="qualifications-create" role="tabpanel">
                            <div id="qualifications-container">
                                <div class="qualification-entry mb-3">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Degree</label>
                                            <input type="text" class="form-control" name="degrees[]" value="{{ old('degrees.0') }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Institution</label>
                                            <input type="text" class="form-control" name="institutions[]" value="{{ old('institutions.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Year of Passing</label>
                                            <input type="number" class="form-control" name="year_of_passings[]" value="{{ old('year_of_passings.0') }}" min="1900" max="{{ date('Y') + 10 }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Grade/Percentage</label>
                                            <input type="text" class="form-control" name="grades[]" value="{{ old('grades.0') }}">
                                        </div>
                                        <div class="col-md-1 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-qualification">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-qualification">Add Qualification</button>
                        </div>

                        <!-- Experience Tab -->
                        <div class="tab-pane fade" id="experience-create" role="tabpanel">
                            <div id="experience-container">
                                <div class="experience-entry mb-3">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control" name="company_names[]" value="{{ old('company_names.0') }}">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Position</label>
                                            <input type="text" class="form-control" name="positions[]" value="{{ old('positions.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start_dates[]" value="{{ old('start_dates.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="end_dates[]" value="{{ old('end_dates.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-experience">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-experience">Add Experience</button>
                        </div>

                        <!-- Addresses Tab -->
                        <div class="tab-pane fade" id="addresses-create" role="tabpanel">
                            <div id="addresses-container">
                                <div class="address-entry mb-3">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Address Type</label>
                                            <select class="form-select" name="address_types[]">
                                                <option value="">Select Type</option>
                                                <option value="permanent" {{ old('address_types.0') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                                <option value="current" {{ old('address_types.0') == 'current' ? 'selected' : '' }}>Current</option>
                                                <option value="office" {{ old('address_types.0') == 'office' ? 'selected' : '' }}>Office</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Street Address</label>
                                            <input type="text" class="form-control" name="street_addresses[]" value="{{ old('street_addresses.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="cities[]" value="{{ old('cities.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="states[]" value="{{ old('states.0') }}">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_codes[]" value="{{ old('postal_codes.0') }}">
                                        </div>
                                        <div class="col-md-1 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-address">Remove</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Country</label>
                                            <input type="text" class="form-control" name="countries[]" value="{{ old('countries.0') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-address">Add Address</button>
                        </div>

                        <!-- Payroll Tab -->
                        <div class="tab-pane fade" id="payroll-create" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="basic_salary" class="form-label">Basic Salary</label>
                                    <input type="number" step="0.01" class="form-control @error('basic_salary') is-invalid @enderror" id="basic_salary" name="basic_salary" value="{{ old('basic_salary') }}">
                                    @error('basic_salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hra" class="form-label">HRA</label>
                                    <input type="number" step="0.01" class="form-control @error('hra') is-invalid @enderror" id="hra" name="hra" value="{{ old('hra') }}">
                                    @error('hra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="conveyance" class="form-label">Conveyance Allowance</label>
                                    <input type="number" step="0.01" class="form-control @error('conveyance') is-invalid @enderror" id="conveyance" name="conveyance" value="{{ old('conveyance') }}">
                                    @error('conveyance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="medical" class="form-label">Medical Allowance</label>
                                    <input type="number" step="0.01" class="form-control @error('medical') is-invalid @enderror" id="medical" name="medical" value="{{ old('medical') }}">
                                    @error('medical')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documents Tab -->
                        <div class="tab-pane fade" id="documents-create" role="tabpanel">
                            <div id="documents-container">
                                <div class="document-entry mb-3">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Document Type</label>
                                            <input type="text" class="form-control" name="document_types[]" value="{{ old('document_types.0') }}">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">File</label>
                                            <input type="file" class="form-control" name="document_files[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        </div>
                                        <div class="col-md-4 mb-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-document">Add Document</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Family Member
    document.getElementById('add-family').addEventListener('click', function() {
        const container = document.getElementById('family-container');
        const entry = container.querySelector('.family-entry').cloneNode(true);
        entry.querySelectorAll('input, select').forEach(input => input.value = '');
        // Update the heading number
        const familyEntries = container.querySelectorAll('.family-entry');
        const newNumber = familyEntries.length + 1;
        entry.querySelector('h6').textContent = `Family Member ${newNumber}`;
        container.appendChild(entry);
    });

    // Remove Family Member
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-family')) {
            const container = document.getElementById('family-container');
            const familyEntries = container.querySelectorAll('.family-entry');
            if (familyEntries.length > 1) {
                e.target.closest('.family-entry').remove();
                // Update headings
                container.querySelectorAll('.family-entry').forEach((entry, index) => {
                    entry.querySelector('h6').textContent = `Family Member ${index + 1}`;
                });
            }
        }
    });

    // Add Qualification
    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const entry = container.querySelector('.qualification-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(entry);
    });

    // Remove Qualification
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-qualification')) {
            e.target.closest('.qualification-entry').remove();
        }
    });

    // Add Experience
    document.getElementById('add-experience').addEventListener('click', function() {
        const container = document.getElementById('experience-container');
        const entry = container.querySelector('.experience-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(entry);
    });

    // Remove Experience
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-experience')) {
            e.target.closest('.experience-entry').remove();
        }
    });

    // Add Address
    document.getElementById('add-address').addEventListener('click', function() {
        const container = document.getElementById('addresses-container');
        const entry = container.querySelector('.address-entry').cloneNode(true);
        entry.querySelectorAll('input, select').forEach(input => input.value = '');
        container.appendChild(entry);
    });

    // Remove Address
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-address')) {
            e.target.closest('.address-entry').remove();
        }
    });

    // Add Document
    document.getElementById('add-document').addEventListener('click', function() {
        const container = document.getElementById('documents-container');
        const entry = container.querySelector('.document-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(entry);
    });

    // Remove Document
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-document')) {
            e.target.closest('.document-entry').remove();
        }
    });
});
</script>
@endsection
