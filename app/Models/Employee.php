<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'hire_date',
        'position',
        'department',
        'status',
        'profile_image',
        'password',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'basic_salary',
        'hra',
        'conveyance',
        'medical',
        'dob',
    ];

    protected $casts = [
        'basic_salary' => 'float',
        'hra' => 'float',
        'conveyance' => 'float',
        'medical' => 'float',
        'hire_date' => 'date',
        'dob' => 'date',
    ];

    protected $hidden = ['password'];

    public function familyDetails()
    {
        return $this->hasMany(FamilyDetail::class);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function teamLeadedTasks()
    {
        return $this->hasMany(Task::class, 'team_lead_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_employee');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
