<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationOverall extends Model
{
    protected $fillable = [
        'report_id',
        'technical_skills',
        'task_delivery',
        'quality_work',
        'communication',
        'behavior_teamwork',
        'overall_rating',
        'performance_grade',
        'final_feedback',
    ];

    protected $casts = [
        'performance_grade' => 'string',
    ];

    public function evaluationReport()
    {
        return $this->belongsTo(EvaluationReport::class, 'report_id');
    }
}
