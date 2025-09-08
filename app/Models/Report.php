<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'employee_id',
        'task_id',
        'title',
        'content',
        'attachment',
        'sent_to_admin',
        'sent_to_team_lead',
        'team_lead_id',
        'status',
        'review',
        'rating',
        // Admin review fields
        'admin_review',
        'admin_rating',
        'admin_status',
        // Team lead review fields
        'team_lead_review',
        'team_lead_rating',
        'team_lead_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }
}
