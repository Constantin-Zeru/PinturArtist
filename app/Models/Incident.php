<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'phase_id',
        'reported_by',
        'cause',
        'incident_date',
        'resolution',
        'delay_minutes',
        'affects_budget',
        'affects_deadline',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'delay_minutes' => 'integer',
        'affects_budget' => 'boolean',
        'affects_deadline' => 'boolean',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}