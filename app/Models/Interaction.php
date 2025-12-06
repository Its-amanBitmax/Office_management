<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $table = 'interactions';

    protected $fillable = [
        'lead_id',
        'activity_type',
        'subject',
        'description',
        'activity_status',
        'activity_date',
        'next_follow_up',
        'created_by',
    ];

    /**
     * Get the lead that owns the interaction.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
