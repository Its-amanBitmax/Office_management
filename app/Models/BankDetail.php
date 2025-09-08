<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'bank_name',
        'account_number',
        'ifsc_code',
        'branch_name',
    ];

    /**
     * Get the employee that owns the bank detail.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
