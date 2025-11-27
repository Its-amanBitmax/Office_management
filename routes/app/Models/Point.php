<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'from_employee_id',
        'to_employee_id',
        'criteria_id',
        'points',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function fromEmployee()
    {
        return $this->belongsTo(Employee::class, 'from_employee_id');
    }

    public function toEmployee()
    {
        return $this->belongsTo(Employee::class, 'to_employee_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
