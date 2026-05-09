<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'estimated_time_hours',
        'labor_hours',
        'material_cost',
        'discount_amount',
        'tax_rate',
        'profit_margin',
        'estimated_total',
        'final_total',
        'time_difference_hours',
        'status',
        'notes',
    ];

    protected $casts = [
        'estimated_time_hours' => 'decimal:2',
        'labor_hours' => 'decimal:2',
        'material_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'estimated_total' => 'decimal:2',
        'final_total' => 'decimal:2',
        'time_difference_hours' => 'decimal:2',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function changes()
    {
        return $this->hasMany(BudgetChange::class);
    }

    public function approvedChanges()
    {
        return $this->hasMany(BudgetChange::class)->where('status', 'aprobado');
    }

    public function getApprovedChangesTotalAttribute(): float
    {
        return round((float) $this->approvedChanges()->sum('amount'), 2);
    }

    public function getCalculatedFinalTotalAttribute(): float
    {
        return round(((float) $this->estimated_total) + $this->approved_changes_total, 2);
    }
}