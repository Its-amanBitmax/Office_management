<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class MonthlyAttendanceExport implements FromCollection, WithHeadings, WithTitle
{
    protected $employeeId;
    protected $month;
    protected $year;

    public function __construct($employeeId, $month, $year)
    {
        $this->employeeId = $employeeId;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        if ($this->employeeId === 'all') {
            // Export for all employees in matrix format (similar to web view)
            $date = Carbon::create($this->year, $this->month, 1, 0, 0, 0, 'Asia/Kolkata');
            $daysInMonth = $date->daysInMonth;

            $attendances = Attendance::with('employee')
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->orderBy('employee_id')
                ->orderBy('date')
                ->get();

            $grouped = $attendances->groupBy('employee_id');

            $exportData = [];

            // Create header row 1: Employee Name + Day numbers with day abbreviations
            $headerRow1 = ['Employee Name'];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($this->year, $this->month, $day, 0, 0, 0, 'Asia/Kolkata');
                $headerRow1[] = $day . ' (' . $currentDate->format('D') . ')';
            }
            $headerRow1 = array_merge($headerRow1, ['Total Days', 'Present', 'Absent', 'Leave', 'Half Day', 'Holiday']);
            $exportData[] = $headerRow1;

            // Create header row 2: Employee Name + Dates
            $headerRow2 = ['Employee Name'];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($this->year, $this->month, $day, 0, 0, 0, 'Asia/Kolkata');
                $headerRow2[] = $currentDate->format('d');
            }
            $headerRow2 = array_merge($headerRow2, ['Total Days', 'Present', 'Absent', 'Leave', 'Half Day', 'Holiday']);
            $exportData[] = $headerRow2;

            // Get all employees and add data rows for each (even those without attendance)
            $employees = \App\Models\Employee::all();
            foreach ($employees as $employee) {
                $records = $grouped->get($employee->id, collect());

                // Calculate summary for this employee
                $summary = [
                    'total_days' => $records->count(),
                    'present' => $records->where('status', 'Present')->count(),
                    'absent' => $records->where('status', 'Absent')->count(),
                    'leave' => $records->where('status', 'Leave')->count(),
                    'half_day' => $records->where('status', 'Half Day')->count(),
                    'holiday' => $records->where('status', 'Holiday')->count(),
                ];

                $row = [$employee->name];

                // Add daily status for each day
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = Carbon::create($this->year, $this->month, $day, 0, 0, 0, 'Asia/Kolkata');
                    $attendance = $records->first(function ($item) use ($currentDate) {
                        return $item->date->format('Y-m-d') === $currentDate->format('Y-m-d');
                    });

                    if ($attendance) {
                        if ($attendance->status == 'Present') {
                            $status = 'P';
                        } elseif ($attendance->status == 'Absent') {
                            $status = 'A';
                        } elseif ($attendance->status == 'Leave') {
                            $status = 'L';
                        } elseif ($attendance->status == 'Half Day') {
                            $status = 'HD';
                        } elseif ($attendance->status == 'Holiday') {
                            $status = 'H';
                        } else {
                            $status = $attendance->status;
                        }
                    } else {
                        $status = 'NM';
                    }

                    $row[] = $status;
                }

                // Add summary columns
                $row = array_merge($row, [
                    $summary['total_days'],
                    $summary['present'],
                    $summary['absent'],
                    $summary['leave'],
                    $summary['half_day'],
                    $summary['holiday']
                ]);

                $exportData[] = $row;
            }

            return collect($exportData);
        } else {
            $employee = Employee::findOrFail($this->employeeId);

            // Get attendance data for the selected month and employee
            $attendances = Attendance::where('employee_id', $this->employeeId)
                ->whereYear('date', $this->year)
                ->whereMonth('date', $this->month)
                ->orderBy('date')
                ->get();

            // Calculate summary
            $summary = [
                'total_days' => $attendances->count(),
                'present' => $attendances->where('status', 'Present')->count(),
                'absent' => $attendances->where('status', 'Absent')->count(),
                'leave' => $attendances->where('status', 'Leave')->count(),
                'half_day' => $attendances->where('status', 'Half Day')->count(),
                'holiday' => $attendances->where('status', 'Holiday')->count(),
            ];

            // Get all days in the month for calendar view
            $date = Carbon::create($this->year, $this->month, 1, 0, 0, 0, 'Asia/Kolkata');
            $daysInMonth = $date->daysInMonth;
            $monthlyData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($this->year, $this->month, $day, 0, 0, 0, 'Asia/Kolkata');
                $attendance = $attendances->firstWhere('date', $currentDate->format('Y-m-d'));

                $monthlyData[] = [
                    'Employee Name' => $employee->name,
                    'Date' => $currentDate->format('Y-m-d'),
                    'Day' => $currentDate->format('D'),
                    'Status' => $attendance ? $attendance->status : 'Not Marked',
                    'Marked At' => $attendance ? $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i') : '-',
                    'Remarks' => $attendance ? $attendance->remarks : '-',
                ];
            }

            // Add summary row
            $monthlyData[] = [
                'Employee Name' => '',
                'Date' => '',
                'Day' => '',
                'Status' => '',
                'Marked At' => '',
                'Remarks' => '',
            ];

            $monthlyData[] = [
                'Employee Name' => 'SUMMARY',
                'Date' => 'Total Days: ' . $summary['total_days'],
                'Day' => 'Present: ' . $summary['present'],
                'Status' => 'Absent: ' . $summary['absent'],
                'Marked At' => 'Leave: ' . $summary['leave'],
                'Remarks' => 'HD: ' . $summary['half_day'] . ' | H: ' . $summary['holiday'],
            ];

            return collect($monthlyData);
        }
    }

    public function headings(): array
    {
        if ($this->employeeId === 'all') {
            // For all employees, headings are created in collection() method
            return [];
        } else {
            return [
                'Employee Name',
                'Date',
                'Day',
                'Status',
                'Marked At',
                'Remarks',
            ];
        }
    }

    public function title(): string
    {
        $monthName = Carbon::create($this->year, $this->month, 1)->format('F Y');

        if ($this->employeeId === 'all') {
            return 'All Employees - ' . $monthName;
        } else {
            $employee = Employee::findOrFail($this->employeeId);
            return $employee->name . ' - ' . $monthName;
        }
    }
}