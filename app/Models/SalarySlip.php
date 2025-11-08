<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'hra',
        'conveyance',
        'medical',
        'total_working_days',
        'present_days',
        'absent_days',
        'leave_days',
        'half_day_count',
        'holiday_days',
        'gross_salary',
        'deductions',
        'net_salary',
        'generated_at',
        'pdf_path',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'hra' => 'decimal:2',
        'conveyance' => 'decimal:2',
        'medical' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'deductions' => 'array',
        'generated_at' => 'datetime',
        'year' => 'integer',
        'holiday_days' => 'integer',
    ];

    /**
     * Get the employee that owns the salary slip.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate total deductions
     */
    public function getTotalDeductionsAttribute()
    {
        if (!$this->deductions) {
            return 0;
        }

        return collect($this->deductions)->sum('amount');
    }

    /**
     * Get formatted month name
     */
    public function getMonthNameAttribute()
    {
        return Carbon::createFromFormat('Y-m', $this->month . '-01')->format('F Y');
    }

    /**
     * Get holiday days (stored or calculated from attendance)
     */
    public function getHolidayDaysAttribute()
    {
        if (isset($this->attributes['holiday_days'])) {
            return $this->attributes['holiday_days'];
        }

        $holidays = \App\Models\Attendance::where('employee_id', $this->employee_id)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->where('status', 'Holiday')
            ->count();

        return $holidays;
    }

    /**
     * Scope for filtering by employee
     */
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope for filtering by month and year
     */
    public function scopeForMonth($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    /**
     * Check if salary slip exists for employee and month
     */
    public static function existsForEmployeeMonth($employeeId, $month, $year)
    {
        return self::where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->exists();
    }

    /**
     * Get formatted slip ID in BT/HR/year/ID format
     */
    public function getSlipIdAttribute()
    {
        return 'BT/HR/' . $this->year . '/' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}