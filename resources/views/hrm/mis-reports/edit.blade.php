@extends('layouts.admin')

@section('title', 'Edit HR MIS Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>Edit HR MIS Report
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('hr-mis-reports.update', $report->id) }}" method="POST" id="misReportForm">
                        @csrf
                        @method('PUT')

                        {{-- ================= Report Configuration ================= --}}
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border-info">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-calendar-alt mr-2"></i>Report Configuration
                                        </h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="font-weight-bold">
                                                    Report Type <span class="text-danger">*</span>
                                                </label>
                                                <select name="report_type" id="report_type"
                                                        class="form-control form-control-lg" required>
                                                    <option value="daily"   {{ $report->report_type=='daily' ? 'selected' : '' }}>Daily</option>
                                                    <option value="weekly"  {{ $report->report_type=='weekly' ? 'selected' : '' }}>Weekly</option>
                                                    <option value="monthly" {{ $report->report_type=='monthly' ? 'selected' : '' }}>Monthly</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4" id="daily_fields">
                                                <label class="font-weight-bold">Report Date</label>
                                                <input type="date" name="report_date"
                                                       class="form-control form-control-lg"
                                                       value="{{ optional($report->report_date)->format('Y-m-d') }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="font-weight-bold">Department</label>
                                                <input type="text" name="department"
                                                       class="form-control form-control-lg"
                                                       value="{{ $report->department }}">
                                            </div>
                                        </div>

                                        <div class="row mt-3" id="weekly_fields" style="display:none;">
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Week Start</label>
                                                <input type="date" name="week_start"
                                                       class="form-control form-control-lg"
                                                       value="{{ optional($report->week_start)->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Week End</label>
                                                <input type="date" name="week_end"
                                                       class="form-control form-control-lg"
                                                       value="{{ optional($report->week_end)->format('Y-m-d') }}">
                                            </div>
                                        </div>

                                        <div class="row mt-3" id="monthly_fields" style="display:none;">
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Report Month</label>
                                                <input type="month" name="report_month"
                                                       class="form-control form-control-lg"
                                                       value="{{ $report->report_month }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Center / Branch</label>
                                                <input type="text" name="center_branch"
                                                       class="form-control form-control-lg"
                                                       value="{{ $report->center_branch }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= Employee Strength ================= --}}
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-light">
                                <h5><i class="fas fa-users mr-2"></i>Employee Strength</h5>
                            </div>
                            <div class="card-body row">
                                @foreach([
                                    'total_employees'=>'Total Employees',
                                    'new_joiners'=>'New Joiners',
                                    'resignations'=>'Resignations',
                                    'terminated'=>'Terminated',
                                    'net_strength'=>'Net Strength'
                                ] as $f => $l)
                                    <div class="col-md-3">
                                        <label class="font-weight-bold">{{ $l }}</label>
                                        <input type="number" class="form-control form-control-lg"
                                               value="{{ $report->$f }}" readonly>
                                        <input type="hidden" name="{{ $f }}" value="{{ $report->$f }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ================= Attendance ================= --}}
                        <div class="card mb-4 border-warning">
                            <div class="card-header bg-light">
                                <h5><i class="fas fa-clock mr-2"></i>Attendance Summary</h5>
                            </div>
                            <div class="card-body row">
                                @foreach([
                                    'present_days'=>'Present Days',
                                    'absent_days'=>'Absent Days',
                                    'leaves_approved'=>'Leaves Approved',
                                    'half_days'=>'Half Days',
                                    'holiday_days'=>'Holiday Days',
                                    'ncns_days'=>'NCNS Days',
                                    'lwp_days'=>'LWP Days'
                                ] as $f => $l)
                                    <div class="col-md-3">
                                        <label class="font-weight-bold">{{ $l }}</label>
                                        <input type="number" name="{{ $f }}"
                                               class="form-control form-control-lg"
                                               value="{{ $report->$f }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ================= Recruitment ================= --}}
                        <div class="card mb-4 border-info">
                            <div class="card-header bg-light">
                                <h5><i class="fas fa-user-plus mr-2"></i>Recruitment Summary</h5>
                            </div>
                            <div class="card-body row">
                                @foreach([
                                    'requirements_raised'=>'Requirements Raised',
                                    'positions_closed'=>'Positions Closed',
                                    'positions_pending'=>'Positions Pending',
                                    'interviews_conducted'=>'Interviews Conducted',
                                    'selected'=>'Selected',
                                    'rejected'=>'Rejected'
                                ] as $f => $l)
                                    <div class="col-md-3">
                                        <label class="font-weight-bold">{{ $l }}</label>
                                        <input type="number" name="{{ $f }}"
                                               class="form-control form-control-lg"
                                               value="{{ $report->$f }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ================= Payroll ================= --}}
                        <div class="card mb-4 border-secondary">
                            <div class="card-header bg-light">
                                <h5><i class="fas fa-money-bill mr-2"></i>Payroll & Compliance</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="font-weight-bold">Salary Processed</label>
                                        <select name="salary_processed" class="form-control form-control-lg">
                                            <option value="0" {{ !$report->salary_processed ? 'selected':'' }}>No</option>
                                            <option value="1" {{ $report->salary_processed ? 'selected':'' }}>Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="font-weight-bold">Salary Disbursed Date</label>
                                        <input type="date" name="salary_disbursed_date"
                                               class="form-control form-control-lg"
                                               value="{{ optional($report->salary_disbursed_date)->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="font-weight-bold">Deductions</label>
                                    <textarea name="deductions" class="form-control">{{ $report->deductions }}</textarea>
                                </div>

                                <div class="mt-3">
                                    <label class="font-weight-bold">Pending Compliance</label>
                                    <textarea name="pending_compliance" class="form-control">{{ $report->pending_compliance }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- ================= HR Activities ================= --}}
                        <div class="card mb-4 border-dark">
                            <div class="card-header bg-light">
                                <h5><i class="fas fa-calendar-check mr-2"></i>HR Activities</h5>
                            </div>
                            <div class="card-body">
                                @foreach([
                                    'birthday_celebrations'=>'Birthday Celebrations',
                                    'engagement_activities'=>'Engagement Activities',
                                    'hr_initiatives'=>'HR Initiatives',
                                    'special_events'=>'Special Events',
                                    'notes'=>'Notes',
                                    'remarks'=>'Remarks'
                                ] as $f => $l)
                                    <label class="font-weight-bold">{{ $l }}</label>
                                    <textarea name="{{ $f }}" class="form-control mb-3">{{ $report->$f }}</textarea>
                                @endforeach
                            </div>
                        </div>

                        {{-- ================= Submit ================= --}}
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save mr-2"></i>Update Report
                            </button>
                            <a href="{{ route('hr-mis-reports.index') }}"
                               class="btn btn-secondary btn-lg ml-3">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= Toggle Script ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('report_type');
    const daily = document.getElementById('daily_fields');
    const weekly = document.getElementById('weekly_fields');
    const monthly = document.getElementById('monthly_fields');

    function toggle() {
        daily.style.display = type.value === 'daily' ? 'block':'none';
        weekly.style.display = type.value === 'weekly' ? 'flex':'none';
        monthly.style.display = type.value === 'monthly' ? 'flex':'none';
    }
    toggle();
    type.addEventListener('change', toggle);
});
</script>
@endsection
