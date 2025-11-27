<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'admin_id',
        'employee_id',
        'title',
        'message',
        'is_read',
    ];

    // OPTIONAL relations
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
