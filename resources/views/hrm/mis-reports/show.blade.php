@extends('layouts.admin')

@section('title', 'View HR MIS Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-eye mr-2"></i>View HR MIS Report
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Report Header -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Report Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Report Type:</strong> {{ ucfirst($report->report_type) }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Report Date:</strong>
                                            @if($report->report_type === 'daily')
                                                {{ $report->report_date ? $report->report_date->format('Y-m-d') : 'N/A' }}
                                            @elseif($report->report_type === 'weekly')
                                                {{ $report->week_start ? $report->week_start->format('Y-m-d') : 'N/A' }} to {{ $report->week_end ? $report->week_end->format('Y-m-d') : 'N/A' }}
                                            @else
                                                {{ $report->report_month ?? 'N/A' }}
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Department:</strong> {{ $report->department }}
                                        </div>
                                      
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <strong>Created By:</strong> {{ $report->createdBy ? $report->createdBy->name : 'N/A' }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Created At:</strong> {{ $report->created_at->format('Y-m-d H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Strength -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-success">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Employee Strength</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Total Employees</label>
                                                <p class="form-control-plaintext">{{ $report->total_employees ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">New Joiners</label>
                                                <p class="form-control-plaintext">{{ $report->new_joiners ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Resignations</label>
                                                <p class="form-control-plaintext">{{ $report->resignations ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Absconding</label>
                                                <p class="form-control-plaintext">{{ $report->absconding ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Terminated</label>
                                                <p class="form-control-plaintext">{{ $report->terminated ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Net Strength</label>
                                                <p class="form-control-plaintext">{{ $report->net_strength ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Summary -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-warning">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-clock mr-2"></i>Attendance Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Present Days</label>
                                                <p class="form-control-plaintext">{{ $report->present_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Absent Days</label>
                                                <p class="form-control-plaintext">{{ $report->absent_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Leaves Approved</label>
                                                <p class="form-control-plaintext">{{ $report->leaves_approved ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Half Days</label>
                                                <p class="form-control-plaintext">{{ $report->half_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Holiday Days</label>
                                                <p class="form-control-plaintext">{{ $report->holiday_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">NCNS Days</label>
                                                <p class="form-control-plaintext">{{ $report->ncns_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">LWP Days</label>
                                                <p class="form-control-plaintext">{{ $report->lwp_days ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recruitment Summary -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-user-plus mr-2"></i>Recruitment Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Requirements Raised</label>
                                                <p class="form-control-plaintext">{{ $report->requirements_raised ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Positions Closed</label>
                                                <p class="form-control-plaintext">{{ $report->positions_closed ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Positions Pending</label>
                                                <p class="form-control-plaintext">{{ $report->positions_pending ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Interviews Conducted</label>
                                                <p class="form-control-plaintext">{{ $report->interviews_conducted ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Selected</label>
                                                <p class="form-control-plaintext">{{ $report->selected ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Rejected</label>
                                                <p class="form-control-plaintext">{{ $report->rejected ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payroll & Compliance -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Payroll & Compliance</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Salary Processed</label>
                                                <p class="form-control-plaintext">{{ $report->salary_processed ? 'Yes' : 'No' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Salary Disbursed Date</label>
                                                <p class="form-control-plaintext">{{ $report->salary_disbursed_date ? $report->salary_disbursed_date->format('Y-m-d') : 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Deductions</label>
                                                <p class="form-control-plaintext">{{ $report->deductions ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Pending Compliance</label>
                                                <p class="form-control-plaintext">{{ $report->pending_compliance ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Relations -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-danger">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-handshake mr-2"></i>Employee Relations</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Grievances Received</label>
                                                <p class="form-control-plaintext">{{ $report->grievances_received ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Grievances Resolved</label>
                                                <p class="form-control-plaintext">{{ $report->grievances_resolved ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Warning Notices</label>
                                                <p class="form-control-plaintext">{{ $report->warning_notices ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Appreciations</label>
                                                <p class="form-control-plaintext">{{ $report->appreciations ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Training -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-graduation-cap mr-2"></i>Training</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Trainings Conducted</label>
                                                <p class="form-control-plaintext">{{ $report->trainings_conducted ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Employees Attended</label>
                                                <p class="form-control-plaintext">{{ $report->employees_attended ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Training Feedback</label>
                                                <p class="form-control-plaintext">{{ $report->training_feedback ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HR Activities -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-dark">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-calendar-check mr-2"></i>HR Activities</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"><B>Birthday Celebrations</B></label>
                                                <p class="form-control-plaintext">{{ $report->birthday_celebrations ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"> <B> Engagement Activities </B></label>
                                                <p class="form-control-plaintext">{{ $report->engagement_activities ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"><B>HR Initiatives</B></label>
                                                <p class="form-control-plaintext">{{ $report->hr_initiatives ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"><B>Special Events</B></label>
                                                <p class="form-control-plaintext">{{ $report->special_events ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes and Remarks -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-muted">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-sticky-note mr-2"></i>Notes & Remarks</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"><B>Notes</B></label>
                                                <p class="form-control-plaintext">{{ $report->notes ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold"><B>Remarks</B></label>
                                                <p class="form-control-plaintext">{{ $report->remarks ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('hr-mis-reports.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to List
                            </a>
                            <a href="{{ route('hr-mis-reports.edit', $report->id) }}" class="btn btn-warning mr-2">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <a href="{{ route('hr-mis-reports.download-pdf', $report->id) }}" class="btn btn-success" target="_blank">
                                <i class="fas fa-download mr-2"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
