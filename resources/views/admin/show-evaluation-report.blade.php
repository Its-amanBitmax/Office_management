@extends('layouts.admin')

@section('page-title', 'Evaluation Report Details')
@section('page-description', 'Detailed view of employee evaluation report')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card" id="reportDetailsCard">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Evaluation Report Details</h5>
                            <div>
                                <button class="btn btn-warning btn-sm" onclick="editReport({{ $report->id }})">
                                    <i class="fas fa-edit"></i> Edit Report
                                </button>
                                <a href="{{ route('admin.evaluation-report') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to Reports
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Employee Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-user"></i> Employee Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    @if($report->employee && $report->employee->profile_image)
                                                        <img src="{{ asset('storage/' . $report->employee->profile_image) }}"
                                                             alt="Profile Image"
                                                             class="img-fluid rounded-circle"
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-user fa-2x text-primary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-8">
                                                    <h5>{{ $report->employee->name ?? 'N/A' }}</h5>
                                                    <p class="text-muted mb-1">{{ $report->employee->employee_code ?? 'N/A' }}</p>
                                                    <p class="mb-0"><strong>Department:</strong> Development Team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-calendar-alt"></i> Review Period & Evaluation
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <strong>Review From:</strong><br>
                                                    {{ \Carbon\Carbon::parse($report->review_from)->format('M d, Y') }}
                                                </div>
                                                <div class="col-6">
                                                    <strong>Review To:</strong><br>
                                                    {{ \Carbon\Carbon::parse($report->review_to)->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <strong>Evaluation Date:</strong><br>
                                                    {{ \Carbon\Carbon::parse($report->evaluation_date)->format('M d, Y') }}
                                                </div>
                                                <div class="col-6">
                                                    <strong>Status:</strong><br>
                                                    <span class="badge badge-{{ $report->status === 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($report->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluation Sections -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="evaluationTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="manager-tab" data-bs-toggle="tab" data-bs-target="#manager" type="button" role="tab" aria-controls="manager" aria-selected="true">
                                                <i class="fas fa-user-tie"></i> Manager Evaluation
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="hr-tab" data-bs-toggle="tab" data-bs-target="#hr" type="button" role="tab" aria-controls="hr" aria-selected="false">
                                                <i class="fas fa-user-check"></i> HR Evaluation
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="overall-tab" data-bs-toggle="tab" data-bs-target="#overall" type="button" role="tab" aria-controls="overall" aria-selected="false">
                                                <i class="fas fa-chart-line"></i> Overall Evaluation
                                            </button>
                                        </li>
                                    </ul>

                                    <!-- Tab content -->
                                    <div class="tab-content" id="evaluationTabsContent">
                                        <!-- Manager Evaluation Tab -->
                                        <div class="tab-pane fade show active" id="manager" role="tabpanel" aria-labelledby="manager-tab">
                                            @if($report->evaluationManager)
                                            <div class="card border-primary mt-3">
                                                <div class="card-header bg-primary text-white">
                                                    <h6 class="card-title mb-0">
                                                        <i class="fas fa-user-tie"></i> Manager's Evaluation
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Technical KPIs -->
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <h6 class="text-primary mb-3">Technical KPIs</h6>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Project Delivery:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationManager->project_delivery ?: 'Not specified' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Code Quality:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationManager->code_quality ?: 'Not specified' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Performance:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationManager->performance ?: 'Not specified' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Task Completion:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationManager->task_completion ?: 'Not specified' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Innovation:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationManager->innovation ?: 'Not specified' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Quality Metrics Ratings -->
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <h6 class="text-primary mb-3">Quality Metrics</h6>
                                                            <div class="row text-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-primary">{{ $report->evaluationManager->code_efficiency }}/5</h4>
                                                                        <p class="mb-0">Code Efficiency</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-info">{{ $report->evaluationManager->uiux }}/5</h4>
                                                                        <p class="mb-0">UI/UX</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-success">{{ $report->evaluationManager->debugging }}/5</h4>
                                                                        <p class="mb-0">Debugging</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-warning">{{ $report->evaluationManager->version_control }}/5</h4>
                                                                        <p class="mb-0">Version Control</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row text-center mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-secondary">{{ $report->evaluationManager->documentation }}/5</h4>
                                                                        <p class="mb-0">Documentation</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-danger">{{ $report->evaluationManager->manager_total }}/60</h4>
                                                                        <p class="mb-0">Total Score</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Manager Comments -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Manager Comments:</strong><br>
                                                            <span class="text-muted">{{ $report->evaluationManager->manager_comments ?: 'No comments' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="card border-secondary mt-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">Manager evaluation not yet completed.</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- HR Evaluation Tab -->
                                        <div class="tab-pane fade" id="hr" role="tabpanel" aria-labelledby="hr-tab">
                                            @if($report->evaluationHr)
                                            <div class="card border-info mt-3">
                                                <div class="card-header bg-info text-white">
                                                    <h6 class="card-title mb-0">
                                                        <i class="fas fa-user-check"></i> HR's Evaluation
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Soft Skills Feedback -->
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <h6 class="text-info mb-3">Soft Skills Assessment</h6>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Teamwork:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationHr->teamwork ?: 'Not specified' }}</span>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Communication:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationHr->communication ?: 'Not specified' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Attendance:</strong><br>
                                                                    <span class="text-muted">{{ $report->evaluationHr->attendance ?: 'Not specified' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Behavioral Metrics Ratings -->
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <h6 class="text-info mb-3">Behavioral Metrics</h6>
                                                            <div class="row text-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-primary">{{ $report->evaluationHr->professionalism }}/5</h4>
                                                                        <p class="mb-0">Professionalism</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-success">{{ $report->evaluationHr->team_collaboration }}/5</h4>
                                                                        <p class="mb-0">Team Collaboration</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-warning">{{ $report->evaluationHr->learning }}/5</h4>
                                                                        <p class="mb-0">Learning</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-info">{{ $report->evaluationHr->initiative }}/5</h4>
                                                                        <p class="mb-0">Initiative</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row text-center mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-secondary">{{ $report->evaluationHr->time_management }}/5</h4>
                                                                        <p class="mb-0">Time Management</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="p-3 bg-light rounded">
                                                                        <h4 class="text-danger">{{ $report->evaluationHr->hr_total }}/30</h4>
                                                                        <p class="mb-0">Total Score</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- HR Comments -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>HR Comments:</strong><br>
                                                            <span class="text-muted">{{ $report->evaluationHr->hr_comments ?: 'No comments' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="card border-secondary mt-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">HR evaluation not yet completed.</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Overall Evaluation Tab -->
                                        <div class="tab-pane fade" id="overall" role="tabpanel" aria-labelledby="overall-tab">
                                            @if($report->evaluationOverall)
                                            <div class="card border-success mt-3">
                                                <div class="card-header bg-success text-white">
                                                    <h6 class="card-title mb-0">
                                                        <i class="fas fa-chart-line"></i> Overall Performance Summary
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row text-center mb-4">
                                                        <div class="col-md-3">
                                                            <div class="p-3 bg-light rounded">
                                                                <h3 class="text-success">{{ $report->evaluationOverall->overall_rating }}/100</h3>
                                                                <p class="mb-0">Overall Rating</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-3 bg-light rounded">
                                                                <h3 class="text-primary">{{ $report->evaluationOverall->technical_skills }}/40</h3>
                                                                <p class="mb-0">Technical Skills</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-3 bg-light rounded">
                                                                <h3 class="text-info">{{ $report->evaluationOverall->task_delivery }}/25</h3>
                                                                <p class="mb-0">Task Delivery</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-3 bg-light rounded">
                                                                <h3 class="text-warning">{{ $report->evaluationOverall->communication + $report->evaluationOverall->behavior_teamwork }}/20</h3>
                                                                <p class="mb-0">Soft Skills</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong>Performance Grade:</strong>
                                                            <span class="badge badge-lg
                                                                @if($report->evaluationOverall->performance_grade == 'Excellent') badge-success
                                                                @elseif($report->evaluationOverall->performance_grade == 'Good') badge-primary
                                                                @elseif($report->evaluationOverall->performance_grade == 'Satisfactory') badge-warning
                                                                @else badge-danger
                                                                @endif">
                                                                {{ $report->evaluationOverall->performance_grade }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Quality of Work:</strong> {{ $report->evaluationOverall->quality_work }}/15
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <strong>Final Feedback:</strong><br>
                                                            <span class="text-muted">{{ $report->evaluationOverall->final_feedback ?: 'No feedback' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="card border-secondary mt-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">Overall evaluation not yet completed.</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detailed Sections -->
                         
                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('admin.evaluation-report.download-pdf', $report->id) }}" class="btn btn-success" target="_blank">
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
                                    <a href="{{ route('admin.edit-evaluation-report', $report->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Report
                                    </a>
                                    <a href="{{ route('admin.evaluation-report') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Reports
                                    </a>
                                    <button class="btn btn-danger" onclick="deleteReport({{ $report->id }}, '{{ $report->employee->name ?? 'N/A' }}')">
                                        <i class="fas fa-trash"></i> Delete Report
                                    </button>
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
</script>

<style>
.progress {
    height: 20px;
}
.progress-bar {
    font-size: 12px;
    font-weight: bold;
}
.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endsection
