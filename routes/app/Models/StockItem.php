<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'unit',
    ];

    public function assignedItems()
    {
        return $this->hasMany(AssignedItem::class);
    }
}
