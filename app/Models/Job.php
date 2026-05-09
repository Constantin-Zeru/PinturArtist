<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'created_by',
        'name',
        'work_type',
        'technical_state',
        'description',
        'surface_m2',
        'rooms_count',
        'height_m',
        'status',
        'priority',
        'requested_at',
        'planned_start_at',
        'planned_end_at',
        'technical_observations',
    ];

    protected $casts = [
        'surface_m2' => 'decimal:2',
        'height_m' => 'decimal:2',
        'requested_at' => 'date',
        'planned_start_at' => 'date',
        'planned_end_at' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'job_user')
            ->withPivot('role_in_job', 'assigned_at');
    }

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function phases()
    {
        return $this->hasMany(Phase::class);
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}