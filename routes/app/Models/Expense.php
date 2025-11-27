<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'category',
        'expense_date',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
