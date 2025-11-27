@extends('layouts.employee')

@section('title', 'Dashboard')

@section('page-title', 'Employee Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="welcome-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 0.5rem;">Welcome back, {{ auth('employee')->user()->name ?? 'Employee' }}!👤</h3>
            <p style="margin: 0; opacity: 0.9;">Here's an overview of your employee dashboard. You can view your profile, tasks, and other important information here.</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #007bff; text-align: center;">
            <i class="fas fa-id-card fa-2x text-primary mb-3"></i>
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">Employee Code</h4>
            <p style="font-size: 1.5rem; font-weight: bold; color: #007bff; margin: 0;">{{ auth('employee')->user()->employee_code ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745; text-align: center;">
            <i class="fas fa-envelope fa-2x text-success mb-3"></i>
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">Email Address</h4>
            <p style="font-size: 1.2rem; font-weight: bold; color: #28a745; margin: 0; word-break: break-all;">{{ auth('employee')->user()->email ?? 'N/A' }}</p>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #ffc107; text-align: center;">
            <i class="fas fa-phone fa-2x text-warning mb-3"></i>
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">Phone Number</h4>
            <p style="font-size: 1.5rem; font-weight: bold; color: #ffc107; margin: 0;">{{ auth('employee')->user()->phone ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8; text-align: center;">
            <i class="fas fa-building fa-2x text-info mb-3"></i>
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">Department</h4>
            <p style="font-size: 1.5rem; font-weight: bold; color: #17a2b8; margin: 0;">{{ auth('employee')->user()->department ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('employee.profile') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-user me-2"></i>View Profile
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('employee.tasks') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-tasks me-2"></i>My Tasks
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button type="button" class="btn btn-outline-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#idCardModal">
                            <i class="fas fa-id-card me-2"></i>View ID Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ID Card Modal -->
<div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="idCardModalLabel">Employee ID Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $employee = auth('employee')->user();
                @endphp
                <div class="card-wrapper"
                     style="width:360px;height:550px;border-radius:10px;overflow:hidden;
                            box-shadow:0 6px 18px rgba(0,0,0,0.15);display:block;margin:0 auto;position:relative;
                            background-image: url('{{ asset('images/idcard-bg.png') }}');
                            background-size: cover; background-repeat: no-repeat; background-position: -10px;">

                    {{-- Top header --}}
                    <div style="background:#1d67a3;color:#fff;padding:10px 12px;display:flex;flex-direction:column;align-items:center;text-align:center;">
                        <div style="font-weight:700;font-size:18px;letter-spacing:1px;line-height:13px;">
                            {{ config('app.company_name','BITMAX TECHNOLOGY PVT LTD') }}
                        </div>
                        <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                            {{ config('app.company_address','Bhutani Alphathum Tower C, Unit-1034, Floor 10th, Noida - 201304') }}
                        </div>
                        <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                            IVR: {{ config('app.company_ivr','924234234234234') }}
                        </div>
                        <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                            E: {{ config('app.company_email','info@bitmaxtechnology.com') }}
                        </div>
                        <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                            W: {{ config('app.company_website','www.bitmaxgroup.com') }}
                        </div>
                    </div>

                    {{-- Photo + Name + Logo row --}}
                    <div style="display:flex;padding:16px 18px 10px 18px;">
                        <div style="width:300px;text-align:center;">
                            <div style="font-size:14px;font-weight:bold;color:#1d67a3;margin-bottom:5px;margin-left:35px;">IDENTITY CARD</div>
                            <div style="display:flex;flex-direction:row;align-items:center;justify-content:center;gap:10px;">
                                <div style="font-size:18px;font-weight:bold;color:#111;writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);white-space:nowrap;">
                                    {{ $employee->validity ?? '2024-2026' }}
                                </div>
                                <div style="width:150px;height:180px;border:2px solid #111;background:#eee;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                    <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Photo"
                                         style="width:100%;height:100%;object-fit:cover;display:block;" />
                                </div>

                            </div>
                            <div style="background-color:rgb(209,209,209);margin-top:3px;margin-left:35px; padding:2px 10px;border-radius:5px;">
                                <div style="margin-top:10px;font-weight:800;font-size:16px;color:#111;">
                                    {{ strtoupper($employee->name) }}
                                </div>
                                <div style="font-size:10px;font-weight:600;color:#444;margin-top:2px;">
                                    {{ strtoupper($employee->position) }}
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:center;">

                                <img src="https://www.bitmaxgroup.com/assets/logo/logo.png" alt="Logo"
                                     style="width:120px;height:auto;object-fit:contain" />

                        </div>
                    </div>

                    {{-- Info block --}}
                    <div style="padding:8px 20px 20px 150px;display:block;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                            <div style="font-size:10px;font-weight:900;color:#333;">ECN NO</div>
                            <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->employee_code }}</div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                            <div style="font-size:10px;font-weight:900;color:#333;">EMAIL</div>
                            <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->email ?? 'N/A' }}</div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                            <div style="font-size:10px;font-weight:900;color:#333;">DOB</div>
                            <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->dob ? $employee->dob->format('Y-m-d') : 'N/A' }}</div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                            <div style="font-size:10px;font-weight:900;color:#333;">MOBILE</div>
                            <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->phone }}</div>
                        </div>
                    </div>

                    {{-- Bottom watermark --}}
                    <div style="position:absolute;right:10px;bottom:0px;width:100%;padding:6px 14px;display:flex;justify-content:flex-end;align-items:center;opacity:0.2;">
                        <img src="https://www.bitmaxgroup.com/assets/logo/logo.png" alt="Logo"
                             style="width:180px;height:auto;object-fit:contain" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('employee.card.pdf') }}" class="btn btn-primary">Download PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection
