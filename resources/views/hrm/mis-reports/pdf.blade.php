<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HR MIS Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            width: 120px;
        }

        .company-info {
            text-align: right;
            font-size: 13px;
        }

        h2 {
            text-align: center;
            margin: 10px 0 5px;
            text-transform: uppercase;
        }

        .meta {
            margin-bottom: 15px;
            font-size: 12px;
        }

        .meta strong {
            width: 150px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        .section-title {
            background: #e9ecef;
            padding: 6px;
            font-weight: bold;
            border: 1px solid #000;
            margin-top: 12px;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
        }

        .signature {
            margin-top: 50px;
            width: 100%;
        }

        .signature div {
            width: 33%;
            float: left;
            text-align: center;
        }
    </style>
</head>

<body>

{{-- ================= Header ================= --}}
<div class="header">
    <table>
        <tr>
            <td>
                <img src="{{ public_path('storage/company_logos/1757255508.png') }}" class="logo">
            </td>
            <td class="company-info">
                <strong>HR MIS REPORT</strong><br>
                Generated On: {{ now()->format('d M Y') }}
            </td>
        </tr>
    </table>
</div>

<h2>Human Resources MIS Report</h2>

{{-- ================= Meta Info ================= --}}
<div class="meta">
    <strong>Department:</strong> {{ $report->department }} <br>

    <strong>Report Type:</strong> {{ ucfirst($report->report_type) }} <br>

    @if($report->report_type == 'daily')
        <strong>Report Date:</strong>
        {{ optional($report->report_date)->format('d M Y') }}
    @elseif($report->report_type == 'weekly')
        <strong>Week:</strong>
        {{ optional($report->week_start)->format('d M Y') }}
        -
        {{ optional($report->week_end)->format('d M Y') }}
    @elseif($report->report_type == 'monthly')
        <strong>Report Month:</strong> {{ $report->report_month }} <br>
        <strong>Center / Branch:</strong> {{ $report->center_branch }}
    @endif
</div>

{{-- ================= Employee Strength ================= --}}
<div class="section-title">1. Employee Strength Summary</div>
<table>
    <tr>
        <th>Total Employees</th>
        <th>New Joiners</th>
        <th>Resignations</th>
        <th>Terminated</th>
        <th>Net Strength</th>
    </tr>
    <tr>
        <td>{{ $report->total_employees }}</td>
        <td>{{ $report->new_joiners }}</td>
        <td>{{ $report->resignations }}</td>
        <td>{{ $report->terminated }}</td>
        <td>{{ $report->net_strength }}</td>
    </tr>
</table>

{{-- ================= Attendance ================= --}}
<div class="section-title">2. Attendance Summary</div>
<table>
    <tr>
        <th>Present Days</th>
        <th>Absent Days</th>
        <th>Leaves Approved</th>
        <th>Half Days</th>
        <th>Holiday</th>
        <th>NCNS</th>
        <th>LWP</th>
    </tr>
    <tr>
        <td>{{ $report->present_days }}</td>
        <td>{{ $report->absent_days }}</td>
        <td>{{ $report->leaves_approved }}</td>
        <td>{{ $report->half_days }}</td>
        <td>{{ $report->holiday_days }}</td>
        <td>{{ $report->ncns_days }}</td>
        <td>{{ $report->lwp_days }}</td>
    </tr>
</table>

{{-- ================= Recruitment ================= --}}
<div class="section-title">3. Recruitment Summary</div>
<table>
    <tr>
        <th>Requirements Raised</th>
        <th>Positions Closed</th>
        <th>Pending</th>
        <th>Interviews</th>
        <th>Selected</th>
        <th>Rejected</th>
    </tr>
    <tr>
        <td>{{ $report->requirements_raised }}</td>
        <td>{{ $report->positions_closed }}</td>
        <td>{{ $report->positions_pending }}</td>
        <td>{{ $report->interviews_conducted }}</td>
        <td>{{ $report->selected }}</td>
        <td>{{ $report->rejected }}</td>
    </tr>
</table>

{{-- ================= Payroll ================= --}}
<div class="section-title">4. Payroll & Compliance</div>
<table>
    <tr>
        <th>Salary Processed</th>
        <th>Salary Disbursed Date</th>
    </tr>
    <tr>
        <td>{{ $report->salary_processed ? 'Yes' : 'No' }}</td>
        <td>{{ $report->salary_disbursed_date ? $report->salary_disbursed_date->format('d M Y') : '-' }}</td>
    </tr>
</table>

<p>
<strong>Deductions:</strong><br>
{{ $report->deductions ?? '-' }} <br><br>

<strong>Pending Compliance:</strong><br>
{{ $report->pending_compliance ?? '-' }}
</p>

{{-- ================= Employee Relations ================= --}}
<div class="section-title">5. Employee Relations & Grievances</div>
<table>
    <tr>
        <th>Grievances Received</th>
        <th>Resolved</th>
        <th>Warnings</th>
        <th>Appreciations</th>
    </tr>
    <tr>
        <td>{{ $report->grievances_received }}</td>
        <td>{{ $report->grievances_resolved }}</td>
        <td>{{ $report->warning_notices }}</td>
        <td>{{ $report->appreciations }}</td>
    </tr>
</table>

{{-- ================= Training ================= --}}
<div class="section-title">6. Training & Development</div>
<table>
    <tr>
        <th>Trainings Conducted</th>
        <th>Employees Attended</th>
    </tr>
    <tr>
        <td>{{ $report->trainings_conducted }}</td>
        <td>{{ $report->employees_attended }}</td>
    </tr>
</table>

<p><strong>Training Feedback:</strong><br>{{ $report->training_feedback ?? '-' }}</p>

{{-- ================= HR Activities ================= --}}
<div class="section-title">7. HR Activities & Events</div>
<p>
<strong>Birthday Celebrations:</strong><br>{{ $report->birthday_celebrations ?? '-' }}<br><br>
<strong>Engagement Activities:</strong><br>{{ $report->engagement_activities ?? '-' }}<br><br>
<strong>HR Initiatives:</strong><br>{{ $report->hr_initiatives ?? '-' }}<br><br>
<strong>Special Events:</strong><br>{{ $report->special_events ?? '-' }}
</p>

{{-- ================= Notes ================= --}}
<div class="section-title">8. Notes & Remarks</div>
<p>
<strong>Notes:</strong><br>{{ $report->notes ?? '-' }}<br><br>
<strong>Remarks:</strong><br>{{ $report->remarks ?? '-' }}
</p>

{{-- ================= Signatures ================= --}}
<div class="signature">
    <div>
        <strong>Prepared By</strong><br><br>_________________
    </div>
    <div>
        <strong>Reviewed By</strong><br><br>_________________
    </div>
    <div>
        <strong>Approved By</strong><br><br>_________________
    </div>
</div>

</body>
</html>
