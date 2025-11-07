<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Report - {{ $report->employee->name ?? 'Employee' }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            line-height: 1.4;
            font-size: 11px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 5px;
        }
        .company-logo-img {
            height: 40px;
            object-fit: contain;
            max-width: 100px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }
        .report-title {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .report-period {
            font-size: 12px;
            color: #007bff;
        }
        .employee-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow: hidden;
            font-size: 10px;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 6px 10px;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            width: 35%;
            background-color: #f8f9fa;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow: hidden;
        }
        .section-header {
            background-color: #f8f9fa;
            padding: 8px 10px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .section-content {
            padding: 10px;
        }
        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .metrics-table th, .metrics-table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }
        .metrics-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .progress-bar {
            height: 15px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin: 2px 0;
        }
        .progress-fill {
            height: 100%;
            background-color: #007bff;
        }
        .rating-text {
            font-size: 9px;
            text-align: center;
            margin-top: 2px;
        }
        .overall-summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-cell {
            display: table-cell;
            text-align: center;
            padding: 10px;
            vertical-align: top;
        }
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .grade-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .grade-excellent { background-color: #28a745; }
        .grade-good { background-color: #007bff; }
        .grade-satisfactory { background-color: #ffc107; color: #000; }
        .grade-poor { background-color: #dc3545; }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
        }
        @media print {
            body { font-size: 9px; padding: 10px; }
            .header { margin-bottom: 15px; padding-bottom: 10px; }
        }
    </style>
</head>
<body>
    <div class="header">
       <div class="company-logo-section">
    <img src="{{ $logo }}" alt="Company Logo" class="company-logo-img">
    <div class="company-name">{{ $company_name }}</div>
</div>
        <div class="report-title">PERFORMANCE EVALUATION REPORT</div>
        <div class="report-period">
            Review Period: {{ \Carbon\Carbon::parse($report->review_from)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($report->review_to)->format('M d, Y') }}
        </div>
    </div>

    <!-- Evaluation Assignments Card -->
    <div class="section">
        <div class="section-header">Evaluation Assignments</div>
        <div class="section-content">
            <div style="display: table; width: 100%;">
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f8f9fa; width: 30%;">Step 1 - Manager Evaluation</div>
                    <div style="display: table-cell; padding: 8px; border: 1px solid #ddd;">
                        @if(isset($step1Assignments) && count($step1Assignments->assigned_admins ?? []) > 0)
                            @foreach($step1Assignments->assigned_admins as $adminId)
                                @php
                                    $admin = \App\Models\Admin::find($adminId);
                                @endphp
                                @if($admin)
                                    {{ $admin->name }}@if(!$loop->last), @endif
                                @endif
                            @endforeach
                        @else
                            No admins assigned
                        @endif
                    </div>
                </div>
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f8f9fa; width: 30%;">Step 2 - HR Evaluation</div>
                    <div style="display: table-cell; padding: 8px; border: 1px solid #ddd;">
                        @if(isset($step2Assignments) && count($step2Assignments->assigned_admins ?? []) > 0)
                            @foreach($step2Assignments->assigned_admins as $adminId)
                                @php
                                    $admin = \App\Models\Admin::find($adminId);
                                @endphp
                                @if($admin)
                                    {{ $admin->name }}@if(!$loop->last), @endif
                                @endif
                            @endforeach
                        @else
                            No admins assigned
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="employee-info">
        <div class="info-row">
            <div class="info-cell info-label">Employee Name</div>
            <div class="info-cell">{{ $report->employee->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Employee Code</div>
            <div class="info-cell">{{ $report->employee->employee_code ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Designation</div>
            <div class="info-cell">{{ $report->designation ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Reporting Manager</div>
            <div class="info-cell">{{ $report->reporting_manager ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Evaluation Date</div>
            <div class="info-cell">{{ \Carbon\Carbon::parse($report->evaluation_date)->format('M d, Y') }}</div>
        </div>
    </div>

    @if($report->overallEvaluation)
    <div class="overall-summary">
        <h4 style="margin: 0 0 15px 0; text-align: center; color: #333;">Overall Performance Summary</h4>
        <div class="summary-grid">
            <div class="summary-cell">
                <div class="summary-value">{{ $report->overallEvaluation->overall_rating }}/100</div>
                <div class="summary-label">Overall Rating</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $report->overallEvaluation->technical_skills }}/40</div>
                <div class="summary-label">Technical Skills</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $report->overallEvaluation->task_delivery }}/25</div>
                <div class="summary-label">Task Delivery</div>
            </div>
            <div class="summary-cell">
                <div class="summary-value">{{ $report->overallEvaluation->communication + $report->overallEvaluation->behavior_teamwork }}/20</div>
                <div class="summary-label">Soft Skills</div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <span class="grade-badge
                @if($report->overallEvaluation->performance_grade == 'Excellent') grade-excellent
                @elseif($report->overallEvaluation->performance_grade == 'Good') grade-good
                @elseif($report->overallEvaluation->performance_grade == 'Satisfactory') grade-satisfactory
                @else grade-poor
                @endif">
                {{ $report->overallEvaluation->performance_grade }}
            </span>
            <div style="margin-top: 5px; font-size: 10px; color: #666;">
                Quality of Work: {{ $report->overallEvaluation->quality_work }}/15
            </div>
        </div>
    </div>
    @endif

    @if($report->evaluationManager)
    <div class="section">
        <div class="section-header">Manager Evaluation</div>
        <div class="section-content">
            <table class="metrics-table">
                <tr><th>Project Delivery</th><td>{{ $report->evaluationManager->project_delivery ?: 'Not specified' }}</td></tr>
                <tr><th>Code Quality</th><td>{{ $report->evaluationManager->code_quality ?: 'Not specified' }}</td></tr>
                <tr><th>Performance</th><td>{{ $report->evaluationManager->performance ?: 'Not specified' }}</td></tr>
                <tr><th>Task Completion</th><td>{{ $report->evaluationManager->task_completion ?: 'Not specified' }}</td></tr>
                <tr><th>Innovation</th><td>{{ $report->evaluationManager->innovation ?: 'Not specified' }}</td></tr>
                <tr><th>Manager Comments</th><td>{{ $report->evaluationManager->manager_comments ?: 'Not specified' }}</td></tr>
            </table>
        </div>
    </div>
    @endif

    @if($report->evaluationHr)
    <div class="section">
        <div class="section-header">HR Evaluation</div>
        <div class="section-content">
            <table class="metrics-table">
                <tr><th>Teamwork</th><td>{{ $report->evaluationHr->teamwork ?: 'Not specified' }}</td></tr>
                <tr><th>Communication</th><td>{{ $report->evaluationHr->communication ?: 'Not specified' }}</td></tr>
                <tr><th>Attendance</th><td>{{ $report->evaluationHr->attendance ?: 'Not specified' }}</td></tr>
                <tr><th>HR Comments</th><td>{{ $report->evaluationHr->hr_comments ?: 'Not specified' }}</td></tr>
            </table>
        </div>
    </div>
    @endif

    @if($report->evaluationManager)
    <div class="section">
        <div class="section-header">Manager Evaluation Ratings</div>
        <div class="section-content">
            <table class="metrics-table">
                <tr>
                    <th>Code Efficiency</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationManager->code_efficiency / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationManager->code_efficiency }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>UI/UX</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationManager->uiux / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationManager->uiux }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Debugging</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationManager->debugging / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationManager->debugging }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Version Control</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationManager->version_control / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationManager->version_control }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Documentation</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationManager->documentation / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationManager->documentation }}/5</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    @if($report->evaluationHr)
    <div class="section">
        <div class="section-header">HR Evaluation Ratings</div>
        <div class="section-content">
            <table class="metrics-table">
                <tr>
                    <th>Professionalism</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationHr->professionalism / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationHr->professionalism }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Team Collaboration</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationHr->team_collaboration / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationHr->team_collaboration }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Learning & Adaptability</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationHr->learning / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationHr->learning }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Initiative & Ownership</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationHr->initiative / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationHr->initiative }}/5</div>
                    </td>
                </tr>
                <tr>
                    <th>Time Management</th>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($report->evaluationHr->time_management / 5) * 100 }}%"></div>
                        </div>
                        <div class="rating-text">{{ $report->evaluationHr->time_management }}/5</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    @if($report->manager_feedback)
    <div class="section">
        <div class="section-header">Manager's Final Feedback</div>
        <div class="section-content">
            <p style="margin: 0; font-style: italic;">{{ $report->manager_feedback }}</p>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated evaluation report.</p>
        <p>Generated on {{ now()->format('d M Y \a\t h:i A') }} | Confidential - For Internal Use Only</p>
    </div>
</body>
</html>
