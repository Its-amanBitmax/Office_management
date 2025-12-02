<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

protected $fillable = [
    'employee_id',
    'date',
    'status',
    'remarks',
    'marked_time',
    'ip_address',
    'image',
    'marked_by_type',
];



    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the employee that owns the attendance record.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get attendance status options
     */
public static function getStatusOptions()
{
    return [
        'Present' => 'Present',
        'Absent' => 'Absent',
        'Leave' => 'Leave',
        'Half Day' => 'Half Day',
        'Holiday' => 'Holiday', 
    ];
}


    /**
     * Check if attendance exists for employee on specific date
     */
    public static function existsForEmployeeOnDate($employeeId, $date)
    {
        return self::where('employee_id', $employeeId)
            ->where('date', $date)
            ->exists();
    }
}
