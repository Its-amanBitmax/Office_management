<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityMetric extends Model
{
    protected $fillable = [
        'report_id',
        'code_efficiency',
        'uiux',
        'debugging',
        'version_control',
        'documentation',
        'remarks',
    ];

    public function performanceReport()
    {
        return $this->belongsTo(PerformanceReport::class, 'report_id');
    }
}
