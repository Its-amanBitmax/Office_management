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
        'month',           // e.g., '2025-11'
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

    // CRITICAL: Cast dates to prevent "Trailing data"
    protected $casts = [
        'basic_salary'     => 'decimal:2',
        'hra'              => 'decimal:2',
        'conveyance'       => 'decimal:2',
        'medical'          => 'decimal:2',
        'gross_salary'     => 'decimal:2',
        'net_salary'       => 'decimal:2',
        'deductions'       => 'array',
        'generated_at'     => 'datetime:Y-m-d H:i:s',  // Safe format
        'year'             => 'integer',
        'holiday_days'     => 'integer',
        'month'            => 'string',               // Keep as string for Y-m
    ];

    // Employee relationship
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Total Deductions (Accessor)
    public function getTotalDeductionsAttribute()
    {
        return collect($this->deductions ?? [])->sum('amount');
    }

    // Formatted Month Name: "Nov 2025"
    public function getMonthNameAttribute()
    {
        try {
            return Carbon::createFromFormat('Y-m', $this->month . '-01')->format('M Y');
        } catch (\Exception $e) {
            return 'Invalid Month';
        }
    }

    // Holiday Days (from DB or calculated)
    public function getHolidayDaysAttribute()
    {
        if (array_key_exists('holiday_days', $this->attributes)) {
            return $this->attributes['holiday_days'];
        }

        return \App\Models\Attendance::where('employee_id', $this->employee_id)
            ->whereYear('date', $this->year)
            ->whereMonth('date', explode('-', $this->month)[1] ?? 1)
            ->where('status', 'Holiday')
            ->count();
    }

    // Slip ID: BT/HR/2025/123
    public function getSlipIdAttribute()
    {
        return "BT/HR/{$this->year}/{$this->id}";
    }

    // Scopes
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeForMonth($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    public static function existsForEmployeeMonth($employeeId, $month, $year)
    {
        return self::where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->exists();
    }
}