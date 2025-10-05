<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTimeZone;
use App\Traits\Loggable;
use App\Exports\MonthlyAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    use Loggable;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today('Asia/Kolkata')->format('Y-m-d'));
        $selectedDate = Carbon::parse($date, 'Asia/Kolkata');

        // Get all active employees with their attendance for the selected date
        $employees = Employee::where('status', 'active')->with(['attendance' => function($query) use ($date) {
            $query->where('date', $date);
        }])->get();

        // Get attendance statistics for the selected date
        $stats = [
            'total_employees' => $employees->count(),
            'present' => Attendance::where('date', $date)->where('status', 'Present')->count(),
            'absent' => Attendance::where('date', $date)->where('status', 'Absent')->count(),
            'leave' => Attendance::where('date', $date)->where('status', 'Leave')->count(),
            'half_day' => Attendance::where('date', $date)->where('status', 'Half Day')->count(),
            'holiday' => Attendance::where('date', $date)->where('status', 'Holiday')->count(),
        ];

        return view('admin.attendance.index', compact('employees', 'selectedDate', 'stats', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'status' => 'required|in:Present,Absent,Leave,Half Day,Holiday',
                'remarks' => 'nullable|string|max:255',
            ]);

            // Check if attendance already exists for this employee on this date
            $existingAttendance = Attendance::where('employee_id', $request->employee_id)
                ->where('date', $request->date)
                ->first();

            if ($existingAttendance) {
                // Update existing record
                $existingAttendance->update([
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                ]);

                // Log activity
                $this->logActivity('updated', 'Attendance', $existingAttendance->id, 'Updated attendance for ' . $existingAttendance->employee->name . ' to ' . $existingAttendance->status . ' on ' . $existingAttendance->date);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Attendance updated successfully.',
                        'attendance' => $existingAttendance
                    ]);
                }

                return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully.');
            }

            $attendance = Attendance::create($request->all());

            // Log activity
            $this->logActivity('created', 'Attendance', $attendance->id, 'Marked attendance for ' . $attendance->employee->name . ' as ' . $attendance->status . ' on ' . $attendance->date);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance marked successfully.',
                    'attendance' => $attendance
                ]);
            }

            return redirect()->route('attendance.index')->with('success', 'Attendance record created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e; // Re-throw for default HTML handling
        } catch (\Exception $e) {
            Log::error('Attendance store error: ' . $e->getMessage(), ['request' => $request->all()]);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing the request.'
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return view('admin.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave,Half Day,Holiday',
            'remarks' => 'nullable|string|max:255',
            'marked_time' => 'required|date_format:H:i',
        ]);

        $attendance->employee_id = $request->employee_id;
        $attendance->date = $request->date;
        $attendance->status = $request->status;
        $attendance->remarks = $request->remarks;

        // Update updated_at with marked_time on the same date
        $dateTimeString = $request->date . ' ' . $request->marked_time;
        $attendance->updated_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $dateTimeString, 'Asia/Kolkata');

        $attendance->save();

        // Log activity
        $this->logActivity('updated', 'Attendance', $attendance->id, 'Updated attendance for ' . $attendance->employee->name . ' to ' . $attendance->status . ' on ' . $attendance->date);

        return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $employeeName = $attendance->employee->name;
        $date = $attendance->date;

        $attendance->delete();

        // Log activity
        $this->logActivity('deleted', 'Attendance', null, 'Deleted attendance for ' . $employeeName . ' on ' . $date);

        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Bulk update attendance records
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.id' => 'nullable|exists:attendances,id',
            'attendance.*.employee_id' => 'required|exists:employees,id',
            'attendance.*.status' => 'required|in:Present,Absent,Leave,Half Day,Holiday',
            'attendance.*.remarks' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $date = $request->date;

        foreach ($request->attendance as $attendanceData) {
            if (isset($attendanceData['id'])) {
                // Update existing record
                $attendance = Attendance::find($attendanceData['id']);
                if ($attendance) {
                    $attendance->update([
                        'status' => $attendanceData['status'],
                        'remarks' => $attendanceData['remarks'] ?? null,
                    ]);
                }
            } else {
                // Create new record
                Attendance::create([
                    'employee_id' => $attendanceData['employee_id'],
                    'date' => $date,
                    'status' => $attendanceData['status'],
                    'remarks' => $attendanceData['remarks'] ?? null,
                ]);
            }
        }

        return redirect()->route('attendance.index', ['date' => $date])->with('success', 'Attendance records updated successfully.');
    }

    /**
     * Show monthly attendance selection form
     */
    public function monthly($employee = null)
    {
        $employees = Employee::all();
        $selectedEmployee = null;

        if ($employee) {
            $selectedEmployee = Employee::findOrFail($employee);
        }

        return view('admin.attendance.monthly', compact('employees', 'selectedEmployee'));
    }

  
    /**
     * Show monthly attendance data for selected employee and month
     */
    public function showMonthly(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required|date_format:Y-m',
        ]);

        $employees = Employee::all();
        $month = $request->month;

        // Parse month and year
        $date = Carbon::createFromFormat('Y-m', $month, 'Asia/Kolkata');
        $year = $date->year;
        $monthNum = $date->month;

        if ($request->employee_id === 'all') {
            // Show summary for all employees
            $selectedEmployee = 'all';

            // Get attendance data for all employees for the selected month
            $attendances = Attendance::with('employee')
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->orderBy('employee_id')
                ->orderBy('date')
                ->get();

            // Get all active employees and create summaries (even for those with no attendance)
            $employeeSummaries = [];
            foreach ($employees as $employee) {
                $employeeAttendances = $attendances->where('employee_id', $employee->id);
                $employeeSummaries[$employee->id] = [
                    'employee' => $employee,
                    'total_days' => $employeeAttendances->count(),
                    'present' => $employeeAttendances->where('status', 'Present')->count(),
                    'absent' => $employeeAttendances->where('status', 'Absent')->count(),
                    'leave' => $employeeAttendances->where('status', 'Leave')->count(),
                    'half_day' => $employeeAttendances->where('status', 'Half Day')->count(),
                    'holiday' => $employeeAttendances->where('status', 'Holiday')->count(),
                ];
            }

            // Group attendances by employee_id and date string for correct lookup in view
            $attendances = $attendances->groupBy([
                'employee_id',
                function ($item) {
                    return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                }
            ]);

            return view('admin.attendance.monthly', compact('employees', 'selectedEmployee', 'month', 'employeeSummaries', 'attendances'));
        } else {
            // Show individual employee data
            $employee = Employee::findOrFail($request->employee_id);
            $selectedEmployee = $employee;

            // Get attendance data for the selected month and employee
            $attendances = Attendance::where('employee_id', $request->employee_id)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
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
            $daysInMonth = $date->daysInMonth;
            $monthlyData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($year, $monthNum, $day, 0, 0, 0, 'Asia/Kolkata');
                // Use closure for accurate date comparison
                $attendance = $attendances->first(function ($att) use ($currentDate) {
                    return $att->date->format('Y-m-d') === $currentDate->format('Y-m-d');
                });

                $monthlyData[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'day' => $day,
                    'day_name' => $currentDate->format('D'),
                    'status' => $attendance ? $attendance->status : 'Not Marked',
                    'marked_at' => $attendance ? $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i') : null,
                    'remarks' => $attendance ? $attendance->remarks : null,
                ];
            }

            return view('admin.attendance.monthly', compact('employees', 'employee', 'selectedEmployee', 'month', 'summary', 'monthlyData', 'attendances'));
        }
    }

    /**
     * Generate attendance report
     */
    public function report(Request $request)
    {
        $date = $request->get('date', Carbon::today('Asia/Kolkata')->format('Y-m-d'));
        $month = $request->get('month', Carbon::today('Asia/Kolkata')->format('m'));
        $year = $request->get('year', Carbon::today('Asia/Kolkata')->format('Y'));

        // Get attendance data for the selected month
        $attendances = Attendance::with('employee')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->orderBy('employee_id')
            ->get();

        // Group by employee for summary
        $employeeSummary = $attendances->groupBy('employee_id')->map(function ($records) {
            return [
                'employee' => $records->first()->employee,
                'total_days' => $records->count(),
                'present' => $records->where('status', 'Present')->count(),
                'absent' => $records->where('status', 'Absent')->count(),
                'leave' => $records->where('status', 'Leave')->count(),
                'half_day' => $records->where('status', 'Half Day')->count(),
                'holiday' => $records->where('status', 'Holiday')->count(),
                'records' => $records,
            ];
        });

        return view('admin.attendance.report', compact('attendances', 'employeeSummary', 'month', 'year', 'date'));
    }

    /**
     * Export monthly attendance data for selected employee and month to Excel
     */
    public function exportMonthly(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required|date_format:Y-m',
        ]);

        $date = Carbon::createFromFormat('Y-m', $request->month, 'Asia/Kolkata');
        $year = $date->year;
        $month = $date->month;

        if ($request->employee_id === 'all') {
            $fileName = 'All_Employees_Attendance_' . $date->format('F_Y') . '.xlsx';
        } else {
            $employee = Employee::findOrFail($request->employee_id);
            $fileName = $employee->name . '_Attendance_' . $date->format('F_Y') . '.xlsx';
        }

        return Excel::download(new MonthlyAttendanceExport($request->employee_id, $month, $year), $fileName);
    }
}