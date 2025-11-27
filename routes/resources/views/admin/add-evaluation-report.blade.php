@extends('layouts.admin')

@section('page-title', 'Add Evaluation Report')
@section('page-description', 'Create a new performance evaluation report')

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
                <h2>Add Evaluation Report</h2>
                <p>Create a new performance evaluation report for an employee</p>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Development Team - Performance Evaluation Form</h5>
                        </div>
                        <div class="card-body">
                            <div class="evaluation-form">
                                <form id="performanceForm" action="{{ route('admin.store-evaluation-report') }}" method="POST">
                                    @csrf

                                    <!-- Employee Details Section -->
                                    <div class="form-section employee-details">
                                        <h3>Employee Details</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Select Employee</label>
                                                <select name="employee_name" id="employeeSelect" required>
                                                    <option value="">-- Select Employee --</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->employee_code }} - {{ $employee->name }}">{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label>Review Period (From)</label>
                                                <input type="date" name="review_from" value="{{ $reviewFrom ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label>Review Period (To)</label>
                                                <input type="date" name="review_to" value="{{ $reviewTo ?? '' }}" required>
                                            </div>
                                            <div>
                                                <label>Date of Evaluation</label>
                                                <input type="date" name="evaluation_date" value="{{ $reviewTo ?? now()->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>

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
                                    @endphp

                                    <!-- Part 1: Manager Evaluation (Technical Assessment) -->
                                    @if($isSuperAdmin || $isStep1Assigned)
                                    <div class="form-section manager-evaluation">
                                        <div class="section-header">
                                            <h3>Part 1: Manager Evaluation</h3>
                                            <span class="section-badge manager-badge">Technical Assessment</span>
                                        </div>

                                        <div class="subsection">
                                            <h4>1.1 Key Performance Indicators (KPIs)</h4>
                                            <label>Project Delivery & Updates</label>
                                            <input type="text" name="project_delivery" class="form-control" placeholder="Timely completion of assigned tasks">

                                            <label>Code Quality & Standards</label>
                                            <input type="text" name="code_quality" class="form-control" placeholder="Clean, optimized, maintainable code">

                                            <label>System/Application Performance</label>
                                            <input type="text" name="performance" class="form-control" placeholder="Speed, optimization, responsiveness, testing">

                                            <label>Task Completion & Accuracy</label>
                                            <input type="text" name="task_completion" class="form-control" placeholder="Adherence to project timelines & quality">

                                            <label>Innovation & Problem Solving</label>
                                            <input type="text" name="innovation" class="form-control" placeholder="New ideas, tools, or solutions suggested">
                                        </div>

                                        <div class="subsection">
                                            <h4>1.2 Technical Skills Assessment</h4>
                                            <div class="grid">
                                                <div>
                                                    <label>Code/Task Efficiency (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="code_efficiency" id="ce5" value="5" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->code_efficiency == 5 ? 'checked' : '' }}><label for="ce5"></label>
                                                        <input type="radio" name="code_efficiency" id="ce4" value="4" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->code_efficiency == 4 ? 'checked' : '' }}><label for="ce4"></label>
                                                        <input type="radio" name="code_efficiency" id="ce3" value="3" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->code_efficiency == 3 ? 'checked' : '' }}><label for="ce3"></label>
                                                        <input type="radio" name="code_efficiency" id="ce2" value="2" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->code_efficiency == 2 ? 'checked' : '' }}><label for="ce2"></label>
                                                        <input type="radio" name="code_efficiency" id="ce1" value="1" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->code_efficiency == 1 ? 'checked' : '' }}><label for="ce1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>UI/UX Implementation (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="uiux" id="ui5" value="5" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->uiux == 5 ? 'checked' : '' }}><label for="ui5"></label>
                                                        <input type="radio" name="uiux" id="ui4" value="4" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->uiux == 4 ? 'checked' : '' }}><label for="ui4"></label>
                                                        <input type="radio" name="uiux" id="ui3" value="3" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->uiux == 3 ? 'checked' : '' }}><label for="ui3"></label>
                                                        <input type="radio" name="uiux" id="ui2" value="2" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->uiux == 2 ? 'checked' : '' }}><label for="ui2"></label>
                                                        <input type="radio" name="uiux" id="ui1" value="1" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->uiux == 1 ? 'checked' : '' }}><label for="ui1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Debugging & Testing Skills (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="debugging" id="db5" value="5" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->debugging == 5 ? 'checked' : '' }}><label for="db5"></label>
                                                        <input type="radio" name="debugging" id="db4" value="4" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->debugging == 4 ? 'checked' : '' }}><label for="db4"></label>
                                                        <input type="radio" name="debugging" id="db3" value="3" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->debugging == 3 ? 'checked' : '' }}><label for="db3"></label>
                                                        <input type="radio" name="debugging" id="db2" value="2" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->debugging == 2 ? 'checked' : '' }}><label for="db2"></label>
                                                        <input type="radio" name="debugging" id="db1" value="1" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->debugging == 1 ? 'checked' : '' }}><label for="db1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Version Control Usage (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="version_control" id="vc5" value="5" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->version_control == 5 ? 'checked' : '' }}><label for="vc5"></label>
                                                        <input type="radio" name="version_control" id="vc4" value="4" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->version_control == 4 ? 'checked' : '' }}><label for="vc4"></label>
                                                        <input type="radio" name="version_control" id="vc3" value="3" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->version_control == 3 ? 'checked' : '' }}><label for="vc3"></label>
                                                        <input type="radio" name="version_control" id="vc2" value="2" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->version_control == 2 ? 'checked' : '' }}><label for="vc2"></label>
                                                        <input type="radio" name="version_control" id="vc1" value="1" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->version_control == 1 ? 'checked' : '' }}><label for="vc1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Documentation Quality (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="documentation" id="doc5" value="5" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->documentation == 5 ? 'checked' : '' }}><label for="doc5"></label>
                                                        <input type="radio" name="documentation" id="doc4" value="4" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->documentation == 4 ? 'checked' : '' }}><label for="doc4"></label>
                                                        <input type="radio" name="documentation" id="doc3" value="3" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->documentation == 3 ? 'checked' : '' }}><label for="doc3"></label>
                                                        <input type="radio" name="documentation" id="doc2" value="2" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->documentation == 2 ? 'checked' : '' }}><label for="doc2"></label>
                                                        <input type="radio" name="documentation" id="doc1" value="1" {{ $existingReport && $existingReport->evaluationManager && $existingReport->evaluationManager->documentation == 1 ? 'checked' : '' }}><label for="doc1"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="total-display">
                                                <strong>Manager Total: <span id="manager-total">{{ $existingReport && $existingReport->evaluationManager ? $existingReport->evaluationManager->manager_total : 0 }}</span> / 30</strong>
                                            </div>
                                        </div>

                                        <div class="subsection">
                                            <h4>1.3 Manager Comments</h4>
                                            <textarea name="manager_comments" placeholder="Manager's assessment and feedback on technical performance">{{ $existingReport && $existingReport->evaluationManager ? $existingReport->evaluationManager->manager_comments : '' }}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Part 2: HR Evaluation (Behavioral Assessment) -->
                                    @if($isSuperAdmin || $isStep2Assigned)
                                    <div class="form-section hr-evaluation">
                                        <div class="section-header">
                                            <h3>Part 2: HR Evaluation</h3>
                                            <span class="section-badge hr-badge">Behavioral Assessment</span>
                                        </div>

                                        <div class="subsection">
                                            <h4>2.1 Behavioral & Soft Skills Assessment</h4>
                                            <label>Collaboration & Teamwork</label>
                                            <input type="text" name="teamwork" class="form-control" placeholder="Coordination with developers, designers, QA, etc." value="{{ $existingReport && $existingReport->evaluationHr ? $existingReport->evaluationHr->teamwork : '' }}">

                                            <label>Communication & Reporting</label>
                                            <input type="text" name="communication" class="form-control" placeholder="Updates, client communication, reporting style" value="{{ $existingReport && $existingReport->evaluationHr ? $existingReport->evaluationHr->communication : '' }}">

                                            <label>Attendance & Punctuality</label>
                                            <input type="text" name="attendance" class="form-control" placeholder="Work discipline, logins, reliability" value="{{ $existingReport && $existingReport->evaluationHr ? $existingReport->evaluationHr->attendance : '' }}">
                                        </div>

                                        <div class="subsection">
                                            <h4>2.2 Soft Skills Ratings</h4>
                                            <div class="grid">
                                                <div>
                                                    <label>Professionalism (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="professionalism" id="pr5" value="5" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->professionalism == 5 ? 'checked' : '' }}><label for="pr5"></label>
                                                        <input type="radio" name="professionalism" id="pr4" value="4" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->professionalism == 4 ? 'checked' : '' }}><label for="pr4"></label>
                                                        <input type="radio" name="professionalism" id="pr3" value="3" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->professionalism == 3 ? 'checked' : '' }}><label for="pr3"></label>
                                                        <input type="radio" name="professionalism" id="pr2" value="2" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->professionalism == 2 ? 'checked' : '' }}><label for="pr2"></label>
                                                        <input type="radio" name="professionalism" id="pr1" value="1" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->professionalism == 1 ? 'checked' : '' }}><label for="pr1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Team Collaboration (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="team_collaboration" id="tc5" value="5" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->team_collaboration == 5 ? 'checked' : '' }}><label for="tc5"></label>
                                                        <input type="radio" name="team_collaboration" id="tc4" value="4" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->team_collaboration == 4 ? 'checked' : '' }}><label for="tc4"></label>
                                                        <input type="radio" name="team_collaboration" id="tc3" value="3" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->team_collaboration == 3 ? 'checked' : '' }}><label for="tc3"></label>
                                                        <input type="radio" name="team_collaboration" id="tc2" value="2" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->team_collaboration == 2 ? 'checked' : '' }}><label for="tc2"></label>
                                                        <input type="radio" name="team_collaboration" id="tc1" value="1" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->team_collaboration == 1 ? 'checked' : '' }}><label for="tc1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Learning & Adaptability (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="learning" id="la5" value="5" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->learning == 5 ? 'checked' : '' }}><label for="la5"></label>
                                                        <input type="radio" name="learning" id="la4" value="4" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->learning == 4 ? 'checked' : '' }}><label for="la4"></label>
                                                        <input type="radio" name="learning" id="la3" value="3" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->learning == 3 ? 'checked' : '' }}><label for="la3"></label>
                                                        <input type="radio" name="learning" id="la2" value="2" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->learning == 2 ? 'checked' : '' }}><label for="la2"></label>
                                                        <input type="radio" name="learning" id="la1" value="1" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->learning == 1 ? 'checked' : '' }}><label for="la1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Initiative & Ownership (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="initiative" id="io5" value="5" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->initiative == 5 ? 'checked' : '' }}><label for="io5"></label>
                                                        <input type="radio" name="initiative" id="io4" value="4" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->initiative == 4 ? 'checked' : '' }}><label for="io4"></label>
                                                        <input type="radio" name="initiative" id="io3" value="3" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->initiative == 3 ? 'checked' : '' }}><label for="io3"></label>
                                                        <input type="radio" name="initiative" id="io2" value="2" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->initiative == 2 ? 'checked' : '' }}><label for="io2"></label>
                                                        <input type="radio" name="initiative" id="io1" value="1" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->initiative == 1 ? 'checked' : '' }}><label for="io1"></label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Time Management (1–5)</label>
                                                    <div class="rating">
                                                        <input type="radio" name="time_management" id="tm5" value="5" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->time_management == 5 ? 'checked' : '' }}><label for="tm5"></label>
                                                        <input type="radio" name="time_management" id="tm4" value="4" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->time_management == 4 ? 'checked' : '' }}><label for="tm4"></label>
                                                        <input type="radio" name="time_management" id="tm3" value="3" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->time_management == 3 ? 'checked' : '' }}><label for="tm3"></label>
                                                        <input type="radio" name="time_management" id="tm2" value="2" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->time_management == 2 ? 'checked' : '' }}><label for="tm2"></label>
                                                        <input type="radio" name="time_management" id="tm1" value="1" {{ $existingReport && $existingReport->evaluationHr && $existingReport->evaluationHr->time_management == 1 ? 'checked' : '' }}><label for="tm1"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="total-display">
                                                <strong>HR Total: <span id="hr-total">{{ $existingReport && $existingReport->evaluationHr ? $existingReport->evaluationHr->hr_total : 0 }}</span> / 20</strong>
                                            </div>
                                        </div>

                                        <div class="subsection">
                                            <h4>2.3 HR Comments</h4>
                                            <textarea name="hr_comments" placeholder="HR's assessment and feedback on behavioral performance">{{ $existingReport && $existingReport->evaluationHr ? $existingReport->evaluationHr->hr_comments : '' }}</textarea>
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

        <div class="grid">

            <div>
                <label>Skills</label>
                <input type="range" name="technical_skills" min="0" max="10"
                       value="{{ $overall?->technical_skills ?? 0 }}"
                       class="score-slider">
                <span class="score-display">0 / 10</span>
            </div>

            <div>
                <label>Task Delivery</label>
                <input type="range" name="task_delivery_score" min="0" max="10"
                       value="{{ $overall?->task_delivery ?? 0 }}"
                       class="score-slider">
                <span class="score-display">0 / 10</span>
            </div>

            <div>
                <label>Quality of Work</label>
                <input type="range" name="quality_work" min="0" max="10"
                       value="{{ $overall?->quality_work ?? 0 }}"
                       class="score-slider">
                <span class="score-display">0 / 10</span>
            </div>

            <div>
                <label>Communication</label>
                <input type="range" name="communication_score" min="0" max="10"
                       value="{{ $overall?->communication ?? 0 }}"
                       class="score-slider">
                <span class="score-display">0 / 10</span>
            </div>

            <div>
                <label>Behavior & Teamwork</label>
                <input type="range" name="behavior_teamwork" min="0" max="10"
                       value="{{ $overall?->behavior_teamwork ?? 0 }}"
                       class="score-slider">
                <span class="score-display">0 / 10</span>
            </div>

            <input type="hidden" name="overall_rating" value="{{ $overall?->overall_rating ?? 0 }}">

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
        <textarea name="final_feedback" placeholder="Overall summary, strengths, improvement areas...">
            {{ $overall?->final_feedback ?? '' }}
        </textarea>
    </div>
</div>

                                    @endif

                                    <button type="submit">Submit Evaluation Report</button>
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
document.querySelectorAll('.score-slider').forEach(function(slider) {

    function updateScore(slider) {
        let value = slider.value;
        let max = slider.getAttribute('max');
        let display = slider.parentElement.querySelector('.score-display');
        display.textContent = value + " / " + max;

        calculateOverall();
    }

    slider.addEventListener('input', function() {
        updateScore(slider);
    });

    updateScore(slider);
});

function calculateOverall() {
    let t = parseInt(document.querySelector('[name="technical_skills"]').value || 0);
    let d = parseInt(document.querySelector('[name="task_delivery_score"]').value || 0);
    let q = parseInt(document.querySelector('[name="quality_work"]').value || 0);
    let c = parseInt(document.querySelector('[name="communication_score"]').value || 0);
    let b = parseInt(document.querySelector('[name="behavior_teamwork"]').value || 0);

    let total = t + d + q + c + b; // max = 50

    document.querySelector('[name="overall_rating"]').value = total;
}
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

.evaluation-form .manager-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.evaluation-form .hr-badge {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.evaluation-form .overall-badge {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.evaluation-form .subsection {
    margin-bottom: 25px;
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

/* Progress Bar Styles */
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
    .evaluation-form .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
@endsection
