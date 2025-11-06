<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverallEvaluation extends Model
{
    protected $fillable = [
        'report_id',
        'technical_skills_score',
        'task_delivery_score',
        'quality_of_work_score',
        'communication_score',
        'teamwork_score',
        'overall_rating',
        'performance_grade',
    ];

    protected $casts = [
        'performance_grade' => 'string',
    ];

    public function performanceReport()
    {
        return $this->belongsTo(PerformanceReport::class, 'report_id');
    }
}
