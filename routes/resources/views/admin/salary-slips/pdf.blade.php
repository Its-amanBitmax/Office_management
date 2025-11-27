<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salarySlip->employee->name ?? 'Employee' }}</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0; 
            padding: 15px; 
            color: #333; 
            line-height: 1.3; 
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
        .slip-title { 
            font-size: 16px; 
            color: #666; 
            margin-bottom: 5px; 
            font-weight: bold; 
        }
        .slip-period { 
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
        .salary-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            border: 1px solid #ddd; 
            border-radius: 3px; 
            overflow: hidden; 
            font-size: 10px; 
        }
        .salary-table th, .salary-table td { 
            border: 1px solid #ddd; 
            padding: 6px 8px; 
            text-align: left; 
        }
        .salary-table th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            text-align: center; 
        }
        .earnings-section th { 
            background-color: #e8f5e8; 
            color: #28a745; 
        }
        .deductions-section th { 
            background-color: #ffe8e8; 
            color: #dc3545; 
        }
        .total-row { 
            background-color: #007bff; 
            color: white; 
            font-weight: bold; 
        }
        .total-row td { 
            text-align: right; 
        }
        .net-salary { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            color: #28a745; 
            margin: 15px 0; 
            padding: 15px; 
            border: 2px solid #28a745; 
            border-radius: 5px; 
            background-color: #f8fff9; 
        }
        .attendance-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
            border: 1px solid #ddd; 
            border-radius: 3px; 
            overflow: hidden; 
            font-size: 10px; 
        }
        .attendance-table th, .attendance-table td { 
            border: 1px solid #ddd; 
            padding: 6px 8px; 
            text-align: center; 
        }
        .attendance-table th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
        }
        .present { color: #28a745; }
        .absent { color: #dc3545; }
        .leave { color: #ffc107; }
        .half { color: #17a2b8; }
        .holiday { color: #007bff; }
        .signature-section { 
            display: table; 
            width: 100%; 
            margin-top: 30px; 
        }
        .signature-cell { 
            display: table-cell; 
            text-align: center; 
            vertical-align: top; 
            width: 50%; 
            padding: 0 10px; 
        }
        .signature-line { 
            border-bottom: 1px solid #333; 
            width: 150px; 
            margin: 30px auto 5px auto; 
        }
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
            .net-salary { margin: 10px 0; padding: 10px; font-size: 14px; }
        }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
  <div class="header">
    <div class="company-logo-section">
        <!-- Hardcoded logo -->
        <img src="{{ public_path('images/logo.png') }}" alt="Company Logo" class="company-logo-img">

             alt="Company Logo" class="company-logo-img">

        <div class="company-name">Bitmax Group</div>
    </div>

    <div class="slip-title">PAY SLIP</div>

    <div class="slip-period">
        Pay Period: 
        @if($salarySlip->month && $salarySlip->year)
            @php
                try {
                    $monthDate = \Carbon\Carbon::create($salarySlip->year, (int)$salarySlip->month, 1);
                    echo $monthDate->format('F Y');
                } catch (\Exception $e) {
                    echo now()->format('F Y');
                }
            @endphp
        @else
            {{ now()->format('F Y') }}
        @endif
    </div>
</div>

    <div class="employee-info">
        <div class="info-row">
            <div class="info-cell info-label">Employee Name</div>
            <div class="info-cell">{{ $salarySlip->employee->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Employee Code</div>
            <div class="info-cell">{{ $salarySlip->employee->employee_code ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Email</div>
            <div class="info-cell">{{ $salarySlip->employee->email ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Department</div>
            <div class="info-cell">{{ $salarySlip->employee->department ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell info-label">Generated Date</div>
            <div class="info-cell">
                @if($salarySlip->generated_at)
                    @php
                        try {
                            $genDate = \Carbon\Carbon::parse($salarySlip->generated_at);
                            echo $genDate->format('d M Y');
                        } catch (\Exception $e) {
                            echo now()->format('d M Y');
                        }
                    @endphp
                @else
                    {{ now()->format('d M Y') }}
                @endif
            </div>
        </div>
    </div>

    <table class="salary-table">
        <thead>
            <tr>
                <th colspan="2" class="earnings-section">EARNINGS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td style="text-align: right;">&#8377;{{ number_format($salarySlip->basic_salary ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td>HRA</td>
                <td style="text-align: right;">&#8377;{{ number_format($salarySlip->hra ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td>Conveyance Allowance</td>
                <td style="text-align: right;">&#8377;{{ number_format($salarySlip->conveyance ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td>Medical Allowance</td>
                <td style="text-align: right;">&#8377;{{ number_format($salarySlip->medical ?? 0, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Gross Salary</td>
                <td>&#8377;{{ number_format($salarySlip->gross_salary ?? 0, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @php
        $deductions = is_array($salarySlip->deductions) ? $salarySlip->deductions : json_decode($salarySlip->deductions, true) ?? [];
    @endphp

    @if(count($deductions) > 0)
        <table class="salary-table">
            <thead>
                <tr>
                    <th colspan="2" class="deductions-section">DEDUCTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deductions as $deduction)
                    <tr>
                        <td>{{ ucfirst($deduction['type'] ?? 'Unknown') }}</td>
                        <td style="text-align: right;">&#8377;{{ number_format($deduction['amount'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td>&#8377;{{ number_format(collect($deductions)->sum('amount'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="net-salary">
        NET SALARY: &#8377;{{ number_format($salarySlip->net_salary ?? 0, 2) }}
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th colspan="6">ATTENDANCE SUMMARY</th>
            </tr>
            <tr>
                <th>Total Working Days</th>
                <th class="present">Present Days</th>
                <th class="absent">Absent Days</th>
                <th class="leave">Leave Days</th>
                <th class="half">Half Days</th>
                <th class="holiday">Holiday Days</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $salarySlip->total_working_days ?? 0 }}</td>
                <td class="present">{{ $salarySlip->present_days ?? 0 }}</td>
                <td class="absent">{{ $salarySlip->absent_days ?? 0 }}</td>
                <td class="leave">{{ $salarySlip->leave_days ?? 0 }}</td>
                <td class="half">{{ $salarySlip->half_day_count ?? 0 }}</td>
                <td class="holiday">{{ $salarySlip->holiday_days ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated salary slip and does not require signature.</p>
        <p>Generated on {{ now()->format('d M Y \a\t h:i A') }} | Confidential - For Internal Use Only</p>
    </div>
</body>
</html>