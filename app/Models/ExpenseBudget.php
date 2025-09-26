<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseBudget extends Model
{
    protected $table = 'expense_budget';

    protected $fillable = [
        'budget_amount',
        'remaining_amount',
    ];

    protected $casts = [
        'budget_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    /**
     * Get the current budget (first record or create if not exists)
     */
    public static function getCurrentBudget()
    {
        return static::first() ?? static::create([
            'budget_amount' => 0,
            'remaining_amount' => 0,
        ]);
    }

    /**
     * Update remaining budget after expense creation
     */
    public function deductAmount($amount)
    {
        $this->remaining_amount = max(0, $this->remaining_amount - $amount);
        $this->save();
    }

    /**
     * Update remaining budget after expense update
     */
    public function adjustAmount($oldAmount, $newAmount)
    {
        $difference = $newAmount - $oldAmount;
        $this->remaining_amount = max(0, $this->remaining_amount - $difference);
        $this->save();
    }

    /**
     * Add back amount when expense is deleted
     */
    public function addBackAmount($amount)
    {
        $this->remaining_amount += $amount;
        $this->save();
    }
}
