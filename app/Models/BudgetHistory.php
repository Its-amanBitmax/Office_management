<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetHistory extends Model
{
    protected $table = 'expense_budget_history';

    protected $fillable = [
        'action',
        'amount',
        'old_budget',
        'new_budget',
        'remaining',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'old_budget' => 'decimal:2',
        'new_budget' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
