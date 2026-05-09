<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'created_by',
        'kind',
        'description',
        'amount',
        'status',
        'visible_to_customer',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'visible_to_customer' => 'boolean',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}