@extends('layouts.admin')

@section('page-title', 'Edit Evaluation Report')
@section('page-description', 'Edit comprehensive evaluation report for employees')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="content-wrapper">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="page-header">
                <h2>Edit Evaluation Report</h2>
                <p>Edit performance evaluation report for {{ $report->employee->name ?? 'Employee' }}</p>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Development Team - Performance Evaluation Form</h5>
                            <a href="{{ route('admin.evaluation-report') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="evaluation-form">
                                <form id="performanceForm" action="{{ route('admin.update-evaluation-report', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Employee Details -->
                                    <h3>Employee Details</h3>
                                    <div class="grid">
                                        <div>
                                            <label>Select Employee</label>
                                            <select name="employee_name" id="employeeSelect" required>
                                                <option value="">-- Select Employee --</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->employee_code }} - {{ $employee->name }}"
                                                        data-designation="{{ $employee->designation }}"
                                                        {{ ($report->employee && $report->employee->employee_code == $employee->employee_code) ? 'selected' : '' }}>
                                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label>Designation</label>
                                            <input type="text" name="designation" id="designation" placeholder="e.g., Web Developer, App Developer"
                                                   value="{{ $report->designation }}" required>
                                        </div>
                                        <div>
                                            <label>Department</label>
                                            <input type="text" name="department" value="Development Team" readonly>
                                        </div>
                                        <div>
                                            <label>Reporting Manager</label>
                                            <input type="text" name="reporting_manager" id="reporting_manager" placeholder="Manager Name"
                                                   value="{{ $report->reporting_manager }}" required>
                                        </div>
                                        <div>
                                            <label>Review Period (From)</label>
                                            <input type="date" name="review_from" value="{{ $report->review_from->format('Y-m-d') }}" required>
                                        </div>
                                        <div>
                                            <label>Review Period (To)</label>
                                            <input type="date" name="review_to" value="{{ $report->review_to->format('Y-m-d') }}" required>
                                        </div>
                                        <div>
                                            <label>Date of Evaluation</label>
                                            <input type="date" name="evaluation_date" value="{{ $report->evaluation_date->format('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <!-- Section 1: KPIs -->
                                    <div class="section mt-4 pt-3 border-top">
                                        <h3>1. Key Performance Indicators (KPIs)</h3>

                                        <label>Project Delivery & Updates</label>
                                        <input type="text" name="project_delivery" class="form-control"
                                               placeholder="Timely completion of assigned tasks" value="{{ $report->project_delivery }}">

                                        <label>Code Quality & Standards</label>
                                        <input type="text" name="code_quality" class="form-control"
                                               placeholder="Clean, optimized, maintainable code" value="{{ $report->code_quality }}">

                                        <label>System/Application Performance</label>
                                        <input type="text" name="performance" class="form-control"
                                               placeholder="Speed, optimization, responsiveness, testing" value="{{ $report->system_performance }}">

                                        <label>Task Completion & Accuracy</label>
                                        <input type="text" name="task_completion" class="form-control"
                                               placeholder="Adherence to project timelines & quality" value="{{ $report->task_completion }}">

                                        <label>Innovation & Problem Solving</label>
                                        <input type="text" name="innovation" class="form-control"
                                               placeholder="New ideas, tools, or solutions suggested" value="{{ $report->innovation }}">

                                        <label>Collaboration & Teamwork</label>
                                        <input type="text" name="teamwork" class="form-control"
                                               placeholder="Coordination with developers, designers, QA, etc." value="{{ $report->teamwork }}">

                                        <label>Communication & Reporting</label>
                                        <input type="text" name="communication" class="form-control"
                                               placeholder="Updates, client communication, reporting style" value="{{ $report->communication }}">

                                        <label>Attendance & Punctuality</label>
                                        <input type="text" name="attendance" class="form-control"
                                               placeholder="Work discipline, logins, reliability" value="{{ $report->attendance }}">
                                    </div>

                                    <!-- Section 2: Quality & Efficiency Metrics (Star Ratings) -->
                                    <div class="section">
                                        <h3>2. Quality & Efficiency Metrics</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Code/Task Efficiency (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="code_efficiency" id="ce{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->qualityMetrics && (int)$report->qualityMetrics->code_efficiency === $i) ? 'checked' : '' }}>
                                                        <label for="ce{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>UI/UX Implementation (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="uiux" id="ui{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->qualityMetrics && (int)$report->qualityMetrics->uiux === $i) ? 'checked' : '' }}>
                                                        <label for="ui{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Debugging & Testing Skills (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="debugging" id="db{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->qualityMetrics && (int)$report->qualityMetrics->debugging === $i) ? 'checked' : '' }}>
                                                        <label for="db{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Version Control Usage (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="version_control" id="vc{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->qualityMetrics && (int)$report->qualityMetrics->version_control === $i) ? 'checked' : '' }}>
                                                        <label for="vc{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Documentation Quality (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="documentation" id="doc{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->qualityMetrics && (int)$report->qualityMetrics->documentation === $i) ? 'checked' : '' }}>
                                                        <label for="doc{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Behavior & Soft Skills -->
                                    <div class="section">
                                        <h3>3. Behavior & Soft Skills</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Professionalism (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="professionalism" id="pr{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->softSkills && (int)$report->softSkills->professionalism === $i) ? 'checked' : '' }}>
                                                        <label for="pr{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Team Collaboration (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="team_collaboration" id="tc{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->softSkills && (int)$report->softSkills->team_collaboration === $i) ? 'checked' : '' }}>
                                                        <label for="tc{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Learning & Adaptability (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="learning" id="la{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->softSkills && (int)$report->softSkills->learning_adaptability === $i) ? 'checked' : '' }}>
                                                        <label for="la{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Initiative & Ownership (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="initiative" id="io{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->softSkills && (int)$report->softSkills->initiative_ownership === $i) ? 'checked' : '' }}>
                                                        <label for="io{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div>
                                                <label>Time Management (1–5)</label>
                                                <div class="rating">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="time_management" id="tm{{ $i }}" value="{{ $i }}"
                                                               {{ ($report->softSkills && (int)$report->softSkills->time_management === $i) ? 'checked' : '' }}>
                                                        <label for="tm{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 4: Overall Evaluation -->
                                    <div class="section">
                                        <h3>4. Overall Evaluation</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Technical Skills (40%)</label>
                                                <input type="range" name="technical_skills" min="0" max="40"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->technical_skills_score : 0 }}"
                                                       class="score-slider" data-max="40">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 40 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Task Delivery (25%)</label>
                                                <input type="range" name="task_delivery" min="0" max="25"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->task_delivery_score : 0 }}"
                                                       class="score-slider" data-max="25">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 25 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Quality of Work (15%)</label>
                                                <input type="range" name="quality_work" min="0" max="15"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->quality_of_work_score : 0 }}"
                                                       class="score-slider" data-max="15">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 15 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Communication (10%)</label>
                                                <input type="range" name="communication_score" min="0" max="10"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->communication_score : 0 }}"
                                                       class="score-slider" data-max="10">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 10 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Behavior & Teamwork (10%)</label>
                                                <input type="range" name="teamwork_score" min="0" max="10"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->teamwork_score : 0 }}"
                                                       class="score-slider" data-max="10">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 10 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Overall Rating (out of 100)</label>
                                                <input type="range" name="overall_rating" min="0" max="100"
                                                       value="{{ $report->overallEvaluation ? $report->overallEvaluation->overall_rating : 0 }}"
                                                       class="score-slider" data-max="100">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 100 (0%)</span>
                                            </div>
                                        </div>
                                        <label>Performance Grade</label>
                                        <select name="performance_grade">
                                            <option value="Excellent" {{ ($report->overallEvaluation ? $report->overallEvaluation->performance_grade : '') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                            <option value="Good" {{ ($report->overallEvaluation ? $report->overallEvaluation->performance_grade : '') == 'Good' ? 'selected' : '' }}>Good</option>
                                            <option value="Satisfactory" {{ ($report->overallEvaluation ? $report->overallEvaluation->performance_grade : '') == 'Satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                                            <option value="Needs Improvement" {{ ($report->overallEvaluation ? $report->overallEvaluation->performance_grade : '') == 'Needs Improvement' ? 'selected' : '' }}>Needs Improvement</option>
                                        </select>
                                    </div>

                                    <!-- Manager Feedback -->
                                    <div class="section">
                                        <h3>Manager's Feedback</h3>
                                        <textarea name="manager_final_feedback"
                                                  placeholder="Summary of strengths, areas for improvement, and training recommendations">{{ $report->manager_feedback }}</textarea>
                                    </div>

                                    <button type="submit">Update Performance Report</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scoreSliders = document.querySelectorAll('.score-slider');

    scoreSliders.forEach(slider => {
        const progressFill = slider.nextElementSibling.querySelector('.progress-fill');
        const displaySpan = slider.nextElementSibling.nextElementSibling;
        const max = parseFloat(slider.getAttribute('data-max')) || 100;

        // Initialize on load
        updateDisplay(slider.value, max, progressFill, displaySpan);

        slider.addEventListener('input', function() {
            updateDisplay(this.value, max, progressFill, displaySpan);
        });
    });

    function updateDisplay(value, max, progressFill, displaySpan) {
        const percentage = Math.min((value / max) * 100, 100);
        progressFill.style.width = percentage + '%';
        displaySpan.textContent = `${value} / ${max} (${Math.round(percentage)}%)`;
    }

    // Auto-fill designation and reporting manager on employee selection
    const employeeSelect = document.getElementById('employeeSelect');
    const designationInput = document.getElementById('designation');
    const reportingManagerInput = document.getElementById('reporting_manager');

    employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const designation = selectedOption.getAttribute('data-designation') || '';
        designationInput.value = designation;
        // For reporting manager, you might need to set a default or fetch from elsewhere
        // For now, leave it as is or set a placeholder
        if (!reportingManagerInput.value) {
            reportingManagerInput.value = 'Manager Name'; // Or fetch from employee data if available
        }
    });
});
</script>

<style>
.evaluation-form form {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(168, 85, 247, 0.05));
    backdrop-filter: blur(10px);
    padding: 35px 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
    max-width: 1100px;
    margin: auto;
    border-top: 5px solid #818cf8;
    border-left: 5px solid #818cf8;
}

.evaluation-form h3 {
    color: #818cf8;
    margin-top: 30px;
    border-left: 5px solid #818cf8;
    padding-left: 12px;
    font-size: 21px;
    font-weight: 600;
}

.evaluation-form label {
    font-weight: 600;
    color: #818cf8;
    margin-bottom: 8px;
    display: block;
    font-size: 15px;
}

.evaluation-form input,
.evaluation-form select,
.evaluation-form textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #c7d2fe;
    border-radius: 12px;
    font-size: 14px;
    background: #fafaff;
    color: #1e293b;
    transition: all 0.3s ease;
}

.evaluation-form input::placeholder,
.evaluation-form textarea::placeholder {
    color: #94a3b8;
}

.evaluation-form input:focus,
.evaluation-form select:focus,
.evaluation-form textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    outline: none;
    background: #fff;
}

.evaluation-form textarea {
    resize: vertical;
    min-height: 100px;
}

.evaluation-form button {
    background: linear-gradient(135deg, #6366f1a1, #6366f1);
    color: #fff;
    border: none;
    padding: 16px 25px;
    border-radius: 14px;
    margin-top: 30px;
    cursor: pointer;
    font-size: 17px;
    font-weight: 600;
    display: block;
    width: 100%;
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
    transition: all 0.3s ease;
}

.evaluation-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
}

.evaluation-form .section {
    margin-top: 25px;
    padding-top: 15px;
    border-top: 2px dashed #e0e7ff;
}

.evaluation-form .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 22px;
    margin-top: 10px;
}

/* Star Rating CSS */
.evaluation-form .rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 6px;
    margin-top: 8px;
}

.evaluation-form .rating input {
    display: none;
}

.evaluation-form .rating label {
    font-size: 26px;
    color: #cbd5e1;
    cursor: pointer;
    transition: all 0.2s;
}

.evaluation-form .rating label:before {
    content: '★';
}

.evaluation-form .rating input:checked ~ label,
.evaluation-form .rating label:hover,
.evaluation-form .rating label:hover ~ label {
    color: gold;
}

.evaluation-form .rating input:checked ~ label:before,
.evaluation-form .rating label:hover:before,
.evaluation-form .rating label:hover ~ label:before {
    text-shadow: 0 0 10px rgba(168, 85, 247, 0.6);
    transform: scale(1.1);
}

/* Progress Bar */
.evaluation-form .progress-bar {
    width: 100%;
    height: 8px;
    background-color: #e0e7ff;
    border-radius: 4px;
    margin-top: 8px;
    overflow: hidden;
}

.evaluation-form .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #a855f7);
    border-radius: 4px;
    width: 0%;
    transition: width 0.3s ease;
}

@media (max-width: 768px) {
    .evaluation-form form {
        padding: 25px;
    }
    .evaluation-form .grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection