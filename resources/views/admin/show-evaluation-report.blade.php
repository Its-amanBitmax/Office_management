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
                                                    <strong>Reporting Manager:</strong><br>
                                                    {{ $report->manager_feedback ? 'Available' : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Overall Performance Summary -->
                            @if($report->overallEvaluation)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-chart-line"></i> Overall Performance Summary
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-md-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <h3 class="text-success">{{ $report->overallEvaluation->overall_rating }}/100</h3>
                                                        <p class="mb-0">Overall Rating</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <h3 class="text-primary">{{ $report->overallEvaluation->technical_skills_score }}/40</h3>
                                                        <p class="mb-0">Technical Skills</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <h3 class="text-info">{{ $report->overallEvaluation->task_delivery_score }}/25</h3>
                                                        <p class="mb-0">Task Delivery</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <h3 class="text-warning">{{ $report->overallEvaluation->communication_score + $report->overallEvaluation->teamwork_score }}/20</h3>
                                                        <p class="mb-0">Soft Skills</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Performance Grade:</strong>
                                                    <span class="badge badge-lg
                                                        @if($report->overallEvaluation->performance_grade == 'Excellent') badge-success
                                                        @elseif($report->overallEvaluation->performance_grade == 'Good') badge-primary
                                                        @elseif($report->overallEvaluation->performance_grade == 'Satisfactory') badge-warning
                                                        @else badge-danger
                                                        @endif">
                                                        {{ $report->overallEvaluation->performance_grade }}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Quality of Work:</strong> {{ $report->overallEvaluation->quality_of_work_score }}/15
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Detailed Sections -->
                            <div class="row">
                                <!-- Key Performance Indicators -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-bullseye"></i> Key Performance Indicators
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong>Project Delivery:</strong><br>
                                                <span class="text-muted">{{ $report->project_delivery ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Code Quality:</strong><br>
                                                <span class="text-muted">{{ $report->code_quality ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>System Performance:</strong><br>
                                                <span class="text-muted">{{ $report->system_performance ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Task Completion:</strong><br>
                                                <span class="text-muted">{{ $report->task_completion ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Innovation:</strong><br>
                                                <span class="text-muted">{{ $report->innovation ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Teamwork:</strong><br>
                                                <span class="text-muted">{{ $report->teamwork ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Communication:</strong><br>
                                                <span class="text-muted">{{ $report->communication ?: 'Not specified' }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Attendance:</strong><br>
                                                <span class="text-muted">{{ $report->attendance ?: 'Not specified' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quality & Efficiency Metrics -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-cogs"></i> Quality & Efficiency Metrics
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($report->qualityMetrics)
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <strong>Code Efficiency:</strong>
                                                            <div class="progress mt-1">
                                                                <div class="progress-bar bg-primary" role="progressbar"
                                                                     style="width: {{ ($report->qualityMetrics->code_efficiency / 5) * 100 }}%"
                                                                     aria-valuenow="{{ $report->qualityMetrics->code_efficiency }}"
                                                                     aria-valuemin="0" aria-valuemax="5">
                                                                    {{ $report->qualityMetrics->code_efficiency }}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <strong>UI/UX:</strong>
                                                            <div class="progress mt-1">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                     style="width: {{ ($report->qualityMetrics->uiux / 5) * 100 }}%"
                                                                     aria-valuenow="{{ $report->qualityMetrics->uiux }}"
                                                                     aria-valuemin="0" aria-valuemax="5">
                                                                    {{ $report->qualityMetrics->uiux }}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <strong>Debugging:</strong>
                                                            <div class="progress mt-1">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                     style="width: {{ ($report->qualityMetrics->debugging / 5) * 100 }}%"
                                                                     aria-valuenow="{{ $report->qualityMetrics->debugging }}"
                                                                     aria-valuemin="0" aria-valuemax="5">
                                                                    {{ $report->qualityMetrics->debugging }}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <strong>Version Control:</strong>
                                                            <div class="progress mt-1">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                     style="width: {{ ($report->qualityMetrics->version_control / 5) * 100 }}%"
                                                                     aria-valuenow="{{ $report->qualityMetrics->version_control }}"
                                                                     aria-valuemin="0" aria-valuemax="5">
                                                                    {{ $report->qualityMetrics->version_control }}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <strong>Documentation:</strong>
                                                            <div class="progress mt-1">
                                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                                     style="width: {{ ($report->qualityMetrics->documentation / 5) * 100 }}%"
                                                                     aria-valuenow="{{ $report->qualityMetrics->documentation }}"
                                                                     aria-valuemin="0" aria-valuemax="5">
                                                                    {{ $report->qualityMetrics->documentation }}/5
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-muted">No quality metrics data available.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Soft Skills -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-users"></i> Soft Skills & Behavior
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($report->softSkills)
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <strong>Professionalism:</strong>
                                                        <div class="progress mt-1">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                 style="width: {{ ($report->softSkills->professionalism / 5) * 100 }}%"
                                                                 aria-valuenow="{{ $report->softSkills->professionalism }}"
                                                                 aria-valuemin="0" aria-valuemax="5">
                                                                {{ $report->softSkills->professionalism }}/5
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>Team Collaboration:</strong>
                                                        <div class="progress mt-1">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                 style="width: {{ ($report->softSkills->team_collaboration / 5) * 100 }}%"
                                                                 aria-valuenow="{{ $report->softSkills->team_collaboration }}"
                                                                 aria-valuemin="0" aria-valuemax="5">
                                                                {{ $report->softSkills->team_collaboration }}/5
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>Learning & Adaptability:</strong>
                                                        <div class="progress mt-1">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                 style="width: {{ ($report->softSkills->learning_adaptability / 5) * 100 }}%"
                                                                 aria-valuenow="{{ $report->softSkills->learning_adaptability }}"
                                                                 aria-valuemin="0" aria-valuemax="5">
                                                                {{ $report->softSkills->learning_adaptability }}/5
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <strong>Initiative & Ownership:</strong>
                                                        <div class="progress mt-1">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                 style="width: {{ ($report->softSkills->initiative_ownership / 5) * 100 }}%"
                                                                 aria-valuenow="{{ $report->softSkills->initiative_ownership }}"
                                                                 aria-valuemin="0" aria-valuemax="5">
                                                                {{ $report->softSkills->initiative_ownership }}/5
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>Time Management:</strong>
                                                        <div class="progress mt-1">
                                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                                 style="width: {{ ($report->softSkills->time_management / 5) * 100 }}%"
                                                                 aria-valuenow="{{ $report->softSkills->time_management }}"
                                                                 aria-valuemin="0" aria-valuemax="5">
                                                                {{ $report->softSkills->time_management }}/5
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-muted">No soft skills data available.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manager's Feedback -->
                            @if($report->manager_feedback)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-comments"></i> Manager's Final Feedback
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">{{ $report->manager_feedback }}</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

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
