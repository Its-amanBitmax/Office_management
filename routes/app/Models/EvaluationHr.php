<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationHr extends Model
{
    protected $fillable = [
        'report_id',
        'teamwork',
        'communication',
        'attendance',
        'professionalism',
        'team_collaboration',
        'learning',
        'initiative',
        'time_management',
        'hr_total',
        'hr_comments',
    ];

    public function evaluationReport()
    {
        return $this->belongsTo(EvaluationReport::class, 'report_id');
    }
}
