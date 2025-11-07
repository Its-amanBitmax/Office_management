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
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="page-header">
                <h2>Edit Evaluation Report</h2>
                <p>Edit performance evaluation for <strong>{{ $report->employee->name }}</strong></p>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Development Team - Performance Evaluation Form</h5>
                            <a href="{{ route('admin.evaluation-report') }}" class="btn btn-secondary btn-sm">
                                Back to Reports
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="evaluation-form">
                                <form id="performanceForm" action="{{ route('admin.update-evaluation-report', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @php
                                        $admin = auth('admin')->user();
                                        $isSuperAdmin = $admin->role === 'super_admin';
                                        $isStep1Assigned = false;
                                        $isStep2Assigned = false;

                                        if (!$isSuperAdmin) {
                                            $step1Assignments = \App\Models\EvaluationAssignment::where('step', 'step1')->first();
                                            $step2Assignments = \App\Models\EvaluationAssignment::where('step', 'step2')->first();
                                            $isStep1Assigned = $step1Assignments && in_array($admin->id, $step1Assignments->assigned_admins ?? []);
                                            $isStep2Assigned = $step2Assignments && in_array($admin->id, $step2Assignments->assigned_admins ?? []);
                                        }

                                        $manager = $report->evaluationManager;
                                        $hr = $report->evaluationHr;
                                        $overall = $report->evaluationOverall;
                                    @endphp

                                    <!-- Employee Details (Read-only in edit) -->
                                    <div class="form-section employee-details">
                                        <h3>Employee Details</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Employee</label>
                                                <input type="text" value="{{ $report->employee->name }} ({{ $report->employee->employee_code }})" readonly>
                                                <input type="hidden" name="employee_id" value="{{ $report->employee_id }}">
                                                <input type="hidden" name="employee_name" value="{{ $report->employee->employee_code }} - {{ $report->employee->name }}">
                                            </div>
                                            <div>
                                                <label>Review Period</label>
                                                <input type="text" value="{{ $report->review_from->format('M d, Y') }} - {{ $report->review_to->format('M d, Y') }}" readonly>
                                                <input type="hidden" name="review_from" value="{{ $report->review_from }}">
                                                <input type="hidden" name="review_to" value="{{ $report->review_to }}">
                                            </div>
                                            <div>
                                                <label>Date of Evaluation</label>
                                                <input type="date" name="evaluation_date" value="{{ $report->evaluation_date->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Part 1: Manager Evaluation -->
                                    @if($isSuperAdmin || $isStep1Assigned)
                                    <div class="form-section manager-evaluation">
                                        <div class="section-header">
                                            <h3>Part 1: Manager Evaluation</h3>
                                            <span class="section-badge manager-badge">Technical Assessment</span>
                                        </div>

                                        <div class="subsection">
                                            <h4>1.1 Key Performance Indicators (KPIs)</h4>
                                            <label>Project Delivery & Updates</label>
                                            <input type="text" name="project_delivery" class="form-control"
                                                   value="{{ $manager?->project_delivery ?? '' }}">

                                            <label>Code Quality & Standards</label>
                                            <input type="text" name="code_quality" class="form-control"
                                                   value="{{ $manager?->code_quality ?? '' }}">

                                            <label>System/Application Performance</label>
                                            <input type="text" name="performance" class="form-control"
                                                   value="{{ $manager?->performance ?? '' }}">

                                            <label>Task Completion & Accuracy</label>
                                            <input type="text" name="task_completion" class="form-control"
                                                   value="{{ $manager?->task_completion ?? '' }}">

                                            <label>Innovation & Problem Solving</label>
                                            <input type="text" name="innovation" class="form-control"
                                                   value="{{ $manager?->innovation ?? '' }}">
                                        </div>

                                        <div class="subsection">
                                            <h4>1.2 Technical Skills Assessment</h4>
                                            <div class="grid">
                                                <div>
                                                    <label>Code/Task Efficiency (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="code_efficiency" id="ce{{ $i }}" value="{{ $i }}"
                                                                   {{ $manager?->code_efficiency == $i ? 'checked' : '' }}>
                                                            <label for="ce{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>UI/UX Implementation (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="uiux" id="ui{{ $i }}" value="{{ $i }}"
                                                                   {{ $manager?->uiux == $i ? 'checked' : '' }}>
                                                            <label for="ui{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Debugging & Testing Skills (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="debugging" id="db{{ $i }}" value="{{ $i }}"
                                                                   {{ $manager?->debugging == $i ? 'checked' : '' }}>
                                                            <label for="db{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Version Control Usage (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="version_control" id="vc{{ $i }}" value="{{ $i }}"
                                                                   {{ $manager?->version_control == $i ? 'checked' : '' }}>
                                                            <label for="vc{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Documentation Quality (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="documentation" id="doc{{ $i }}" value="{{ $i }}"
                                                                   {{ $manager?->documentation == $i ? 'checked' : '' }}>
                                                            <label for="doc{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="subsection">
                                            <h4>1.3 Manager Comments</h4>
                                            <textarea name="manager_comments" placeholder="Technical feedback...">{{ $manager?->manager_comments ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Part 2: HR Evaluation -->
                                    @if($isSuperAdmin || $isStep2Assigned)
                                    <div class="form-section hr-evaluation">
                                        <div class="section-header">
                                            <h3>Part 2: HR Evaluation</h3>
                                            <span class="section-badge hr-badge">Behavioral Assessment</span>
                                        </div>

                                        <div class="subsection">
                                            <h4>2.1 Behavioral & Soft Skills</h4>
                                            <label>Collaboration & Teamwork</label>
                                            <input type="text" name="teamwork" class="form-control"
                                                   value="{{ $hr?->teamwork ?? '' }}">

                                            <label>Communication & Reporting</label>
                                            <input type="text" name="communication" class="form-control"
                                                   value="{{ $hr?->communication ?? '' }}">

                                            <label>Attendance & Punctuality</label>
                                            <input type="text" name="attendance" class="form-control"
                                                   value="{{ $hr?->attendance ?? '' }}">
                                        </div>

                                        <div class="subsection">
                                            <h4>2.2 Soft Skills Ratings</h4>
                                            <div class="grid">
                                                <div>
                                                    <label>Professionalism (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="professionalism" id="pr{{ $i }}" value="{{ $i }}"
                                                                   {{ $hr?->professionalism == $i ? 'checked' : '' }}>
                                                            <label for="pr{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Team Collaboration (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="team_collaboration" id="tc{{ $i }}" value="{{ $i }}"
                                                                   {{ $hr?->team_collaboration == $i ? 'checked' : '' }}>
                                                            <label for="tc{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Learning & Adaptability (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="learning" id="la{{ $i }}" value="{{ $i }}"
                                                                   {{ $hr?->learning == $i ? 'checked' : '' }}>
                                                            <label for="la{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Initiative & Ownership (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="initiative" id="io{{ $i }}" value="{{ $i }}"
                                                                   {{ $hr?->initiative == $i ? 'checked' : '' }}>
                                                            <label for="io{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Time Management (1–5)</label>
                                                    <div class="rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="time_management" id="tm{{ $i }}" value="{{ $i }}"
                                                                   {{ $hr?->time_management == $i ? 'checked' : '' }}>
                                                            <label for="tm{{ $i }}"></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="subsection">
                                            <h4>2.3 HR Comments</h4>
                                            <textarea name="hr_comments" placeholder="Behavioral feedback...">{{ $hr?->hr_comments ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Part 3: Overall Evaluation (Super Admin Only) -->
                                    @if($isSuperAdmin)
                                    <div class="form-section overall-evaluation">
                                        <div class="section-header">
                                            <h3>Part 3: Overall Evaluation</h3>
                                            <span class="section-badge overall-badge">Final Assessment</span>
                                        </div>

                                        <div class="subsection">
                                            <h4>3.1 Performance Scoring</h4>
                                            <div> **Image ke hisaab se sliders**:
                                            <div class="grid">
                                                <div>
                                                    <label>Technical Skills (40%)</label>
                                                    <input type="range" name="technical_skills" min="0" max="40"
                                                           value="{{ $overall?->technical_skills ?? 0 }}" class="score-slider" data-max="40">
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 40 (0%)</span>
                                                </div>
                                                <div>
                                                    <label>Task Delivery (25%)</label>
                                                    <input type="range" name="task_delivery_score" min="0" max="25"
                                                           value="{{ $overall?->task_delivery ?? 0 }}" class="score-slider" data-max="25">
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 25 (0%)</span>
                                                </div>
                                                <div>
                                                    <label>Quality of Work (15%)</label>
                                                    <input type="range" name="quality_work" min="0" max="15"
                                                           value="{{ $overall?->quality_work ?? 0 }}" class="score-slider" data-max="15">
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 15 (0%)</span>
                                                </div>
                                                <div>
                                                    <label>Communication (10%)</label>
                                                    <input type="range" name="communication_score" min="0" max="10"
                                                           value="{{ $overall?->communication ?? 0 }}" class="score-slider" data-max="10">
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 10 (0%)</span>
                                                </div>
                                                <div>
                                                    <label>Behavior & Teamwork (10%)</label>
                                                    <input type="range" name="behavior_teamwork" min="0" max="10"
                                                           value="{{ $overall?->behavior_teamwork ?? 0 }}" class="score-slider" data-max="10">
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 10 (0%)</span>
                                                </div>
                                                <div>
                                                    <label>Overall Rating (out of 100)</label>
                                                    <input type="range" name="overall_rating" min="0" max="100"
                                                           value="{{ $overall?->overall_rating ?? 0 }}" class="score-slider" data-max="100" readonly>
                                                    <div class="progress-bar"><div class="progress-fill"></div></div>
                                                    <span class="score-display">0 / 100 (0%)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="subsection">
                                            <h4>3.2 Final Assessment</h4>
                                            <label>Performance Grade</label>
                                            <select name="performance_grade" required>
                                                <option value="">Select Grade</option>
                                                <option value="Excellent" {{ $overall?->performance_grade == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                                <option value="Good" {{ $overall?->performance_grade == 'Good' ? 'selected' : '' }}>Good</option>
                                                <option value="Satisfactory" {{ $overall?->performance_grade == 'Satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                                                <option value="Needs Improvement" {{ $overall?->performance_grade == 'Needs Improvement' ? 'selected' : '' }}>Needs Improvement</option>
                                            </select>

                                            <label>Final Feedback</label>
                                            <textarea name="final_feedback" placeholder="Overall summary, strengths, improvement areas...">{{ $overall?->final_feedback ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                    <button type="submit">Update Evaluation Report</button>
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
    const sliders = document.querySelectorAll('.score-slider');
    const overallRating = document.querySelector('input[name="overall_rating"]');

    function updateSlider(slider) {
        const max = parseFloat(slider.dataset.max);
        const value = parseFloat(slider.value);
        const percentage = (value / max) * 100;
        const fill = slider.nextElementSibling.querySelector('.progress-fill');
        const display = fill.nextElementSibling;

        fill.style.width = percentage + '%';
        display.textContent = `${value} / ${max} (${Math.round(percentage)}%)`;
    }

    sliders.forEach(slider => {
        updateSlider(slider);
        slider.addEventListener('input', () => updateSlider(slider));
    });

    // Auto-calculate overall rating
    const fields = ['technical_skills', 'task_delivery_score', 'quality_work', 'communication_score', 'behavior_teamwork'];
    fields.forEach(field => {
        const input = document.querySelector(`input[name="${field}"]`);
        if (input) {
            input.addEventListener('input', calculateOverall);
        }
    });

    function calculateOverall() {
        let total = 0;
        fields.forEach(field => {
            const val = parseFloat(document.querySelector(`input[name="${field}"]`)?.value) || 0;
            total += val;
        });
        overallRating.value = total;
        updateSlider(overallRating);
    }

    calculateOverall(); // Initial calc
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

.evaluation-form h4 {
    color: #6366f1;
    margin-top: 20px;
    font-size: 16px;
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

.evaluation-form .form-section {
    margin-bottom: 40px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.evaluation-form .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e0e7ff;
}

.evaluation-form .section-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.evaluation-form .manager-badge { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.evaluation-form .hr-badge { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.evaluation-form .overall-badge { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

.evaluation-form .subsection { margin-bottom: 25px; }
.evaluation-form .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-top: 10px; }

/* Star Rating */
.evaluation-form .rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 6px; margin-top: 8px; }
.evaluation-form .rating input { display: none; }
.evaluation-form .rating label { font-size: 26px; color: #cbd5e1; cursor: pointer; transition: all 0.2s; }
.evaluation-form .rating label:before { content: '★'; }
.evaluation-form .rating input:checked ~ label,
.evaluation-form .rating label:hover,
.evaluation-form .rating label:hover ~ label { color: gold; }

/* Progress Bar */
.evaluation-form .progress-bar { width: 100%; height: 8px; background-color: #e0e7ff; border-radius: 4px; margin-top: 8px; overflow: hidden; }
.evaluation-form .progress-fill { height: 100%; background: linear-gradient(90deg, #6366f1, #a855f7); border-radius: 4px; width: 0%; transition: width 0.3s ease; }

@media (max-width: 768px) {
    .evaluation-form form { padding: 25px; }
    .evaluation-form .grid { grid-template-columns: 1fr; }
    .evaluation-form .section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>
@endsection