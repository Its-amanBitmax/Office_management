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
                        <div class="card-header">
                            <h5 class="card-title">Evaluation Report Slots</h5>
                        </div>
                        <div class="card-body">
                            <!-- Month Selector -->
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
                                                <a href="{{ route('admin.add-evaluation-report', ['review_from' => $week['start_date'], 'review_to' => $week['end_date']]) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Add Report
                                                </a>
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
                                            <a href="{{ route('admin.add-evaluation-report', ['review_from' => $monthCard['start_date'], 'review_to' => $monthCard['end_date']]) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Add Report
                                            </a>
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

<script>
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
