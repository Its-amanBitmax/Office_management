<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'subject',
        'description',
        'leave_type',
        'start_date',
        'end_date',
        'days',
        'file_path',
        'status',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
