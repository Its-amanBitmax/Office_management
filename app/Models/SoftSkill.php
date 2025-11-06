<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftSkill extends Model
{
    protected $fillable = [
        'report_id',
        'professionalism',
        'team_collaboration',
        'learning_adaptability',
        'initiative_ownership',
        'time_management',
        'comments',
    ];

    public function performanceReport()
    {
        return $this->belongsTo(PerformanceReport::class, 'report_id');
    }
}
