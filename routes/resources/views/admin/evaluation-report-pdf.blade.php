
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Evaluation Report - {{ $report->employee->name ?? 'Employee' }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; font-size: 12px; }
        .container { width: 100%; padding: 18px; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .logo { height:60px; }
        .company { text-align:right; }
        .section { border:1px solid #e6e6e6; border-radius:6px; margin-top:12px; }
        .section .head { background:#f5f7fa; padding:8px 12px; font-weight:700; }
        .section .body { padding:12px; }
        table { width:100%; border-collapse:collapse; }
        td, th { padding:6px 8px; vertical-align:top; }
        .kpi-box { background:#f9fafb; padding:8px; border-radius:4px; text-align:center; }
        .big { font-size:18px; font-weight:700; color:#0066cc; }
        .badge { display:inline-block; padding:4px 8px; border-radius:4px; color:#fff; }
        .bg-success{background:#28a745}.bg-primary{background:#007bff}.bg-warning{background:#ffc107;color:#000}.bg-danger{background:#dc3545}
        .small-muted{color:#6c757d;font-size:11px}
        .right { text-align:right }
    </style>
</head>
<body>
<div class="container">
    @php
        // Fetch values computed in controller
        $employee = $report->employee ?? null;
        $manager = $report->evaluationManager ?? null;
        $hr = $report->evaluationHr ?? null;
        $overall = $report->evaluationOverall ?? null;

        // Controller-provided totals
        $managerTotal = $manager->manager_total ?? 0; // out of 30
        $hrTotal = $hr->hr_total ?? 0; // out of 20
        // overall stored as out of 50
        $overall50 = $overall->overall_rating ?? 0; // out of 50
        $overall100 = $overall50 * 2; // converted to 100 scale for display
        $grandTotal = $managerTotal + $hrTotal + $overall50; // out of 100

        $grade = optional($overall)->performance_grade ?? 'N/A';
    @endphp

    <div class="header">
        <div class="left">
            @if(isset($logo) && $logo)
                <img src="{{ $logo }}" class="logo" alt="logo">
            @else
                <img src="{{ asset('storage/company_logos/1757255508.png') }}" class="logo" alt="logo">
            @endif
        </div>
        <div class="company">
            <div style="font-size:20px;font-weight:700">{{ $company_name ?? 'Company' }}</div>
            <div class="small-muted">Performance Evaluation Report</div>
            <div class="small-muted">Review: {{ $report->review_from ? \Carbon\Carbon::parse($report->review_from)->format('M d, Y') : 'N/A' }} — {{ $report->review_to ? \Carbon\Carbon::parse($report->review_to)->format('M d, Y') : 'N/A' }}</div>
        </div>
    </div>

    <!-- Employee Info -->
    <div class="section">
        <div class="head">Employee Information</div>
        <div class="body">
            <table>
                <tr>
                    <td style="width:120px">
                        @if($employee && $employee->profile_image)
                            <img src="{{ asset('storage/profile_images/' . $employee->profile_image) }}" alt="Profile" style="width:100px;height:100px;object-fit:cover;border-radius:6px">
                        @else
                            <div style="width:100px;height:100px;background:#f1f1f1;border-radius:6px;display:flex;align-items:center;justify-content:center">No Image</div>
                        @endif
                    </td>
                    <td>
                        <h3 style="margin:0">{{ $employee->name ?? 'N/A' }}</h3>
                        <div class="small-muted">{{ $employee->employee_code ?? 'N/A' }} • {{ $employee->position ?? 'N/A' }}</div>
                        <div style="margin-top:8px"><strong>Evaluation Date:</strong> {{ $report->evaluation_date ? \Carbon\Carbon::parse($report->evaluation_date)->format('M d, Y') : 'N/A' }}</div>
                        <div class="small-muted">Status: <strong>{{ ucfirst($report->status ?? 'draft') }}</strong></div>
                    </td>
                    <td class="right" style="width:160px">
                        <div class="kpi-box">
                            <div class="small-muted">Grand Total (100)</div>
                            <div class="big">{{ number_format($grandTotal,2) }} / 100</div>
                            <div style="margin-top:6px"> <span class="badge @if($grade=='Excellent') bg-success @elseif($grade=='Good') bg-primary @elseif($grade=='Satisfactory') bg-warning @else bg-danger @endif">{{ $grade }}</span></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Manager Section -->
    <div class="section">
        <div class="head">Manager Evaluation</div>
        <div class="body">
            <table>
                <tr>
                    <td style="width:50%">
                        <strong>Technical KPIs</strong>
                        <table>
                            <tr><td style="width:180px">Project Delivery</td><td>{{ $manager->project_delivery ?? 'Not specified' }}</td></tr>
                            <tr><td>Code Quality</td><td>{{ $manager->code_quality ?? 'Not specified' }}</td></tr>
                            <tr><td>Performance</td><td>{{ $manager->performance ?? 'Not specified' }}</td></tr>
                            <tr><td>Task Completion</td><td>{{ $manager->task_completion ?? 'Not specified' }}</td></tr>
                            <tr><td>Innovation</td><td>{{ $manager->innovation ?? 'Not specified' }}</td></tr>
                        </table>
                    </td>
                    <td style="width:50%">
                        <strong>Quality Metrics (ratings)</strong>
                        <table>
                            <tr><td style="width:140px">Code Efficiency</td><td>{{ $manager->code_efficiency ?? 0 }} / 5</td></tr>
                            <tr><td>UI/UX</td><td>{{ $manager->uiux ?? 0 }} / 5</td></tr>
                            <tr><td>Debugging</td><td>{{ $manager->debugging ?? 0 }} / 5</td></tr>
                            <tr><td>Version Control</td><td>{{ $manager->version_control ?? 0 }} / 5</td></tr>
                            <tr><td>Documentation</td><td>{{ $manager->documentation ?? 0 }} / 5</td></tr>
                            <tr><td><strong>Total Score</strong></td><td><strong>{{ number_format($managerTotal,2) }} / 30</strong></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:12px">
                        <strong>Manager Comments:</strong>
                        <div class="small-muted">{!! nl2br(e($manager->manager_comments ?? 'No comments')) !!}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- HR Section -->
    <div class="section">
        <div class="head">HR Evaluation</div>
        <div class="body">
            <table>
                <tr>
                    <td style="width:50%">
                        <strong>Soft Skills</strong>
                        <table>
                            <tr><td style="width:180px">Teamwork</td><td>{{ $hr->teamwork ?? 'Not specified' }}</td></tr>
                            <tr><td>Communication</td><td>{{ $hr->communication ?? 'Not specified' }}</td></tr>
                            <tr><td>Attendance</td><td>{{ $hr->attendance ?? 'Not specified' }}</td></tr>
                        </table>
                    </td>
                    <td style="width:50%">
                        <strong>Behavioral Metrics (ratings)</strong>
                        <table>
                            <tr><td style="width:140px">Professionalism</td><td>{{ $hr->professionalism ?? 0 }} / 5</td></tr>
                            <tr><td>Team Collaboration</td><td>{{ $hr->team_collaboration ?? 0 }} / 5</td></tr>
                            <tr><td>Learning</td><td>{{ $hr->learning ?? 0 }} / 5</td></tr>
                            <tr><td>Initiative</td><td>{{ $hr->initiative ?? 0 }} / 5</td></tr>
                            <tr><td>Time Management</td><td>{{ $hr->time_management ?? 0 }} / 5</td></tr>
                            <tr><td><strong>Total Score</strong></td><td><strong>{{ number_format($hrTotal,2) }} / 20</strong></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:12px">
                        <strong>HR Comments:</strong>
                        <div class="small-muted">{!! nl2br(e($hr->hr_comments ?? 'No comments')) !!}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Overall Section -->
    <div class="section">
        <div class="head">Overall Evaluation</div>
        <div class="body">
            <table>
                <tr>
                    <td style="width:60%">
                        <strong>KPIs (scores)</strong>
                        <table>
                            <tr><td style="width:220px">Technical Skills</td><td>{{ $overall->technical_skills ?? 0 }} / 10</td></tr>
                            <tr><td>Task Delivery</td><td>{{ $overall->task_delivery ?? 0 }} / 10</td></tr>
                            <tr><td>Quality of Work</td><td>{{ $overall->quality_work ?? 0 }} / 10</td></tr>
                            <tr><td>Communication</td><td>{{ $overall->communication ?? 0 }} / 10</td></tr>
                            <tr><td>Behavior / Teamwork</td><td>{{ $overall->behavior_teamwork ?? 0 }} / 10</td></tr>
                        </table>
                    </td>
                    <td style="width:40%">
                        <div style="text-align:center;margin-top:6px">
                            <div class="small-muted">Overall (50)</div>
                            <div class="big">{{ number_format($overall50,2) }} / 50</div>
                            <div style="margin-top:8px" class="small-muted">Converted: <strong>{{ number_format($overall100,2) }} / 100</strong></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:12px">
                        <strong>Final Feedback:</strong>
                        <div class="small-muted">{!! nl2br(e($overall->final_feedback ?? 'No feedback')) !!}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Final Scores -->
    <div class="section">
        <div class="head">Final Scores & Grade</div>
        <div class="body">
            <table>
                <tr>
                    <td style="width:60%">
                        <strong>Breakdown</strong>
                        <table>
                            <tr><td style="width:220px">Manager Evaluation (30)</td><td>{{ number_format($managerTotal,2) }} / 30</td></tr>
                            <tr><td>HR Evaluation (20)</td><td>{{ number_format($hrTotal,2) }} / 20</td></tr>
                            <tr><td>Overall (50)</td><td>{{ number_format($overall50,2) }} / 50</td></tr>
                        </table>
                    </td>
                    <td style="width:40%">
                        <div style="text-align:center">
                            <div class="small-muted">Grand Total (100)</div>
                            <div class="big">{{ number_format($grandTotal,2) }} / 100</div>
                            <div style="margin-top:8px"><span class="badge @if($grade=='Excellent') bg-success @elseif($grade=='Good') bg-primary @elseif($grade=='Satisfactory') bg-warning @else bg-danger @endif">{{ $grade }}</span></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="margin-top:18px;text-align:center;font-size:11px;color:#666">Generated by {{ $company_name ?? 'Company' }} on {{ now()->format('d M Y h:i A') }}</div>
</div>
</body>
</html>
