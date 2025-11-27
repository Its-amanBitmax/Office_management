<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'schedule_at',
        'scoring_scope',
        'best_employee_id',
        'best_employee_description',
        'keep_best_employee',
        'enable_best_employee',
    ];

    protected $casts = [
        'schedule_at' => 'datetime',
    ];

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'activity_employee');
    }

    // ✅ Add this
    public function criteria()
    {
        return $this->hasMany(Criteria::class);
    }
}
