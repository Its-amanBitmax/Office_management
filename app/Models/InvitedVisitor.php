<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitedVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'purpose',
        'invited_at',
        'first_contact_person_name',
        'contact_person_phone',
        'invitation_code',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
    ];
}
