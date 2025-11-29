<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrMisReport extends Model
{
    protected $fillable = [
        'report_type',
        'report_date',
        'week_start',
        'week_end',
        'report_month',
        'department',
        'center_branch',
        'total_employees',
        'new_joiners',
        'resignations',
        'terminated',
        'net_strength',
        'present_days',
        'absent_days',
        'leaves_approved',
        'half_days',
        'holiday_days',
        'ncns_days',
        'lwp_days',
        'requirements_raised',
        'positions_closed',
        'positions_pending',
        'interviews_conducted',
        'selected',
        'rejected',
        'salary_processed',
        'salary_disbursed_date',
        'deductions',
        'pending_compliance',
        'grievances_received',
        'grievances_resolved',
        'warning_notices',
        'appreciations',
        'trainings_conducted',
        'employees_attended',
        'training_feedback',
        'birthday_celebrations',
        'engagement_activities',
        'hr_initiatives',
        'special_events',
        'notes',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'report_date' => 'date',
        'week_start' => 'date',
        'week_end' => 'date',
        'salary_disbursed_date' => 'date',
        'salary_processed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the admin who created this report.
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }
}
