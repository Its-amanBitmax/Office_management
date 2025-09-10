<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salarySlip->employee->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .slip-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }
        .employee-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            width: 30%;
            background-color: #f8f9fa;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .salary-table th,
        .salary-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .salary-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .earnings-section {
            background-color: #e8f5e8;
        }
        .deductions-section {
            background-color: #ffe8e8;
        }
        .total-row {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .net-salary {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin: 30px 0;
            padding: 20px;
            border: 2px solid #28a745;
            border-radius: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 50px;
        }
        .signature-cell {
            display: table-cell;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            margin: 40px auto 10px auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 10px;">
            @php
                $admin = \App\Models\Admin::first();
            @endphp
            @if($admin && $admin->company_logo)
                <img src="{{ asset('storage/' . $admin->company_logo) }}" alt="Company Logo" style="height: 50px; object-fit: contain;">
            @endif
            <div class="company-name">{{ $admin->company_name ?? 'Task Manager System' }}</div>
        </div>
        <div class="slip-title">Salary Slip</div>
        <div>Month: {{ \Carbon\Carbon::createFromFormat('Y-m', $salarySlip->month)->format('F Y') }}</div>
    </div>

    <div class="employee-info">
        <div class="info-row">
            <div class="info-cell info-label">Employee Name:</div>
            <div class="info-cell">{{ $salarySlip->employee->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Employee ID:</div>
            <div class="info-cell">{{ $salarySlip->employee->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Email:</div>
            <div class="info-cell">{{ $salarySlip->employee->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Department:</div>
            <div class="info-cell">{{ $salarySlip->employee->department ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Generated Date:</div>
            <div class="info-cell">{{ $salarySlip->generated_at->format('d M Y') }}</div>
        </div>
    </div>

    <table class="salary-table">
        <thead>
            <tr>
                <th colspan="2" class="earnings-section">Earnings</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td style="text-align: right;">₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td>HRA</td>
                <td style="text-align: right;">₹{{ number_format($salarySlip->hra, 2) }}</td>
            </tr>
            <tr>
                <td>Conveyance Allowance</td>
                <td style="text-align: right;">₹{{ number_format($salarySlip->conveyance, 2) }}</td>
            </tr>
            <tr>
                <td>Medical Allowance</td>
                <td style="text-align: right;">₹{{ number_format($salarySlip->medical, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Gross Salary</strong></td>
                <td style="text-align: right;"><strong>₹{{ number_format($salarySlip->gross_salary, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if($salarySlip->deductions && count($salarySlip->deductions) > 0)
        <table class="salary-table">
            <thead>
                <tr>
                    <th colspan="2" class="deductions-section">Deductions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salarySlip->deductions as $deduction)
                    <tr>
                        <td>{{ $deduction['type'] }}</td>
                        <td style="text-align: right;">₹{{ number_format($deduction['amount'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>Total Deductions</strong></td>
                    <td style="text-align: right;"><strong>₹{{ number_format(collect($salarySlip->deductions)->sum('amount'), 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="net-salary">
        Net Salary: ₹{{ number_format($salarySlip->net_salary, 2) }}
    </div>

    <table class="salary-table">
        <thead>
            <tr>
                <th colspan="4">Attendance Summary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Working Days</td>
                <td>Present Days</td>
                <td>Absent Days</td>
                <td>Leave Days</td>
            </tr>
            <tr>
                <td>{{ $salarySlip->total_working_days }}</td>
                <td>{{ $salarySlip->present_days }}</td>
                <td>{{ $salarySlip->absent_days }}</td>
                <td>{{ $salarySlip->leave_days }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-cell">
            <div class="signature-line"></div>
            <div>Employee Signature</div>
        </div>
        <div class="signature-cell">
            <div class="signature-line"></div>
            <div>Authorized Signature</div>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated salary slip and does not require signature.</p>
        <p>Generated on {{ now()->format('d M Y \a\t h:i A') }}</p>
    </div>
</body>
</html>
