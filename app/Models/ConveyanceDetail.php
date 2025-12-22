<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConveyanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_conveyance_form_id',
        'travel_date',
        'mode',
        'from_location',
        'to_location',
        'distance',
        'amount'
    ];

    public function tourForm()
    {
        return $this->belongsTo(TourConveyanceForm::class);
    }
}
