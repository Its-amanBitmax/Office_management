<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationReport extends Model
{
    protected $fillable = [
        'employee_id',
        'review_from',
        'review_to',
        'evaluation_date',
        'manager_submitted',
        'hr_submitted',
        'overall_submitted',
        'manager_id',
        'hr_id',
        'final_approver_id',
        'overall_score',
        'performance_grade',
    ];

    protected $casts = [
        'review_from' => 'date',
        'review_to' => 'date',
        'evaluation_date' => 'date',
        'manager_submitted' => 'boolean',
        'hr_submitted' => 'boolean',
        'overall_submitted' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function manager()
    {
        return $this->belongsTo(Admin::class, 'manager_id');
    }

    public function hr()
    {
        return $this->belongsTo(Admin::class, 'hr_id');
    }

    public function finalApprover()
    {
        return $this->belongsTo(Admin::class, 'final_approver_id');
    }

    public function evaluationManager()
    {
        return $this->hasOne(EvaluationManager::class, 'report_id');
    }

    public function evaluationHr()
    {
        return $this->hasOne(EvaluationHr::class, 'report_id');
    }

    public function evaluationOverall()
    {
        return $this->hasOne(EvaluationOverall::class, 'report_id');
    }
}
