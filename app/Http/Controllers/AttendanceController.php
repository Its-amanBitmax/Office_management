<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DateTimeZone;
use App\Traits\Loggable;
use App\Exports\MonthlyAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;


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
            'ncns' => Attendance::where('date', $date)->where('status', 'NCNS')->count(),
            'lwp' => Attendance::where('date', $date)->where('status', 'LWP')->count(),
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
            'status' => 'required|in:Present,Absent,Leave,Half Day,Holiday,NCNS,LWP',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Logged-in admin
        $loggedAdmin = auth('admin')->user();

        // Check if attendance already exists
        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->first();

        /* ===============================
           UPDATE CASE
        ================================= */
        if ($existingAttendance) {
            $existingAttendance->update([
                'status' => $request->status,
                'remarks' => $request->remarks,
            ]);

            $this->logActivity(
                'updated',
                'Attendance',
                $existingAttendance->id,
                'Updated attendance for ' . $existingAttendance->employee->name .
                ' to ' . $existingAttendance->status . ' on ' . $existingAttendance->date
            );

            // ✅ AJAX RESPONSE
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance updated successfully.',
                ]);
            }

            return redirect()
                ->route('attendance.index')
                ->with('success', 'Attendance record updated successfully.');
        }

        /* ===============================
           CREATE CASE
        ================================= */
        $attendance = Attendance::create($request->all());

        $this->logActivity(
            'created',
            'Attendance',
            $attendance->id,
            'Marked attendance for ' . $attendance->employee->name .
            ' as ' . $attendance->status . ' on ' . $attendance->date
        );

        /* ===============================
           🔔 NOTIFICATIONS (SKIP SELF)
        ================================= */

     $employeeName = $attendance->employee
    ? $attendance->employee->name
    : ('ID: ' . $attendance->employee_id);

$actorName = $loggedAdmin ? $loggedAdmin->name : 'Admin';

$admins = \App\Models\Admin::all()->filter(function ($admin) use ($loggedAdmin) {
    // ❌ skip self
    if ($loggedAdmin && $admin->id === $loggedAdmin->id) {
        return false;
    }

    return $admin->role === 'super_admin'
        || ($admin->role === 'sub_admin' && $admin->hasPermission('attendance'));
});

foreach ($admins as $adminUser) {
    \App\Models\Notification::create([
        'admin_id' => $adminUser->id,
        'title' => 'Attendance Marked',
        'message' => "{$actorName} marked attendance for employee: {$employeeName}",
        'is_read' => false,
    ]);
}


        /* =============================== */

        // ✅ AJAX RESPONSE
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully.',
            ]);
        }

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance record created successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e;
    } catch (\Exception $e) {
        \Log::error('Attendance store error: ' . $e->getMessage(), [
            'request' => $request->all(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }

        throw $e;
    }
}



    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $attendance = Attendance::with('employee')->findOrFail($id);

    return response()->json([
        'success' => true,
        'employee' => $attendance->employee->name,
        'status' => $attendance->status,
        'marked_time' => $attendance->marked_time,
        'marked_by' => $attendance->marked_by_type,
        'ip' => $attendance->ip_address,
        'image' => $attendance->image
            ? asset('storage/'.$attendance->image)
            : null,
    ]);
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
            'status' => 'required|in:Present,Absent,Leave,Half Day,Holiday,NCNS,LWP',
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
            'attendance.*.status' => 'required|in:Present,Absent,Leave,Half Day,Holiday,NCNS,LWP',
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

            // Get the selected month start and end dates
            $selectedMonthStart = Carbon::create($year, $monthNum, 1, 0, 0, 0, 'Asia/Kolkata');
            $selectedMonthEnd = $selectedMonthStart->copy()->endOfMonth();

            // Get all employees and create summaries (even for those with no attendance)
            $employeeSummaries = [];
            foreach ($employees as $employee) {
                // Determine inactive date - use updated_at if employee is currently inactive
                $inactiveDate = null;
                if ($employee->status === 'inactive') {
                    $inactiveDate = Carbon::parse($employee->updated_at);
                }

                // Determine if employee should be included based on inactive date
                $shouldInclude = true;
                if ($inactiveDate) {
                    // If inactive date is before or on the selected month start, don't include
                    if ($inactiveDate->lte($selectedMonthStart)) {
                        $shouldInclude = false;
                    }
                }

                if (!$shouldInclude) {
                    continue;
                }

                $employeeAttendances = $attendances->where('employee_id', $employee->id);

                // Filter attendances up to inactive date if exists
                if ($inactiveDate) {
                    $employeeAttendances = $employeeAttendances->filter(function ($att) use ($inactiveDate) {
                        return Carbon::parse($att->date)->lte($inactiveDate);
                    });
                }

                $summary = [
                    'employee' => $employee,
                    'total_days' => $employeeAttendances->count(),
                    'present' => $employeeAttendances->where('status', 'Present')->count(),
                    'absent' => $employeeAttendances->where('status', 'Absent')->count(),
                    'leave' => $employeeAttendances->where('status', 'Leave')->count(),
                    'half_day' => $employeeAttendances->where('status', 'Half Day')->count(),
                    'holiday' => $employeeAttendances->where('status', 'Holiday')->count(),
                    'ncns' => $employeeAttendances->where('status', 'NCNS')->count(),
                    'lwp' => $employeeAttendances->where('status', 'LWP')->count(),
                    'inactive_date' => $inactiveDate,
                ];

                // Calculate salary for the month
                $attendanceData = [
                    'total_days' => $summary['total_days'],
                    'present' => $summary['present'],
                    'absent' => $summary['absent'],
                    'leave' => $summary['leave'],
                    'half_day' => $summary['half_day'],
                    'holiday' => $summary['holiday'],
                    'ncns' => $summary['ncns'],
                    'lwp' => $summary['lwp'],
                ];
                $salaryData = $this->calculateSalary($employee, $attendanceData, [], $month);
                $summary['total_salary'] = $salaryData['net_salary'];

                $employeeSummaries[$employee->id] = $summary;
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
                'ncns' => $attendances->where('status', 'NCNS')->count(),
                'lwp' => $attendances->where('status', 'LWP')->count(),
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

    /**
     * Export today's attendance data to PDF
     */
    public function exportTodayPdf(Request $request)
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
            'ncns' => Attendance::where('date', $date)->where('status', 'NCNS')->count(),
            'lwp' => Attendance::where('date', $date)->where('status', 'LWP')->count(),
        ];

        $pdf = Pdf::loadView('admin.attendance.pdf', compact('employees', 'selectedDate', 'stats', 'date'));
        $fileName = 'Attendance_' . $selectedDate->format('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Calculate salary based on attendance and deductions
     */
  private function calculateSalary(Employee $employee, array $attendanceData, array $deductions = [], string $month = null): array
{
    $basicSalary = $employee->basic_salary ?? 0;
    $hra = $employee->hra ?? 0;
    $conveyance = $employee->conveyance ?? 0;
    $medical = $employee->medical ?? 0;

    // Calculate total days in the specific month
    if ($month) {
        $date = Carbon::createFromFormat('Y-m', $month);
        $totalDaysInMonth = $date->daysInMonth;
    } else {
        $totalDaysInMonth = Carbon::now()->daysInMonth; // Fallback
    }

    // Daily salary rates
    $basicDaily = $basicSalary / $totalDaysInMonth;
    $hraDaily = $hra / $totalDaysInMonth;
    $conveyanceDaily = $conveyance / $totalDaysInMonth;
    $medicalDaily = $medical / $totalDaysInMonth;

    // Attendance breakdown
    $presentDays = $attendanceData['present'] ?? 0;
    $halfDays = $attendanceData['half_day'] ?? 0;
    $holidayDays = $attendanceData['holiday'] ?? 0;
    $lwpDays = $attendanceData['lwp'] ?? 0;   
    $ncnsDays = $attendanceData['ncns'] ?? 0;

    /*
     * ✔ Paid Days = Present + Holiday + (Half Day × 0.5)
     * LWP & NCNS are only UNPAID days — NO minus calculation
     */
    $paidDays = $presentDays + $holidayDays + ($halfDays * 0.5);

    // Gross Salary (Unpaid days not counted)
    $grossSalary = ($basicDaily * $paidDays) +
                   ($hraDaily * $paidDays) +
                   ($conveyanceDaily * $paidDays) +
                   ($medicalDaily * $paidDays);

    // Calculate deductions
    $totalDeductions = collect($deductions)->sum('amount');
    $netSalary = $grossSalary - $totalDeductions;

    return [
        'gross_salary' => round($grossSalary, 2),
        'net_salary' => round(max(0, $netSalary), 2),
        'total_deductions' => $totalDeductions,
    ];
}






public function mark(Request $request)
{
    // ✅ Office WiFi IPv4 ONLY
    $officeIps = [
        '103.154.247.10',
    ];

    // ✅ Detect real client IP
    $userIp = $request->header('CF-Connecting-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip();

    // ✅ If proxy sends multiple IPs, take first
    $userIp = trim(explode(',', $userIp)[0]);

    // ✅ Log for debugging
    Log::info('Attendance IP Check', [
        'ip' => $userIp,
        'expects_json' => $request->expectsJson(),
        'agent' => $request->userAgent(),
    ]);

    /* ---------------------------------
       🔒 SECURITY CHECKS
    --------------------------------- */

    // 🚫 Block IPv6 (mostly mobile personal networks)
    if (filter_var($userIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        return $this->denyAttendance($request);
    }

    // 🚫 Block non-office IPv4
    if (!in_array($userIp, $officeIps, true)) {
        return $this->denyAttendance($request);
    }

    /* ---------------------------------
       ✅ ALLOWED
    --------------------------------- */

    // ✅ AJAX → only permission check
    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Attendance allowed'
        ], 200);
    }

    // ✅ Normal browser → open camera page
    return view('employee.attendance.mark');
}

/**
 * ❌ Common deny response (AJAX + normal)
 */
private function denyAttendance(Request $request)
{
    if ($request->expectsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Attendance can only be marked from Office WiFi'
        ], 403);
    }

    abort(403, 'Attendance can only be marked from Office WiFi');
}




public function submit(Request $request)
{
    $request->validate([
        'image' => 'required|string',
    ]);

    $employeeId = auth('employee')->id();
    $today = now()->toDateString();

    // ✅ Decide status by server time
    $now = Carbon::now('Asia/Kolkata');
    $halfDayTime = Carbon::createFromTime(9, 30, 0, 'Asia/Kolkata');
    $status = $now->greaterThan($halfDayTime) ? 'Half Day' : 'Present';

    /* -----------------------------
       IMAGE HANDLE
    ------------------------------ */
    $imageData = $request->image;

    if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
        return back()->with('error', 'Invalid image format');
    }

    $image = base64_decode(substr($imageData, strpos($imageData, ',') + 1));
    if ($image === false) {
        return back()->with('error', 'Image decoding failed');
    }

    $extension = strtolower($type[1]);
    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
        return back()->with('error', 'Invalid image type');
    }

    $fileName = 'attendance_' . $employeeId . '_' . now()->timestamp . '.' . $extension;
    $path = 'attendance/' . $fileName;
    Storage::disk('public')->put($path, $image);

    /* --------------------------------
       ✅ INSERT OR UPDATE (KEY FIX)
    -------------------------------- */

    Attendance::updateOrCreate(
        [
            'employee_id' => $employeeId,
            'date'        => $today,      // ✅ unique key
        ],
        [
            'status'        => $status,
            'marked_time'   => $now->format('H:i:s'),
            'ip_address'    => $request->ip(),
            'image'         => $path,
            'marked_by_type'=> 'Employee',
        ]
    );

    return redirect()->route('employee.attendance')
        ->with('success', 'Attendance saved as ' . $status);
}





}
