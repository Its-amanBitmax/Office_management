<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory; 
      protected $table = 'criteria';

    protected $fillable = [
        'activity_id',
        'name',
        'description',
        'max_points',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }
}
