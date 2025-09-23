<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedItem extends Model
{
    protected $fillable = [
        'stock_item_id',
        'employee_id',
        'quantity_assigned',
        'assigned_date',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
