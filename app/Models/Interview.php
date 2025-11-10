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
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'date' => 'date',
        'time' => 'datetime:H:i',
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
            // Return null if decryption fails (invalid payload)
            return null;
        }
    }
}
