<?php

namespace App\Http\Controllers;

use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SalarySlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalarySlip::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $salarySlips = $query->orderBy('generated_at', 'desc')->paginate(15);
        $employees = Employee::all();

        return view('admin.salary-slips.index', compact('salarySlips', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('admin.salary-slips.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'month' => 'required|date_format:Y-m',
        'deductions' => 'nullable|array',
        'deductions.*.type' => 'required|string',
        'deductions.*.amount' => 'required|numeric|min:0',
    ]);

    // Check if salary slip already exists
    $month = Carbon::createFromFormat('Y-m', $request->month);
    if (SalarySlip::existsForEmployeeMonth($request->employee_id, $request->month, $month->year)) {
        return redirect()->back()->withErrors(['month' => 'Salary slip already exists for this employee and month.']);
    }

    $employee = Employee::findOrFail($request->employee_id);

    // Calculate attendance data
    $attendanceData = $this->calculateAttendanceData($employee, $request->month);

    // Calculate salary
    $salaryData = $this->calculateSalary($employee, $attendanceData, $request->deductions ?? []);

    // Create salary slip
    $salarySlip = SalarySlip::create([
        'employee_id' => $employee->id,
        'month' => $request->month,
        'year' => $month->year,
        'basic_salary' => $employee->basic_salary ?? 0,
        'hra' => $employee->hra ?? 0,
        'conveyance' => $employee->conveyance ?? 0,
        'medical' => $employee->medical ?? 0,
        'total_working_days' => $attendanceData['total_days'],
        'present_days' => $attendanceData['present'],
        'absent_days' => $attendanceData['absent'],
        'leave_days' => $attendanceData['leave'],
        'half_day_count' => $attendanceData['half_day'],
        'holiday_days' => $attendanceData['holiday'], // added
        'gross_salary' => $salaryData['gross_salary'],
        'deductions' => $request->deductions,
        'net_salary' => $salaryData['net_salary'],
        'generated_at' => now(),
    ]);

    return redirect()->route('salary-slips.show', $salarySlip)
                     ->with('success', 'Salary slip generated successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(SalarySlip $salarySlip)
    {
        $salarySlip->load('employee');
        return view('admin.salary-slips.show', compact('salarySlip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalarySlip $salarySlip)
    {
        $employees = Employee::all();
        return view('admin.salary-slips.edit', compact('salarySlip', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalarySlip $salarySlip)
    {
        $request->validate([
            'deductions' => 'nullable|array',
            'deductions.*.type' => 'required|string',
            'deductions.*.amount' => 'required|numeric|min:0',
        ]);

        $employee = $salarySlip->employee;

        // Recalculate salary with new deductions
        $attendanceData = [
            'total_days' => $salarySlip->total_working_days,
            'present' => $salarySlip->present_days,
            'absent' => $salarySlip->absent_days,
            'leave' => $salarySlip->leave_days,
            'half_day' => $salarySlip->half_day_count,
        ];

        $salaryData = $this->calculateSalary($employee, $attendanceData, $request->deductions ?? []);

        $salarySlip->update([
            'deductions' => $request->deductions,
            'gross_salary' => $salaryData['gross_salary'],
            'net_salary' => $salaryData['net_salary'],
        ]);

        return redirect()->route('salary-slips.show', $salarySlip)->with('success', 'Salary slip updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalarySlip $salarySlip)
    {
        // Delete PDF file if exists
        if ($salarySlip->pdf_path && Storage::exists($salarySlip->pdf_path)) {
            Storage::delete($salarySlip->pdf_path);
        }

        $salarySlip->delete();

        return redirect()->route('salary-slips.index')->with('success', 'Salary slip deleted successfully.');
    }

    /**
     * Generate and download PDF
     */
    public function downloadPdf(SalarySlip $salarySlip)
    {
        $salarySlip->load('employee');

        $pdf = Pdf::loadView('admin.salary-slips.pdf', compact('salarySlip'));

        $filename = 'salary-slip-' . $salarySlip->employee->name . '-' . $salarySlip->month . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Calculate attendance data for the month
     */
private function calculateAttendanceData(Employee $employee, string $month): array
{
    $date = Carbon::createFromFormat('Y-m', $month);
    $year = $date->year;
    $monthNum = $date->month;

    $attendances = Attendance::where('employee_id', $employee->id)
        ->whereYear('date', $year)
        ->whereMonth('date', $monthNum)
        ->get();

    return [
        'total_days' => $attendances->count(),
        'present' => $attendances->where('status', 'Present')->count(),
        'absent' => $attendances->where('status', 'Absent')->count(),
        'leave' => $attendances->where('status', 'Leave')->count(),
        'half_day' => $attendances->where('status', 'Half Day')->count(),
        'holiday' => $attendances->where('status', 'Holiday')->count(), // naya
    ];
}


    /**
     * Calculate salary based on attendance and deductions
     */
private function calculateSalary(Employee $employee, array $attendanceData, array $deductions = []): array
{
    $basicSalary = $employee->basic_salary ?? 0;
    $hra = $employee->hra ?? 0;
    $conveyance = $employee->conveyance ?? 0;
    $medical = $employee->medical ?? 0;

    // Calculate daily rates
    $totalDaysInMonth = Carbon::now()->daysInMonth; // Approximate
    $basicDaily = $basicSalary / $totalDaysInMonth;
    $hraDaily = $hra / $totalDaysInMonth;
    $conveyanceDaily = $conveyance / $totalDaysInMonth;
    $medicalDaily = $medical / $totalDaysInMonth;

    // Attendance breakdown
    $presentDays = $attendanceData['present'] ?? 0;
    $halfDays = $attendanceData['half_day'] ?? 0;
    $holidayDays = $attendanceData['holiday'] ?? 0; // new

    // Calculate effective days (Holiday counted as full day)
    $effectiveDays = $presentDays + $holidayDays + ($halfDays * 0.5);

    $grossSalary = ($basicDaily * $effectiveDays) +
                  ($hraDaily * $effectiveDays) +
                  ($conveyanceDaily * $effectiveDays) +
                  ($medicalDaily * $effectiveDays);

    // Calculate deductions
    $totalDeductions = collect($deductions)->sum('amount');

    $netSalary = $grossSalary - $totalDeductions;

    return [
        'gross_salary' => round($grossSalary, 2),
        'net_salary' => round(max(0, $netSalary), 2),
        'total_deductions' => $totalDeductions,
    ];
}

}
