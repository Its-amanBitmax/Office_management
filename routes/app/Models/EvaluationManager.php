<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationManager extends Model
{
    protected $fillable = [
        'report_id',
        'project_delivery',
        'code_quality',
        'performance',
        'task_completion',
        'innovation',
        'code_efficiency',
        'uiux',
        'debugging',
        'version_control',
        'documentation',
        'manager_total',
        'manager_comments',
    ];

    public function evaluationReport()
    {
        return $this->belongsTo(EvaluationReport::class, 'report_id');
    }
}
