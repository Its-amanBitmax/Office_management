@extends('layouts.admin')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')
@section('page-description', 'Complete information about ' . $employee->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Employee Information</h5>
                <div>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="employeeDetailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-detail-tab" data-bs-toggle="tab" data-bs-target="#basic-detail" type="button" role="tab">Basic Info</button>
                    </li>
                    @if($employee->familyDetails->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="family-detail-tab" data-bs-toggle="tab" data-bs-target="#family-detail" type="button" role="tab">Family Details</button>
                    </li>
                    @endif
                    @if($employee->bank_name || $employee->account_number || $employee->ifsc_code || $employee->branch_name)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bank-detail-tab" data-bs-toggle="tab" data-bs-target="#bank-detail" type="button" role="tab">Bank Details</button>
                    </li>
                    @endif
                    @if($employee->qualifications->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qualifications-detail-tab" data-bs-toggle="tab" data-bs-target="#qualifications-detail" type="button" role="tab">Qualifications</button>
                    </li>
                    @endif
                    @if($employee->experiences->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="experience-detail-tab" data-bs-toggle="tab" data-bs-target="#experience-detail" type="button" role="tab">Experience</button>
                    </li>
                    @endif
                    @if($employee->documents->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-detail-tab" data-bs-toggle="tab" data-bs-target="#documents-detail" type="button" role="tab">Documents</button>
                    </li>
                    @endif
                    @if($employee->addresses->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="addresses-detail-tab" data-bs-toggle="tab" data-bs-target="#addresses-detail" type="button" role="tab">Addresses</button>
                    </li>
                    @endif
                    @if($employee->basic_salary || $employee->hra || $employee->conveyance || $employee->medical)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payroll-detail-tab" data-bs-toggle="tab" data-bs-target="#payroll-detail" type="button" role="tab">Payroll</button>
                    </li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-4" id="employeeDetailTabsContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3 text-center mb-4">
                                @if($employee->profile_image)
                                    <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px; font-size: 3rem;">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Employee Code:</strong><br>
                                        {{ $employee->employee_code }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Full Name:</strong><br>
                                        {{ $employee->name }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Email:</strong><br>
                                        {{ $employee->email }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Phone:</strong><br>
                                        {{ $employee->phone ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Hire Date:</strong><br>
                                        {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') : 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Position:</strong><br>
                                        {{ $employee->position ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Department:</strong><br>
                                        {{ $employee->department ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>Status:</strong><br>
                                        <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($employee->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Details Tab -->
                    @if($employee->familyDetails->count() > 0)
                    <div class="tab-pane fade" id="family-detail" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Relation</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Aadhar File</th>
                                        <th>PAN File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->familyDetails as $family)
                                    <tr>
                                        <td>{{ ucfirst($family->relation ?? 'N/A') }}</td>
                                        <td>{{ $family->name ?? 'N/A' }}</td>
                                        <td>{{ $family->contact_number ?? 'N/A' }}</td>
                                        <td>{{ $family->aadhar ?? 'N/A' }}</td>
                                        <td>{{ $family->pan ?? 'N/A' }}</td>
                                        <td>
                                            @if($family->aadhar_file)
                                                <a href="{{ asset('storage/' . $family->aadhar_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($family->pan_file)
                                                <a href="{{ asset('storage/' . $family->pan_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Bank Details Tab -->
                    @if($employee->bank_name || $employee->account_number || $employee->ifsc_code || $employee->branch_name)
                    <div class="tab-pane fade" id="bank-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Bank Name:</strong><br>
                                {{ $employee->bank_name ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Account Number:</strong><br>
                                {{ $employee->account_number ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>IFSC Code:</strong><br>
                                {{ $employee->ifsc_code ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Branch Name:</strong><br>
                                {{ $employee->branch_name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Qualifications Tab -->
                    @if($employee->qualifications->count() > 0)
                    <div class="tab-pane fade" id="qualifications-detail" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Degree</th>
                                        <th>Institution</th>
                                        <th>Year of Passing</th>
                                        <th>Grade/Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->qualifications as $qualification)
                                    <tr>
                                        <td>{{ $qualification->degree ?? 'N/A' }}</td>
                                        <td>{{ $qualification->institution ?? 'N/A' }}</td>
                                        <td>{{ $qualification->year_of_passing ?? 'N/A' }}</td>
                                        <td>{{ $qualification->grade ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Experience Tab -->
                    @if($employee->experiences->count() > 0)
                    <div class="tab-pane fade" id="experience-detail" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Position</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->experiences as $experience)
                                    <tr>
                                        <td>{{ $experience->company_name ?? 'N/A' }}</td>
                                        <td>{{ $experience->position ?? 'N/A' }}</td>
                                        <td>{{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->format('d M Y') : 'N/A' }}</td>
                                        <td>{{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('d M Y') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Documents Tab -->
                    @if($employee->documents->count() > 0)
                    <div class="tab-pane fade" id="documents-detail" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File</th>
                                        <th>Uploaded At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->documents as $document)
                                    <tr>
                                        <td>{{ ucfirst($document->document_type ?? 'N/A') }}</td>
                                        <td>
                                            @if($document->file_path)
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $document->created_at ? \Carbon\Carbon::parse($document->created_at)->format('d M Y') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Addresses Tab -->
                    @if($employee->addresses->count() > 0)
                    <div class="tab-pane fade" id="addresses-detail" role="tabpanel">
                        @foreach($employee->addresses as $address)
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong>{{ ucfirst($address->address_type ?? 'N/A') }} Address</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <strong>Street Address:</strong><br>
                                        {{ $address->street_address ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>City:</strong><br>
                                        {{ $address->city ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>State:</strong><br>
                                        {{ $address->state ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Postal Code:</strong><br>
                                        {{ $address->postal_code ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Country:</strong><br>
                                        {{ $address->country ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Payroll Tab -->
                    @if($employee->basic_salary || $employee->hra || $employee->conveyance || $employee->medical)
                    <div class="tab-pane fade" id="payroll-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Basic Salary:</strong><br>
                                ₹{{ number_format($employee->basic_salary ?? 0, 2) }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>HRA:</strong><br>
                                ₹{{ number_format($employee->hra ?? 0, 2) }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Conveyance Allowance:</strong><br>
                                ₹{{ number_format($employee->conveyance ?? 0, 2) }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Medical Allowance:</strong><br>
                                ₹{{ number_format($employee->medical ?? 0, 2) }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Total Salary:</strong><br>
                                ₹{{ number_format(($employee->basic_salary ?? 0) + ($employee->hra ?? 0) + ($employee->conveyance ?? 0) + ($employee->medical ?? 0), 2) }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection