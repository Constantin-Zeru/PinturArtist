<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_measurement',
        'available_quantity',
        'cost',
        'provider',
        'notes',
        'active',
    ];

    protected $casts = [
        'available_quantity' => 'decimal:2',
        'cost' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function phases()
    {
        return $this->belongsToMany(Phase::class, 'phase_material')
            ->withPivot('quantity_used', 'notes');
    }
}