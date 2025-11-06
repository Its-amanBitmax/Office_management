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
                                            <label>Designation</label>
                                            <input type="text" name="designation" placeholder="e.g., Web Developer, App Developer" required>
                                        </div>
                                        <div>
                                            <label>Department</label>
                                            <input type="text" name="department" value="Development Team" readonly>
                                        </div>
                                        <div>
                                            <label>Reporting Manager</label>
                                            <input type="text" name="reporting_manager" placeholder="Manager Name" required>
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

                                    <div class="section mt-4 pt-3 border-top">
                                        <h3>1. Key Performance Indicators (KPIs)</h3>

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

                                        <label>Collaboration & Teamwork</label>
                                        <input type="text" name="teamwork" class="form-control" placeholder="Coordination with developers, designers, QA, etc.">

                                        <label>Communication & Reporting</label>
                                        <input type="text" name="communication" class="form-control" placeholder="Updates, client communication, reporting style">

                                        <label>Attendance & Punctuality</label>
                                        <input type="text" name="attendance" class="form-control" placeholder="Work discipline, logins, reliability">
                                    </div>

                                    <!-- Section 2: Star Ratings -->
                                    <div class="section">
                                        <h3>2. Quality & Efficiency Metrics</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Code/Task Efficiency (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="code_efficiency" id="ce5" value="5"><label for="ce5"></label>
                                                    <input type="radio" name="code_efficiency" id="ce4" value="4"><label for="ce4"></label>
                                                    <input type="radio" name="code_efficiency" id="ce3" value="3"><label for="ce3"></label>
                                                    <input type="radio" name="code_efficiency" id="ce2" value="2"><label for="ce2"></label>
                                                    <input type="radio" name="code_efficiency" id="ce1" value="1"><label for="ce1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>UI/UX Implementation (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="uiux" id="ui5" value="5"><label for="ui5"></label>
                                                    <input type="radio" name="uiux" id="ui4" value="4"><label for="ui4"></label>
                                                    <input type="radio" name="uiux" id="ui3" value="3"><label for="ui3"></label>
                                                    <input type="radio" name="uiux" id="ui2" value="2"><label for="ui2"></label>
                                                    <input type="radio" name="uiux" id="ui1" value="1"><label for="ui1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Debugging & Testing Skills (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="debugging" id="db5" value="5"><label for="db5"></label>
                                                    <input type="radio" name="debugging" id="db4" value="4"><label for="db4"></label>
                                                    <input type="radio" name="debugging" id="db3" value="3"><label for="db3"></label>
                                                    <input type="radio" name="debugging" id="db2" value="2"><label for="db2"></label>
                                                    <input type="radio" name="debugging" id="db1" value="1"><label for="db1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Version Control Usage (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="version_control" id="vc5" value="5"><label for="vc5"></label>
                                                    <input type="radio" name="version_control" id="vc4" value="4"><label for="vc4"></label>
                                                    <input type="radio" name="version_control" id="vc3" value="3"><label for="vc3"></label>
                                                    <input type="radio" name="version_control" id="vc2" value="2"><label for="vc2"></label>
                                                    <input type="radio" name="version_control" id="vc1" value="1"><label for="vc1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Documentation Quality (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="documentation" id="doc5" value="5"><label for="doc5"></label>
                                                    <input type="radio" name="documentation" id="doc4" value="4"><label for="doc4"></label>
                                                    <input type="radio" name="documentation" id="doc3" value="3"><label for="doc3"></label>
                                                    <input type="radio" name="documentation" id="doc2" value="2"><label for="doc2"></label>
                                                    <input type="radio" name="documentation" id="doc1" value="1"><label for="doc1"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Star Ratings -->
                                    <div class="section">
                                        <h3>3. Behavior & Soft Skills</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Professionalism (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="professionalism" id="pr5" value="5"><label for="pr5"></label>
                                                    <input type="radio" name="professionalism" id="pr4" value="4"><label for="pr4"></label>
                                                    <input type="radio" name="professionalism" id="pr3" value="3"><label for="pr3"></label>
                                                    <input type="radio" name="professionalism" id="pr2" value="2"><label for="pr2"></label>
                                                    <input type="radio" name="professionalism" id="pr1" value="1"><label for="pr1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Team Collaboration (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="team_collaboration" id="tc5" value="5"><label for="tc5"></label>
                                                    <input type="radio" name="team_collaboration" id="tc4" value="4"><label for="tc4"></label>
                                                    <input type="radio" name="team_collaboration" id="tc3" value="3"><label for="tc3"></label>
                                                    <input type="radio" name="team_collaboration" id="tc2" value="2"><label for="tc2"></label>
                                                    <input type="radio" name="team_collaboration" id="tc1" value="1"><label for="tc1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Learning & Adaptability (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="learning" id="la5" value="5"><label for="la5"></label>
                                                    <input type="radio" name="learning" id="la4" value="4"><label for="la4"></label>
                                                    <input type="radio" name="learning" id="la3" value="3"><label for="la3"></label>
                                                    <input type="radio" name="learning" id="la2" value="2"><label for="la2"></label>
                                                    <input type="radio" name="learning" id="la1" value="1"><label for="la1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Initiative & Ownership (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="initiative" id="io5" value="5"><label for="io5"></label>
                                                    <input type="radio" name="initiative" id="io4" value="4"><label for="io4"></label>
                                                    <input type="radio" name="initiative" id="io3" value="3"><label for="io3"></label>
                                                    <input type="radio" name="initiative" id="io2" value="2"><label for="io2"></label>
                                                    <input type="radio" name="initiative" id="io1" value="1"><label for="io1"></label>
                                                </div>
                                            </div>
                                            <div>
                                                <label>Time Management (1–5)</label>
                                                <div class="rating">
                                                    <input type="radio" name="time_management" id="tm5" value="5"><label for="tm5"></label>
                                                    <input type="radio" name="time_management" id="tm4" value="4"><label for="tm4"></label>
                                                    <input type="radio" name="time_management" id="tm3" value="3"><label for="tm3"></label>
                                                    <input type="radio" name="time_management" id="tm2" value="2"><label for="tm2"></label>
                                                    <input type="radio" name="time_management" id="tm1" value="1"><label for="tm1"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section">
                                        <h3>4. Overall Evaluation</h3>
                                        <div class="grid">
                                            <div>
                                                <label>Technical Skills (40%)</label>
                                                <input type="range" name="technical_skills" min="0" max="40" value="0" class="score-slider" data-max="40">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 40 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Task Delivery (25%)</label>
                                                <input type="range" name="task_delivery" min="0" max="25" value="0" class="score-slider" data-max="25">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 25 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Quality of Work (15%)</label>
                                                <input type="range" name="quality_work" min="0" max="15" value="0" class="score-slider" data-max="15">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 15 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Communication (10%)</label>
                                                <input type="range" name="communication_score" min="0" max="10" value="0" class="score-slider" data-max="10">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 10 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Behavior & Teamwork (10%)</label>
                                                <input type="range" name="teamwork_score" min="0" max="10" value="0" class="score-slider" data-max="10">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 10 (0%)</span>
                                            </div>
                                            <div>
                                                <label>Overall Rating (out of 100)</label>
                                                <input type="range" name="overall_rating" min="0" max="100" value="0" class="score-slider" data-max="100">
                                                <div class="progress-bar"><div class="progress-fill"></div></div>
                                                <span class="score-display">0 / 100 (0%)</span>
                                            </div>
                                        </div>
                                        <label>Performance Grade</label>
                                        <select name="performance_grade">
                                            <option>Excellent</option>
                                            <option>Good</option>
                                            <option>Satisfactory</option>
                                            <option>Needs Improvement</option>
                                        </select>
                                    </div>

                                    <div class="section">
                                        <h3>Manager's Feedback</h3>
                                        <textarea name="manager_final_feedback" placeholder="Summary of strengths, areas for improvement, and training recommendations"></textarea>
                                    </div>

                                    <button type="submit">Submit Performance Report</button>
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

    // Handle range sliders
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
}
</style>
@endsection
