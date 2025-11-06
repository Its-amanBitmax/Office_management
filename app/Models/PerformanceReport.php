<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    protected $fillable = [
        'employee_id',
        'designation',
        'reporting_manager',
        'review_from',
        'review_to',
        'evaluation_date',
        'project_delivery',
        'code_quality',
        'system_performance',
        'task_completion',
        'innovation',
        'teamwork',
        'communication',
        'attendance',
        'manager_feedback',
        'employee_comments',
    ];

    protected $casts = [
        'review_from' => 'date',
        'review_to' => 'date',
        'evaluation_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function qualityMetrics()
    {
        return $this->hasOne(QualityMetric::class, 'report_id');
    }

    public function softSkills()
    {
        return $this->hasOne(SoftSkill::class, 'report_id');
    }

    public function overallEvaluation()
    {
        return $this->hasOne(OverallEvaluation::class, 'report_id');
    }
}
