@extends('layouts.admin')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')
@section('page-description', 'Complete information about ' . $employee->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card employee-detail-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Employee Information</h5>
                <div>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm glow-on-hover">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm glow-on-hover">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs custom-tabs" id="employeeDetailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-detail-tab" data-bs-toggle="tab" data-bs-target="#basic-detail" type="button" role="tab">
                            <i class="fas fa-user me-1"></i> Basic Info
                        </button>
                    </li>
                    @if($employee->familyDetails->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="family-detail-tab" data-bs-toggle="tab" data-bs-target="#family-detail" type="button" role="tab">
                            <i class="fas fa-users me-1"></i> Family
                        </button>
                    </li>
                    @endif
                    @if($employee->bank_name || $employee->account_number || $employee->ifsc_code || $employee->branch_name)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bank-detail-tab" data-bs-toggle="tab" data-bs-target="#bank-detail" type="button" role="tab">
                            <i class="fas fa-university me-1"></i> Bank
                        </button>
                    </li>
                    @endif
                    @if($employee->qualifications->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qualifications-detail-tab" data-bs-toggle="tab" data-bs-target="#qualifications-detail" type="button" role="tab">
                            <i class="fas fa-graduation-cap me-1"></i> Qualifications
                        </button>
                    </li>
                    @endif
                    @if($employee->experiences->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="experience-detail-tab" data-bs-toggle="tab" data-bs-target="#experience-detail" type="button" role="tab">
                            <i class="fas fa-briefcase me-1"></i> Experience
                        </button>
                    </li>
                    @endif
                    @if($employee->documents->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-detail-tab" data-bs-toggle="tab" data-bs-target="#documents-detail" type="button" role="tab">
                            <i class="fas fa-file me-1"></i> Documents
                        </button>
                    </li>
                    @endif
                    @if($employee->addresses->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="addresses-detail-tab" data-bs-toggle="tab" data-bs-target="#addresses-detail" type="button" role="tab">
                            <i class="fas fa-map-marker-alt me-1"></i> Addresses
                        </button>
                    </li>
                    @endif
                    @if($employee->basic_salary || $employee->hra || $employee->conveyance || $employee->medical)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payroll-detail-tab" data-bs-toggle="tab" data-bs-target="#payroll-detail" type="button" role="tab">
                            <i class="fas fa-money-bill-wave me-1"></i> Payroll
                        </button>
                    </li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-4" id="employeeDetailTabsContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3 text-center mb-4">
                                <div class="profile-image-container">
                                    @if($employee->profile_image)
                                        <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Profile Image" class="img-fluid rounded-circle profile-image animated-fade-in">
                                    @else
                                        <div class="profile-placeholder animated-fade-in">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="status-indicator bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}"></div>
                                </div>
                                <h4 class="mt-3 gradient-text">{{ $employee->name }}</h4>
                                <p class="text-muted">{{ $employee->position ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3 animated-fade-in-left">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Employee Code</strong>
                                                <p>{{ $employee->employee_code }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 animated-fade-in-right">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Email</strong>
                                                <p>{{ $employee->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 animated-fade-in-left">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Phone</strong>
                                                <p>{{ $employee->phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 animated-fade-in-right">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Hire Date</strong>
                                                <p>{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') : 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 animated-fade-in-left">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Department</strong>
                                                <p>{{ $employee->department ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 animated-fade-in-right">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-user-tag"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Status</strong>
                                                <p>
                                                    <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }} status-badge">
                                                        {{ ucfirst($employee->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Details Tab -->
                    @if($employee->familyDetails->count() > 0)
                    <div class="tab-pane fade" id="family-detail" role="tabpanel">
                        <div class="row">
                            @foreach($employee->familyDetails as $family)
                            <div class="col-md-6 mb-4">
                                <div class="family-card animated-card">
                                    <div class="card-header-family">
                                        <h6 class="mb-0">{{ ucfirst($family->relation ?? 'N/A') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <strong>Name:</strong> {{ $family->name ?? 'N/A' }}
                                            </div>
                                            <div class="col-12 mb-2">
                                                <strong>Contact Number:</strong> {{ $family->contact_number ?? 'N/A' }}
                                            </div>
                                            <div class="col-12 mb-2">
                                                <strong>Aadhar:</strong> {{ $family->aadhar ?? 'N/A' }}
                                            </div>
                                            <div class="col-12 mb-2">
                                                <strong>PAN:</strong> {{ $family->pan ?? 'N/A' }}
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex gap-2 mt-3">
                                                    @if($family->aadhar_file)
                                                        <a href="{{ asset('storage/' . $family->aadhar_file) }}" target="_blank" class="btn btn-sm btn-primary glow-on-hover">
                                                            <i class="fas fa-download me-1"></i> Aadhar
                                                        </a>
                                                    @endif
                                                    @if($family->pan_file)
                                                        <a href="{{ asset('storage/' . $family->pan_file) }}" target="_blank" class="btn btn-sm btn-primary glow-on-hover">
                                                            <i class="fas fa-download me-1"></i> PAN
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Bank Details Tab -->
                    @if($employee->bank_name || $employee->account_number || $employee->ifsc_code || $employee->branch_name)
                    <div class="tab-pane fade" id="bank-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-4 animated-fade-in-left">
                                <div class="info-card bank-card">
                                    <div class="info-icon bank-icon">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Bank Name</strong>
                                        <p>{{ $employee->bank_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 animated-fade-in-right">
                                <div class="info-card bank-card">
                                    <div class="info-icon bank-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Account Number</strong>
                                        <p>{{ $employee->account_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 animated-fade-in-left">
                                <div class="info-card bank-card">
                                    <div class="info-icon bank-icon">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>IFSC Code</strong>
                                        <p>{{ $employee->ifsc_code ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 animated-fade-in-right">
                                <div class="info-card bank-card">
                                    <div class="info-icon bank-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <strong>Branch Name</strong>
                                        <p>{{ $employee->branch_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Qualifications Tab -->
                    @if($employee->qualifications->count() > 0)
                    <div class="tab-pane fade" id="qualifications-detail" role="tabpanel">
                        <div class="row">
                            @foreach($employee->qualifications as $qualification)
                            <div class="col-md-6 mb-4">
                                <div class="qualification-card animated-card">
                                    <div class="card-header-qualification">
                                        <h6 class="mb-0">{{ $qualification->degree ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <strong>Institution:</strong> {{ $qualification->institution ?? 'N/A' }}
                                            </div>
                                            <div class="col-12 mb-2">
                                                <strong>Year of Passing:</strong> {{ $qualification->year_of_passing ?? 'N/A' }}
                                            </div>
                                            <div class="col-12">
                                                <strong>Grade/Percentage:</strong> {{ $qualification->grade ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Experience Tab -->
                    @if($employee->experiences->count() > 0)
                    <div class="tab-pane fade" id="experience-detail" role="tabpanel">
                        <div class="timeline">
                            @foreach($employee->experiences as $experience)
                            <div class="timeline-item animated-card">
                                <div class="timeline-point"></div>
                                <div class="timeline-content">
                                    <h6>{{ $experience->position ?? 'N/A' }}</h6>
                                    <p class="company-name">{{ $experience->company_name ?? 'N/A' }}</p>
                                    <p class="timeline-date">
                                        {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->format('M Y') : 'N/A' }} - 
                                        {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Present' }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Documents Tab -->
                    @if($employee->documents->count() > 0)
                    <div class="tab-pane fade" id="documents-detail" role="tabpanel">
                        <div class="row">
                            @foreach($employee->documents as $document)
                            <div class="col-md-4 mb-4">
                                <div class="document-card animated-card">
                                    <div class="document-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="document-details">
                                        <h6>{{ ucfirst($document->document_type ?? 'N/A') }}</h6>
                                        <small>Uploaded: {{ $document->created_at ? \Carbon\Carbon::parse($document->created_at)->format('d M Y') : 'N/A' }}</small>
                                    </div>
                                    <div class="document-actions">
                                        @if($document->file_path)
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-primary glow-on-hover">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Addresses Tab -->
                    @if($employee->addresses->count() > 0)
                    <div class="tab-pane fade" id="addresses-detail" role="tabpanel">
                        <div class="row">
                            @foreach($employee->addresses as $address)
                            <div class="col-md-6 mb-4">
                                <div class="address-card animated-card">
                                    <div class="card-header-address">
                                        <h6 class="mb-0">{{ ucfirst($address->address_type ?? 'N/A') }} Address</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="address-detail">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            <span>{{ $address->street_address ?? 'N/A' }}</span>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <strong>City:</strong> {{ $address->city ?? 'N/A' }}
                                            </div>
                                            <div class="col-6">
                                                <strong>State:</strong> {{ $address->state ?? 'N/A' }}
                                            </div>
                                            <div class="col-6 mt-2">
                                                <strong>Postal Code:</strong> {{ $address->postal_code ?? 'N/A' }}
                                            </div>
                                            <div class="col-6 mt-2">
                                                <strong>Country:</strong> {{ $address->country ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Payroll Tab -->
                    @if($employee->basic_salary || $employee->hra || $employee->conveyance || $employee->medical)
                    <div class="tab-pane fade" id="payroll-detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="salary-card animated-card">
                                    <div class="salary-breakdown">
                                        <div class="salary-item">
                                            <span class="salary-label">Basic Salary</span>
                                            <span class="salary-amount">₹{{ number_format($employee->basic_salary ?? 0, 2) }}</span>
                                        </div>
                                        <div class="salary-item">
                                            <span class="salary-label">HRA</span>
                                            <span class="salary-amount">₹{{ number_format($employee->hra ?? 0, 2) }}</span>
                                        </div>
                                        <div class="salary-item">
                                            <span class="salary-label">Conveyance Allowance</span>
                                            <span class="salary-amount">₹{{ number_format($employee->conveyance ?? 0, 2) }}</span>
                                        </div>
                                        <div class="salary-item">
                                            <span class="salary-label">Medical Allowance</span>
                                            <span class="salary-amount">₹{{ number_format($employee->medical ?? 0, 2) }}</span>
                                        </div>
                                        <div class="salary-divider"></div>
                                        <div class="salary-total">
                                            <span class="total-label">Total Salary</span>
                                            <span class="total-amount">₹{{ number_format(($employee->basic_salary ?? 0) + ($employee->hra ?? 0) + ($employee->conveyance ?? 0) + ($employee->medical ?? 0), 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for enhanced UI */
    .employee-detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .employee-detail-card .card-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .custom-tabs {
        border-bottom: 1px solid #eaeaea;
        padding: 0 1rem;
    }
    
    .custom-tabs .nav-link {
        border: none;
        padding: 1rem 1.5rem;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 0;
    }
    
    .custom-tabs .nav-link.active {
        color: #2575fc;
        background: transparent;
        border-bottom: 3px solid #2575fc;
    }
    
    .custom-tabs .nav-link:hover {
        color: #2575fc;
        background: rgba(37, 117, 252, 0.05);
    }
    
    .profile-image-container {
        position: relative;
        display: inline-block;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .profile-placeholder {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .status-indicator {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid #fff;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }
    
    .info-card {
        display: flex;
        align-items: center;
        padding: 1.2rem;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.2rem;
    }
    
    .bank-card .info-icon {
        background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);
    }
    
    .info-content strong {
        color: #495057;
        font-size: 0.9rem;
    }
    
    .info-content p {
        margin-bottom: 0;
        color: #212529;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
    }
    
    .family-card, .qualification-card, .address-card, .salary-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .family-card:hover, .qualification-card:hover, .address-card:hover, .salary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .card-header-family, .card-header-qualification, .card-header-address {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
    }
    
    .document-card {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }
    
    .document-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.5rem;
    }
    
    .document-details {
        flex-grow: 1;
    }
    
    .document-details h6 {
        margin-bottom: 0.2rem;
        color: #495057;
    }
    
    .document-details small {
        color: #6c757d;
    }
    
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }
    
    .timeline-point {
        position: absolute;
        left: -2rem;
        top: 0.5rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    
    .timeline-item:not(:last-child):before {
        content: '';
        position: absolute;
        left: -1.7rem;
        top: 2rem;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }
    
    .timeline-content h6 {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .company-name {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .timeline-date {
        color: #6a11cb;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .salary-breakdown {
        padding: 1.5rem;
    }
    
    .salary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px dashed #e9ecef;
    }
    
    .salary-label {
        color: #6c757d;
    }
    
    .salary-amount {
        color: #495057;
        font-weight: 500;
    }
    
    .salary-divider {
        margin: 1rem 0;
        border-bottom: 2px solid #e9ecef;
    }
    
    .salary-total {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
    }
    
    .total-label {
        color: #495057;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .total-amount {
        color: #6a11cb;
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    .address-detail {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        color: #495057;
    }
    
    .glow-on-hover {
        transition: all 0.3s ease;
    }
    
    .glow-on-hover:hover {
        box-shadow: 0 0 15px rgba(37, 117, 252, 0.5);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animated-fade-in {
        animation: fadeIn 0.6s ease forwards;
    }
    
    .animated-fade-in-left {
        animation: fadeInLeft 0.6s ease forwards;
    }
    
    .animated-fade-in-right {
        animation: fadeInRight 0.6s ease forwards;
    }
    
    .animated-card {
        opacity: 0;
        animation: fadeIn 0.6s ease forwards;
    }
    
    /* Delay animations for staggered effect */
    .animated-card:nth-child(1) { animation-delay: 0.1s; }
    .animated-card:nth-child(2) { animation-delay: 0.2s; }
    .animated-card:nth-child(3) { animation-delay: 0.3s; }
    .animated-card:nth-child(4) { animation-delay: 0.4s; }
    .animated-card:nth-child(5) { animation-delay: 0.5s; }
    .animated-card:nth-child(6) { animation-delay: 0.6s; }
    
    .timeline-item {
        opacity: 0;
        animation: fadeIn 0.6s ease forwards;
    }
    
    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }
    .timeline-item:nth-child(5) { animation-delay: 0.5s; }
</style>

<script>
    // Add tab switching animation
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
        
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(e) {
                const target = document.querySelector(e.target.getAttribute('data-bs-target'));
                const items = target.querySelectorAll('.animated-card, .animated-fade-in, .animated-fade-in-left, .animated-fade-in-right');
                
                items.forEach(item => {
                    item.style.opacity = '0';
                    void item.offsetWidth; // Trigger reflow
                    item.classList.add('animated-fade-in');
                });
            });
        });
    });
</script>
@endsection