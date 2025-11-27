<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAssignment extends Model
{
    protected $fillable = [
        'step',
        'assigned_admins',
    ];

    protected $casts = [
        'assigned_admins' => 'array',
    ];
}
