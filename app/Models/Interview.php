<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'unique_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'candidate_resume_path',
        'candidate_profile',
        'candidate_experience',
        'date',
        'time',
        'scheduled_at',
        'unique_link',
        'status',
        'interview_code',
        'password',
        'results',
        'is_started',
        'link_status',
        'round_count',
        'round_details',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'date' => 'date',
        'time' => 'datetime:H:i',
        'link_status' => 'string', // ✅ enum('0','1') ke liye safe
        'round_details' => 'array',
    ];

    /**
     * Get the decrypted password attribute.
     */
    public function getDecryptedPasswordAttribute()
    {
        if (!$this->password || $this->password === '') {
            return null;
        }

        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($this->password);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the rounds attribute (alias for round_details).
     */
    public function getRoundsAttribute()
    {
        return $this->round_details ?? [];
    }
}
