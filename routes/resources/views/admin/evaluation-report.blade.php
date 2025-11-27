@extends('layouts.admin')

@section('page-title', 'Evaluation Report')
@section('page-description', 'Comprehensive evaluation report for employees')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Evaluation Report Slots</h5>
                            @if(Auth::guard('admin')->user()->role === 'super_admin')
                                <button type="button" class="btn btn-primary btn-sm" onclick="openAssignmentsModal()">
                                    <i class="fas fa-users-cog"></i> Manage Assignments
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <!-- Month Selector and Employee Selector -->
                            <form method="GET" action="{{ route('admin.evaluation-report') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="month">Select Month</label>
                                        <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                                            @foreach($monthOptions as $value => $label)
                                                <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <!-- Report Slots -->
                            <div class="row">
                                <!-- Weekly Cards -->
                                @foreach($weeks as $week)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="card-title mb-0">{{ $week['title'] }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-3">Review Period: {{ \Carbon\Carbon::parse($week['start_date'])->format('M d, Y') }} - {{ \Carbon\Carbon::parse($week['end_date'])->format('M d, Y') }}</p>
                                                @php
                                                    $weekKey = $week['start_date'] . '-' . $week['end_date'];
                                                @endphp
                                                @if(isset($existingReports[$weekKey]))
                                                    <div class="existing-reports">
                                                        <strong>Existing Reports:</strong>
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($existingReports[$weekKey] as $report)
                                                                <li class="d-flex align-items-center justify-content-between mb-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="fas fa-user-circle mr-2 text-primary"></i>
                                                                        {{ $report->employee->name ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="action-icons">
                                                                        <a href="{{ route('admin.show-evaluation-report', $report->id) }}" class="btn btn-sm btn-outline-info mr-1" title="View">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('admin.edit-evaluation-report', $report->id) }}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteReport({{ $report->id }}, '{{ $report->employee->name ?? 'N/A' }}')" title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                @if(Auth::guard('admin')->user()->role === 'super_admin' || (Auth::guard('admin')->user()->role === 'sub_admin' && Auth::guard('admin')->user()->hasPermission('evaluation-report')))
                                                    <a href="{{ route('admin.add-evaluation-report', ['review_from' => $week['start_date'], 'review_to' => $week['end_date']]) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus"></i> Add Report
                                                    </a>
                                                @else
                                                    <span class="text-muted small">No permission to add reports</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Monthly Card -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="card-title mb-0">{{ $monthCard['title'] }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-3">Full Month Review: {{ \Carbon\Carbon::parse($monthCard['start_date'])->format('M d, Y') }} - {{ \Carbon\Carbon::parse($monthCard['end_date'])->format('M d, Y') }}</p>
                                            @php
                                                $monthKey = $monthCard['start_date'] . '-' . $monthCard['end_date'];
                                            @endphp
                                            @if(isset($existingReports[$monthKey]))
                                                <div class="existing-reports">
                                                    <strong>Existing Reports:</strong>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($existingReports[$monthKey] as $report)
                                                            <li class="d-flex align-items-center justify-content-between mb-1">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-user-circle mr-2 text-primary"></i>
                                                                    {{ $report->employee->name ?? 'N/A' }}
                                                                </div>
                                                                <div class="action-icons">
                                                                    <a href="{{ route('admin.show-evaluation-report', $report->id) }}" class="btn btn-sm btn-outline-info mr-1" title="View">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.edit-evaluation-report', $report->id) }}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteReport({{ $report->id }}, '{{ $report->employee->name ?? 'N/A' }}')" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            @if(Auth::guard('admin')->user()->role === 'super_admin' || (Auth::guard('admin')->user()->role === 'sub_admin' && Auth::guard('admin')->user()->hasPermission('evaluation-report')))
                                                <a href="{{ route('admin.add-evaluation-report', ['review_from' => $monthCard['start_date'], 'review_to' => $monthCard['end_date']]) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Add Report
                                                </a>
                                            @else
                                                <span class="text-muted small">No permission to add reports</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manage Assignments Modal -->
<div id="manageAssignmentsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Manage Evaluation Assignments</h3>
            <button class="modal-close" onclick="closeAssignmentsModal()">&times;</button>
        </div>
        <form action="{{ route('admin.update-evaluation-assignments') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Step 1: Manager Evaluation</h6>
                        <p class="text-muted small">Select sub-admins who can perform manager evaluations</p>
                        <select name="step1_admins[]" class="form-control" multiple style="height: 200px;">
                            @foreach($subAdmins as $admin)
                                <option value="{{ $admin->id }}" {{ $step1Assignments && in_array($admin->id, $step1Assignments->assigned_admins ?? []) ? 'selected' : '' }}>
                                    {{ $admin->name }} ({{ $admin->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h6>Step 2: HR Evaluation</h6>
                        <p class="text-muted small">Select sub-admins who can perform HR evaluations</p>
                        <select name="step2_admins[]" class="form-control" multiple style="height: 200px;">
                            @foreach($subAdmins as $admin)
                                <option value="{{ $admin->id }}" {{ $step2Assignments && in_array($admin->id, $step2Assignments->assigned_admins ?? []) ? 'selected' : '' }}>
                                    {{ $admin->name }} ({{ $admin->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> Hold Ctrl (or Cmd on Mac) to select multiple admins. Changes will be saved immediately upon submission.
                    </small>
                </div>
            </div>
            <div style="padding: 1rem; border-top: 1px solid #ddd; display: flex; gap: 0.5rem; background: white;">
                <button type="button" onclick="closeAssignmentsModal()" style="background: #6c757d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                    Cancel
                </button>
                <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                    Update Assignments
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignmentsModal() {
    const modal = document.getElementById('manageAssignmentsModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeAssignmentsModal() {
    const modal = document.getElementById('manageAssignmentsModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function showAddReportForm() {
    document.getElementById('evaluationFormCard').style.display = 'block';
    document.getElementById('reportsListCard').style.display = 'none';
    // Scroll to form
    document.getElementById('evaluationFormCard').scrollIntoView({ behavior: 'smooth' });
}

document.getElementById('performanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const emp = document.getElementById('employeeSelect').value;
    alert('Performance report submitted successfully for ' + emp + '!');

    // Hide form and show reports list after submission
    document.getElementById('evaluationFormCard').style.display = 'none';
    document.getElementById('reportsListCard').style.display = 'block';
});

// No view selector functionality needed here - this page is dedicated to evaluation reports

function deleteReport(id, employeeName) {
    if (confirm('Are you sure you want to delete the evaluation report for ' + employeeName + '? This action cannot be undone.')) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("admin") }}/delete-evaluation-report/' + id;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add method spoofing for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}

function viewReportDetails(id) {
    // Redirect to the detailed view page
    window.location.href = '{{ url("admin") }}/evaluation-report/' + id;
}
</script>

<style>
.review-period {
    display: flex;
    gap: 20px;
}
.review-period div {
    flex: 1;
}
.section {
    margin-top: 25px;
    padding-top: 10px;
    border-top: 2px solid #eee;
}
</style>
@endsection
