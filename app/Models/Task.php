<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'assigned_to',
        'assigned_team',
        'team_lead_id',
        'team_members',
        'team_created_by',
        'selected_team',
        'start_date',
        'end_date',
        'status',
        'priority',
        'progress',
    ];

    protected $casts = [
        'team_members' => 'array',
        'progress' => 'float',
    ];

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function teamLead()
    {
        return $this->belongsTo(Employee::class, 'team_lead_id');
    }

    public function teamMembers()
    {
        return Employee::whereIn('id', $this->team_members ?? [])->get();
    }
}
