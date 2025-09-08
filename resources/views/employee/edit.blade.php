@extends('layouts.admin')

@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee')
@section('page-description', 'Update employee record details')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Employee Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                    <ul class="nav nav-tabs" id="employeeEditTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-edit-tab" data-bs-toggle="tab" data-bs-target="#basic-edit" type="button" role="tab">Basic Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="family-edit-tab" data-bs-toggle="tab" data-bs-target="#family-edit" type="button" role="tab">Family Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bank-edit-tab" data-bs-toggle="tab" data-bs-target="#bank-edit" type="button" role="tab">Bank Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="qualifications-edit-tab" data-bs-toggle="tab" data-bs-target="#qualifications-edit" type="button" role="tab">Qualifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="experience-edit-tab" data-bs-toggle="tab" data-bs-target="#experience-edit" type="button" role="tab">Experience</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="addresses-edit-tab" data-bs-toggle="tab" data-bs-target="#addresses-edit" type="button" role="tab">Addresses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payroll-edit-tab" data-bs-toggle="tab" data-bs-target="#payroll-edit" type="button" role="tab">Payroll</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-edit-tab" data-bs-toggle="tab" data-bs-target="#documents-edit" type="button" role="tab">Documents</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-4" id="employeeEditTabsContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic-edit" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="employee_code" class="form-label">Employee Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('employee_code') is-invalid @enderror" id="employee_code" name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" required>
                                    @error('employee_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" required>
                                    @error('hire_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $employee->position) }}">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department', $employee->department) }}">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                    @if($employee->profile_image)
                                        <small class="form-text text-muted">Current image: <a href="{{ asset('storage/' . $employee->profile_image) }}" target="_blank">View</a></small>
                                    @endif
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    <small class="form-text text-muted">Leave blank to keep current password</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <!-- Family Details Tab -->
                        <div class="tab-pane fade" id="family-edit" role="tabpanel">
                            <div id="family-container">
                                @forelse($employee->familyDetails as $index => $family)
                                    <div class="family-entry mb-3 border p-3 rounded">
                                        <h6 class="mb-3">Family Member {{ $index + 1 }}</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Relation</label>
                                                <select class="form-select @error('relations.' . $index) is-invalid @enderror" name="relations[]">
                                                    <option value="">Select Relation</option>
                                                    <option value="father" {{ old('relations.' . $index, $family->relation) == 'father' ? 'selected' : '' }}>Father</option>
                                                    <option value="mother" {{ old('relations.' . $index, $family->relation) == 'mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="spouse" {{ old('relations.' . $index, $family->relation) == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                                    <option value="son" {{ old('relations.' . $index, $family->relation) == 'son' ? 'selected' : '' }}>Son</option>
                                                    <option value="daughter" {{ old('relations.' . $index, $family->relation) == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                                    <option value="brother" {{ old('relations.' . $index, $family->relation) == 'brother' ? 'selected' : '' }}>Brother</option>
                                                    <option value="sister" {{ old('relations.' . $index, $family->relation) == 'sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="emergency" {{ old('relations.' . $index, $family->relation) == 'emergency' ? 'selected' : '' }}>Emergency Contact</option>
                                                </select>
                                                @error('relations.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control @error('family_names.' . $index) is-invalid @enderror" name="family_names[]" value="{{ old('family_names.' . $index, $family->name) }}">
                                                @error('family_names.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control @error('contact_numbers.' . $index) is-invalid @enderror" name="contact_numbers[]" value="{{ old('contact_numbers.' . $index, $family->contact_number) }}">
                                                @error('contact_numbers.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Aadhar Number</label>
                                                <input type="text" class="form-control @error('aadhars.' . $index) is-invalid @enderror" name="aadhars[]" value="{{ old('aadhars.' . $index, $family->aadhar) }}">
                                                @error('aadhars.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-family">Remove</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">PAN Number</label>
                                                <input type="text" class="form-control @error('pans.' . $index) is-invalid @enderror" name="pans[]" value="{{ old('pans.' . $index, $family->pan) }}">
                                                @error('pans.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Aadhar File</label>
                                                <input type="file" class="form-control @error('aadhar_files.' . $index) is-invalid @enderror" name="aadhar_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                                @if($family->aadhar_file)
                                                    <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $family->aadhar_file) }}" target="_blank">View</a></small>
                                                @endif
                                                @error('aadhar_files.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">PAN File</label>
                                                <input type="file" class="form-control @error('pan_files.' . $index) is-invalid @enderror" name="pan_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                                @if($family->pan_file)
                                                    <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $family->pan_file) }}" target="_blank">View</a></small>
                                                @endif
                                                @error('pan_files.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="family-entry mb-3 border p-3 rounded">
                                        <h6 class="mb-3">Family Member 1</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Relation</label>
                                                <select class="form-select @error('relations.0') is-invalid @enderror" name="relations[]">
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
                                                @error('relations.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control @error('family_names.0') is-invalid @enderror" name="family_names[]" value="{{ old('family_names.0') }}">
                                                @error('family_names.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control @error('contact_numbers.0') is-invalid @enderror" name="contact_numbers[]" value="{{ old('contact_numbers.0') }}">
                                                @error('contact_numbers.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Aadhar Number</label>
                                                <input type="text" class="form-control @error('aadhars.0') is-invalid @enderror" name="aadhars[]" value="{{ old('aadhars.0') }}">
                                                @error('aadhars.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-family">Remove</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">PAN Number</label>
                                                <input type="text" class="form-control @error('pans.0') is-invalid @enderror" name="pans[]" value="{{ old('pans.0') }}">
                                                @error('pans.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Aadhar File</label>
                                                <input type="file" class="form-control @error('aadhar_files.0') is-invalid @enderror" name="aadhar_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                                @error('aadhar_files.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">PAN File</label>
                                                <input type="file" class="form-control @error('pan_files.0') is-invalid @enderror" name="pan_files[]" accept=".pdf,.jpg,.jpeg,.png">
                                                @error('pan_files.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-family">Add Family Member</button>
                        </div>

                        <!-- Bank Details Tab -->
                        <div class="tab-pane fade" id="bank-edit" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $employee->account_number) }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', $employee->ifsc_code) }}">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="branch_name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control @error('branch_name') is-invalid @enderror" id="branch_name" name="branch_name" value="{{ old('branch_name', $employee->branch_name) }}">
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Qualifications Tab -->
                        <div class="tab-pane fade" id="qualifications-edit" role="tabpanel">
                            <div id="qualifications-container">
                                @forelse($employee->qualifications as $index => $qualification)
                                    <div class="qualification-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Degree</label>
                                                <input type="text" class="form-control @error('degrees.' . $index) is-invalid @enderror" name="degrees[]" value="{{ old('degrees.' . $index, $qualification->degree) }}">
                                                @error('degrees.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Institution</label>
                                                <input type="text" class="form-control @error('institutions.' . $index) is-invalid @enderror" name="institutions[]" value="{{ old('institutions.' . $index, $qualification->institution) }}">
                                                @error('institutions.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Year of Passing</label>
                                                <input type="number" class="form-control @error('year_of_passings.' . $index) is-invalid @enderror" name="year_of_passings[]" value="{{ old('year_of_passings.' . $index, $qualification->year_of_passing) }}" min="1900" max="{{ date('Y') + 10 }}">
                                                @error('year_of_passings.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Grade/Percentage</label>
                                                <input type="text" class="form-control @error('grades.' . $index) is-invalid @enderror" name="grades[]" value="{{ old('grades.' . $index, $qualification->grade) }}">
                                                @error('grades.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-qualification">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="qualification-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Degree</label>
                                                <input type="text" class="form-control @error('degrees.0') is-invalid @enderror" name="degrees[]" value="{{ old('degrees.0') }}">
                                                @error('degrees.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Institution</label>
                                                <input type="text" class="form-control @error('institutions.0') is-invalid @enderror" name="institutions[]" value="{{ old('institutions.0') }}">
                                                @error('institutions.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Year of Passing</label>
                                                <input type="number" class="form-control @error('year_of_passings.0') is-invalid @enderror" name="year_of_passings[]" value="{{ old('year_of_passings.0') }}" min="1900" max="{{ date('Y') + 10 }}">
                                                @error('year_of_passings.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Grade/Percentage</label>
                                                <input type="text" class="form-control @error('grades.0') is-invalid @enderror" name="grades[]" value="{{ old('grades.0') }}">
                                                @error('grades.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-qualification">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-qualification">Add Qualification</button>
                        </div>

                        <!-- Experience Tab -->
                        <div class="tab-pane fade" id="experience-edit" role="tabpanel">
                            <div id="experience-container">
                                @forelse($employee->experiences as $index => $experience)
                                    <div class="experience-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control @error('company_names.' . $index) is-invalid @enderror" name="company_names[]" value="{{ old('company_names.' . $index, $experience->company_name) }}">
                                                @error('company_names.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control @error('positions.' . $index) is-invalid @enderror" name="positions[]" value="{{ old('positions.' . $index, $experience->position) }}">
                                                @error('positions.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control @error('start_dates.' . $index) is-invalid @enderror" name="start_dates[]" value="{{ old('start_dates.' . $index, $experience->start_date) }}">
                                                @error('start_dates.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control @error('end_dates.' . $index) is-invalid @enderror" name="end_dates[]" value="{{ old('end_dates.' . $index, $experience->end_date) }}">
                                                @error('end_dates.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-experience">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="experience-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control @error('company_names.0') is-invalid @enderror" name="company_names[]" value="{{ old('company_names.0') }}">
                                                @error('company_names.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control @error('positions.0') is-invalid @enderror" name="positions[]" value="{{ old('positions.0') }}">
                                                @error('positions.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control @error('start_dates.0') is-invalid @enderror" name="start_dates[]" value="{{ old('start_dates.0') }}">
                                                @error('start_dates.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control @error('end_dates.0') is-invalid @enderror" name="end_dates[]" value="{{ old('end_dates.0') }}">
                                                @error('end_dates.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-experience">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-experience">Add Experience</button>
                        </div>

                        <!-- Addresses Tab -->
                        <div class="tab-pane fade" id="addresses-edit" role="tabpanel">
                            <div id="addresses-container">
                                @forelse($employee->addresses as $index => $address)
                                    <div class="address-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Address Type</label>
                                                <select class="form-select @error('address_types.' . $index) is-invalid @enderror" name="address_types[]">
                                                    <option value="">Select Type</option>
                                                    <option value="permanent" {{ old('address_types.' . $index, $address->address_type) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                                    <option value="current" {{ old('address_types.' . $index, $address->address_type) == 'current' ? 'selected' : '' }}>Current</option>
                                                    <option value="office" {{ old('address_types.' . $index, $address->address_type) == 'office' ? 'selected' : '' }}>Office</option>
                                                </select>
                                                @error('address_types.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Street Address</label>
                                                <input type="text" class="form-control @error('street_addresses.' . $index) is-invalid @enderror" name="street_addresses[]" value="{{ old('street_addresses.' . $index, $address->street_address) }}">
                                                @error('street_addresses.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control @error('cities.' . $index) is-invalid @enderror" name="cities[]" value="{{ old('cities.' . $index, $address->city) }}">
                                                @error('cities.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control @error('states.' . $index) is-invalid @enderror" name="states[]" value="{{ old('states.' . $index, $address->state) }}">
                                                @error('states.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Postal Code</label>
                                                <input type="text" class="form-control @error('postal_codes.' . $index) is-invalid @enderror" name="postal_codes[]" value="{{ old('postal_codes.' . $index, $address->postal_code) }}">
                                                @error('postal_codes.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-address">Remove</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Country</label>
                                                <input type="text" class="form-control @error('countries.' . $index) is-invalid @enderror" name="countries[]" value="{{ old('countries.' . $index, $address->country) }}">
                                                @error('countries.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="address-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Address Type</label>
                                                <select class="form-select @error('address_types.0') is-invalid @enderror" name="address_types[]">
                                                    <option value="">Select Type</option>
                                                    <option value="permanent" {{ old('address_types.0') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                                    <option value="current" {{ old('address_types.0') == 'current' ? 'selected' : '' }}>Current</option>
                                                    <option value="office" {{ old('address_types.0') == 'office' ? 'selected' : '' }}>Office</option>
                                                </select>
                                                @error('address_types.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Street Address</label>
                                                <input type="text" class="form-control @error('street_addresses.0') is-invalid @enderror" name="street_addresses[]" value="{{ old('street_addresses.0') }}">
                                                @error('street_addresses.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control @error('cities.0') is-invalid @enderror" name="cities[]" value="{{ old('cities.0') }}">
                                                @error('cities.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control @error('states.0') is-invalid @enderror" name="states[]" value="{{ old('states.0') }}">
                                                @error('states.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <label class="form-label">Postal Code</label>
                                                <input type="text" class="form-control @error('postal_codes.0') is-invalid @enderror" name="postal_codes[]" value="{{ old('postal_codes.0') }}">
                                                @error('postal_codes.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-address">Remove</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Country</label>
                                                <input type="text" class="form-control @error('countries.0') is-invalid @enderror" name="countries[]" value="{{ old('countries.0') }}">
                                                @error('countries.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-address">Add Address</button>
                        </div>

                        <!-- Payroll Tab -->
                        <div class="tab-pane fade" id="payroll-edit" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="basic_salary" class="form-label">Basic Salary</label>
                                    <input type="number" step="0.01" class="form-control @error('basic_salary') is-invalid @enderror" id="basic_salary" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}">
                                    @error('basic_salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hra" class="form-label">HRA</label>
                                    <input type="number" step="0.01" class="form-control @error('hra') is-invalid @enderror" id="hra" name="hra" value="{{ old('hra', $employee->hra) }}">
                                    @error('hra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="conveyance" class="form-label">Conveyance Allowance</label>
                                    <input type="number" step="0.01" class="form-control @error('conveyance') is-invalid @enderror" id="conveyance" name="conveyance" value="{{ old('conveyance', $employee->conveyance) }}">
                                    @error('conveyance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="medical" class="form-label">Medical Allowance</label>
                                    <input type="number" step="0.01" class="form-control @error('medical') is-invalid @enderror" id="medical" name="medical" value="{{ old('medical', $employee->medical) }}">
                                    @error('medical')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documents Tab -->
                        <div class="tab-pane fade" id="documents-edit" role="tabpanel">
                            <div id="documents-container">
                                @forelse($employee->documents as $index => $document)
                                    <div class="document-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Document Type</label>
                                                <input type="text" class="form-control @error('document_types.' . $index) is-invalid @enderror" name="document_types[]" value="{{ old('document_types.' . $index, $document->document_type) }}">
                                                @error('document_types.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">File</label>
                                                <input type="file" class="form-control @error('document_files.' . $index) is-invalid @enderror" name="document_files[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                @if($document->file_path)
                                                    <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">View</a></small>
                                                @endif
                                                @error('document_files.' . $index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="document-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Document Type</label>
                                                <input type="text" class="form-control @error('document_types.0') is-invalid @enderror" name="document_types[]" value="{{ old('document_types.0') }}">
                                                @error('document_types.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">File</label>
                                                <input type="file" class="form-control @error('document_files.0') is-invalid @enderror" name="document_files[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                                @error('document_files.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-document">Add Document</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Employee
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
        entry.querySelectorAll('.invalid-feedback').forEach(error => error.remove());
        entry.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
        const headings = container.querySelectorAll('h6');
        const newHeadingNumber = headings.length + 1;
        entry.querySelector('h6').textContent = `Family Member ${newHeadingNumber}`;
        container.appendChild(entry);
    });

    // Remove Family Member
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-family')) {
            const container = document.getElementById('family-container');
            if (container.querySelectorAll('.family-entry').length > 1) {
                e.target.closest('.family-entry').remove();
                const headings = container.querySelectorAll('h6');
                headings.forEach((heading, index) => {
                    heading.textContent = `Family Member ${index + 1}`;
                });
            } else {
                alert('At least one family member entry is required.');
            }
        }
    });

    // Add Qualification
    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const entry = container.querySelector('.qualification-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        entry.querySelectorAll('.invalid-feedback').forEach(error => error.remove());
        entry.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
        container.appendChild(entry);
    });

    // Remove Qualification
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-qualification')) {
            const container = document.getElementById('qualifications-container');
            if (container.querySelectorAll('.qualification-entry').length > 1) {
                e.target.closest('.qualification-entry').remove();
            } else {
                alert('At least one qualification entry is required.');
            }
        }
    });

    // Add Experience
    document.getElementById('add-experience').addEventListener('click', function() {
        const container = document.getElementById('experience-container');
        const entry = container.querySelector('.experience-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        entry.querySelectorAll('.invalid-feedback').forEach(error => error.remove());
        entry.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
        container.appendChild(entry);
    });

    // Remove Experience
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-experience')) {
            const container = document.getElementById('experience-container');
            if (container.querySelectorAll('.experience-entry').length > 1) {
                e.target.closest('.experience-entry').remove();
            } else {
                alert('At least one experience entry is required.');
            }
        }
    });

    // Add Address
    document.getElementById('add-address').addEventListener('click', function() {
        const container = document.getElementById('addresses-container');
        const entry = container.querySelector('.address-entry').cloneNode(true);
        entry.querySelectorAll('input, select').forEach(input => input.value = '');
        entry.querySelectorAll('.invalid-feedback').forEach(error => error.remove());
        entry.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
        container.appendChild(entry);
    });

    // Remove Address
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-address')) {
            const container = document.getElementById('addresses-container');
            if (container.querySelectorAll('.address-entry').length > 1) {
                e.target.closest('.address-entry').remove();
            } else {
                alert('At least one address entry is required.');
            }
        }
    });

    // Add Document
    document.getElementById('add-document').addEventListener('click', function() {
        const container = document.getElementById('documents-container');
        const entry = container.querySelector('.document-entry').cloneNode(true);
        entry.querySelectorAll('input').forEach(input => input.value = '');
        entry.querySelectorAll('.invalid-feedback').forEach(error => error.remove());
        entry.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
        container.appendChild(entry);
    });

    // Remove Document
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-document')) {
            const container = document.getElementById('documents-container');
            if (container.querySelectorAll('.document-entry').length > 1) {
                e.target.closest('.document-entry').remove();
            } else {
                alert('At least one document entry is required.');
            }
        }
    });
});
</script>
@endsection