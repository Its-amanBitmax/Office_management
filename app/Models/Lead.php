<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'phone',
        'company_name',
        'source',
        'status',
        'assigned_to',
        'priority',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lead) {
            if (empty($lead->lead_id)) {
                $lead->lead_id = 'LD-' . str_pad((static::count() + 1), 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
}
