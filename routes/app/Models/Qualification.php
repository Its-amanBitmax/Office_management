<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'employee_id',
        'degree',
        'institution',
        'year_of_passing',
        'grade',
    ];

    protected $casts = [
        'year_of_passing' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}