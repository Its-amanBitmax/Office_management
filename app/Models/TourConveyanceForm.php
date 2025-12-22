<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourConveyanceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_code',
        'company_name',
        'company_address',
        'company_logo_path',
        'form_heading',
        'form_subheading',
        'form_date',
        'employee_name',
        'employee_id',
        'designation',
        'department',
        'reporting_manager',
        'cost_center',
        'purpose',
        'tour_location',
        'project_code',
        'tour_from',
        'tour_to',
        'advance_taken',
        'total_expense',
        'balance_payable',
        'balance_receivable',
        'manager_remarks',
        'status',
        'footer_heading',
        'footer_subheading'
    ];

    public function conveyanceDetails()
    {
        return $this->hasMany(ConveyanceDetail::class);
    }
}
