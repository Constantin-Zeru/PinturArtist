<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'dni_nif',
        'phone',
        'email',
        'full_address',
        'client_type',
        'internal_notes',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}