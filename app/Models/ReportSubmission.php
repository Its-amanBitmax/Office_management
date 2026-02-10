<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSubmission extends Model
{
    protected $fillable = [
        'employee_id',
        'report_date',
        'is_submitted',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
