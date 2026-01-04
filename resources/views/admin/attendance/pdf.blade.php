<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - {{ $selectedDate->format('d M Y') }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }
        .page {
            page-break-after: always;
            position: relative;
            min-height: 100vh;
        }
        .page:last-child {
            page-break-after: avoid;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header-left {
            display: table-cell;
            width: 20%;
            vertical-align: middle;
            text-align: left;
        }
        .header-center {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
            text-align: center;
        }
        .header-right {
            display: table-cell;
            width: 20%;
            vertical-align: middle;
            text-align: right;
        }
        .logo {
            max-width: 80px;
            max-height: 40px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .header p {
            margin: 3px 0;
            color: #7f8c8d;
            font-size: 11px;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
        }
        .stats-row {
            display: table-row;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 0 5px;
        }
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        .stat-label {
            font-size: 9px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-present { color: #28a745; font-weight: bold; }
        .status-absent { color: #dc3545; font-weight: bold; }
        .status-leave { color: #ffc107; font-weight: bold; }
        .status-half-day { color: #17a2b8; font-weight: bold; }
        .status-holiday { color: #6f42c1; font-weight: bold; }
        .status-ncns { color: #dc3545; font-weight: bold; }
        .status-lwp { color: #ffc107; font-weight: bold; }
        .status-not-marked { color: #6c757d; font-weight: bold; }
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 20px;
        }
        .page-number {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 9px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    @php
        $employeesPerPage = 20;
        $totalPages = ceil($employees->count() / $employeesPerPage);
        $currentPage = 1;
    @endphp

    @for($page = 1; $page <= $totalPages; $page++)
        <div class="page">
            @if($page === 1)
                <div class="header">
                    <div class="header-left">
<img src="{{ public_path('storage/company_logos/1757255508.png') }}"
     alt="Company Logo"
     class="logo">                    </div>
                    <div class="header-right">
                        <h1>BITMAX OFFICE CRM</h1>
                        <p>Daily Attendance Report</p>
                        <p>Date: {{ $selectedDate->format('l, F j, Y') }}</p>
                    </div>
                   
                </div>

                <div class="stats">
                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['total_employees'] }}</div>
                            <div class="stat-label">Total Employees</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['present'] }}</div>
                            <div class="stat-label">Present</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['absent'] }}</div>
                            <div class="stat-label">Absent</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['leave'] }}</div>
                            <div class="stat-label">On Leave</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['half_day'] }}</div>
                            <div class="stat-label">Half Day</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['holiday'] }}</div>
                            <div class="stat-label">Holiday</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['ncns'] }}</div>
                            <div class="stat-label">NCNS</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $stats['lwp'] }}</div>
                            <div class="stat-label">LWP</div>
                        </div>
                    </div>
                </div>
            @endif

            <table>
                @if($page === 1)
                    <thead>
                        <tr>
                            <th style="width: 6%;">S.No</th>
                            <th style="width: 30%;">Employee Name</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 12%;">Mark In</th>
                            <th style="width: 12%;">Mark Out</th>
                            <th style="width: 12%;">Break Time</th>
                            <th style="width: 16%;">Marked At</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @php
                        $startIndex = ($page - 1) * $employeesPerPage;
                        $endIndex = min($startIndex + $employeesPerPage, $employees->count());
                        $pageEmployees = $employees->slice($startIndex, $employeesPerPage);
                    @endphp
                    @foreach($pageEmployees as $index => $employee)
                        @php
                            $globalIndex = $startIndex + $index + 1;
                            $attendance = $employee->attendance->first();
                            $currentStatus = $attendance ? $attendance->status : 'Not Marked';
                            $markedAt = $attendance ? $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i:s') : '-';
                            $markIn = $attendance && $attendance->mark_in ? $attendance->mark_in : '-';
                            $markOut = $attendance && $attendance->mark_out ? $attendance->mark_out : '-';
                            $breakTime = $attendance && $attendance->break_time ? $attendance->break_time : '-';
                            $statusClass = 'status-' . strtolower(str_replace(' ', '-', $currentStatus));
                        @endphp
                        <tr>
                            <td>{{ $globalIndex }}</td>
                            <td>{{ $employee->name }}</td>
                            <td class="{{ $statusClass }}">{{ $currentStatus }}</td>
                            <td>{{ $markIn }}</td>
                            <td>{{ $markOut }}</td>
                            <td>{{ $breakTime }}</td>
                            <td>{{ $markedAt }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer">
                <p>Generated on {{ now()->setTimezone('Asia/Kolkata')->format('d M Y H:i:s') }} | BITMAX OFFICE CRM System</p>
            </div>
            <div class="page-number">Page {{ $page }} of {{ $totalPages }}</div>
        </div>
    @endfor
</body>
</html>
