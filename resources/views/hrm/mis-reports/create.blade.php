@extends('layouts.admin')

@section('title', 'Create HR MIS Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-plus-circle mr-2"></i>Create HR MIS Report
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hr-mis-reports.store') }}" method="POST" id="misReportForm">
                        @csrf

                        <!-- Report Type and Basic Info -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border-info">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-calendar-alt mr-2"></i>Report Configuration</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="report_type" class="font-weight-bold">Report Type <span class="text-danger">*</span></label>
                                                    <select name="report_type" id="report_type" class="form-control form-control-lg" required>
                                                        <option value="daily">📅 Daily Report</option>
                                                        <option value="weekly">📊 Weekly Report</option>
                                                        <option value="monthly">📈 Monthly Report</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="daily_fields">
                                                <div class="form-group">
                                                    <label for="report_date" class="font-weight-bold">Report Date</label>
                                                    <input type="date" name="report_date" id="report_date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="department" class="font-weight-bold">Department</label>
                                                    <input type="text" name="department" id="department" class="form-control form-control-lg" value="Human Resources" placeholder="Enter department name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="weekly_fields" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="week_start" class="font-weight-bold">Week Start Date</label>
                                                    <input type="date" name="week_start" id="week_start" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="week_end" class="font-weight-bold">Week End Date</label>
                                                    <input type="date" name="week_end" id="week_end" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="monthly_fields" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="report_month" class="font-weight-bold">Report Month</label>
                                                    <input type="month" name="report_month" id="report_month" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="center_branch" class="font-weight-bold">Center/Branch</label>
                                                    <input type="text" name="center_branch" id="center_branch" class="form-control form-control-lg" placeholder="Enter center/branch name">
                                                </div>
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
                                                    <label for="total_employees" class="font-weight-bold">Total Employees</label>
                                                    <input type="number" name="total_employees" id="total_employees" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['total_employees'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="new_joiners" class="font-weight-bold">New Joiners</label>
                                                    <input type="number" name="new_joiners" id="new_joiners" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['new_joiners'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="resignations" class="font-weight-bold">Resignations</label>
                                                    <input type="number" name="resignations" id="resignations" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['resignations'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="terminated" class="font-weight-bold">Terminated</label>
                                                    <input type="number" name="terminated" id="terminated" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['terminated'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="net_strength" class="font-weight-bold">Net Strength</label>
                                                    <input type="number" name="net_strength" id="net_strength" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['net_strength'] ?? 0 }}" readonly>
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
                                                    <label for="present_days" class="font-weight-bold">Present Days</label>
                                                    <input type="number" name="present_days" id="present_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['present_days'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="absent_days" class="font-weight-bold">Absent Days</label>
                                                    <input type="number" name="absent_days" id="absent_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['absent_days'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="leaves_approved" class="font-weight-bold">Leaves Approved</label>
                                                    <input type="number" name="leaves_approved" id="leaves_approved" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['leaves_approved'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="half_days" class="font-weight-bold">Half Days</label>
                                                    <input type="number" name="half_days" id="half_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['half_days'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="holiday_days" class="font-weight-bold">Holiday Days</label>
                                                    <input type="number" name="holiday_days" id="holiday_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['holiday_days'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="ncns_days" class="font-weight-bold">NCNS Days</label>
                                                    <input type="number" name="ncns_days" id="ncns_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['ncns_days'] ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="lwp_days" class="font-weight-bold">LWP Days</label>
                                                    <input type="number" name="lwp_days" id="lwp_days" class="form-control form-control-lg" min="0" value="{{ $autoFilledData['lwp_days'] ?? 0 }}" readonly>
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
                                                    <label for="requirements_raised" class="font-weight-bold">Requirements Raised</label>
                                                    <input type="number" name="requirements_raised" id="requirements_raised" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="positions_closed" class="font-weight-bold">Positions Closed</label>
                                                    <input type="number" name="positions_closed" id="positions_closed" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="positions_pending" class="font-weight-bold">Positions Pending</label>
                                                    <input type="number" name="positions_pending" id="positions_pending" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="interviews_conducted" class="font-weight-bold">Interviews Conducted</label>
                                                    <input type="number" name="interviews_conducted" id="interviews_conducted" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selected" class="font-weight-bold">Selected</label>
                                                    <input type="number" name="selected" id="selected" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rejected" class="font-weight-bold">Rejected</label>
                                                    <input type="number" name="rejected" id="rejected" class="form-control form-control-lg" min="0" value="0">
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
                                                    <label for="salary_processed" class="font-weight-bold">Salary Processed</label>
                                                    <select name="salary_processed" id="salary_processed" class="form-control form-control-lg">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="salary_disbursed_date" class="font-weight-bold">Salary Disbursed Date</label>
                                                    <input type="date" name="salary_disbursed_date" id="salary_disbursed_date" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="deductions" class="font-weight-bold">Deductions</label>
                                                    <textarea name="deductions" id="deductions" class="form-control form-control-lg" rows="2" placeholder="Enter deductions details"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pending_compliance" class="font-weight-bold">Pending Compliance</label>
                                                    <textarea name="pending_compliance" id="pending_compliance" class="form-control form-control-lg" rows="2" placeholder="Enter pending compliance details"></textarea>
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
                                                    <label for="grievances_received" class="font-weight-bold">Grievances Received</label>
                                                    <input type="number" name="grievances_received" id="grievances_received" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="grievances_resolved" class="font-weight-bold">Grievances Resolved</label>
                                                    <input type="number" name="grievances_resolved" id="grievances_resolved" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="warning_notices" class="font-weight-bold">Warning Notices</label>
                                                    <input type="number" name="warning_notices" id="warning_notices" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="appreciations" class="font-weight-bold">Appreciations</label>
                                                    <input type="number" name="appreciations" id="appreciations" class="form-control form-control-lg" min="0" value="0">
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
                                                    <label for="trainings_conducted" class="font-weight-bold">Trainings Conducted</label>
                                                    <input type="number" name="trainings_conducted" id="trainings_conducted" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="employees_attended" class="font-weight-bold">Employees Attended</label>
                                                    <input type="number" name="employees_attended" id="employees_attended" class="form-control form-control-lg" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="training_feedback" class="font-weight-bold">Training Feedback</label>
                                                    <textarea name="training_feedback" id="training_feedback" class="form-control form-control-lg" rows="2" placeholder="Enter training feedback"></textarea>
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
                                                    <label for="birthday_celebrations" class="font-weight-bold">Birthday Celebrations</label>
                                                    <textarea name="birthday_celebrations" id="birthday_celebrations" class="form-control form-control-lg" rows="2" placeholder="Enter birthday celebrations details"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="engagement_activities" class="font-weight-bold">Engagement Activities</label>
                                                    <textarea name="engagement_activities" id="engagement_activities" class="form-control form-control-lg" rows="2" placeholder="Enter engagement activities details"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="hr_initiatives" class="font-weight-bold">HR Initiatives</label>
                                                    <textarea name="hr_initiatives" id="hr_initiatives" class="form-control form-control-lg" rows="2" placeholder="Enter HR initiatives details"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="special_events" class="font-weight-bold">Special Events</label>
                                                    <textarea name="special_events" id="special_events" class="form-control form-control-lg" rows="2" placeholder="Enter special events details"></textarea>
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
                                                    <label for="notes" class="font-weight-bold">Notes</label>
                                                    <textarea name="notes" id="notes" class="form-control form-control-lg" rows="3" placeholder="Enter additional notes"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="remarks" class="font-weight-bold">Remarks</label>
                                                    <textarea name="remarks" id="remarks" class="form-control form-control-lg" rows="3" placeholder="Enter remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save mr-2"></i>Create HR MIS Report
                                </button>
                                <a href="{{ route('hr-mis-reports.index') }}" class="btn btn-secondary btn-lg ml-3">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.getElementById('report_type');
    const dailyFields = document.getElementById('daily_fields');
    const weeklyFields = document.getElementById('weekly_fields');
    const monthlyFields = document.getElementById('monthly_fields');

    function toggleFields() {
        const selectedType = reportTypeSelect.value;

        // Hide all fields first
        dailyFields.style.display = 'none';
        weeklyFields.style.display = 'none';
        monthlyFields.style.display = 'none';

        // Show relevant fields based on selection
        if (selectedType === 'daily') {
            dailyFields.style.display = 'block';
        } else if (selectedType === 'weekly') {
            weeklyFields.style.display = 'block';
        } else if (selectedType === 'monthly') {
            monthlyFields.style.display = 'block';
        }
    }

    // Initial toggle
    toggleFields();

    // Add event listener
    reportTypeSelect.addEventListener('change', toggleFields);
});
</script>

@endsection
