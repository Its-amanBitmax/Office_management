<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignalingMessage extends Model
{
    protected $fillable = [
        'interview_id',
        'type',
        'sdp',
        'ice_candidate',
        'text',
        'question_id',
        'sender_type',
        'target_type',
        'delivered',
        'delivered_at'
    ];

    protected $casts = [
        'ice_candidate' => 'array',
        'delivered' => 'boolean',
        'delivered_at' => 'datetime'
    ];

    /**
     * Get the interview that owns the signaling message.
     */
    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }

    /**
     * Scope for undelivered messages
     */
    public function scopeUndelivered($query)
    {
        return $query->where('delivered', false);
    }

    /**
     * Scope for messages of specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for messages for specific interview
     */
    public function scopeForInterview($query, $interviewId)
    {
        return $query->where('interview_id', $interviewId);
    }

    /**
     * Mark message as delivered
     */
    public function markAsDelivered()
    {
        $this->update([
            'delivered' => true,
            'delivered_at' => now()
        ]);
    }
}
