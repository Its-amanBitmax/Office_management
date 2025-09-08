<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'relation',
        'name',
        'contact_number',
        'aadhar',
        'pan',
        'aadhar_file',
        'pan_file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}