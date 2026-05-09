<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'role',
        'active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_user')
            ->withPivot('role_in_job', 'assigned_at');
    }

    public function responsiblePhases()
    {
        return $this->hasMany(Phase::class, 'responsible_user_id');
    }

    public function uploadedGalleryItems()
    {
        return $this->hasMany(GalleryItem::class, 'uploaded_by');
    }

    public function reportedIncidents()
    {
        return $this->hasMany(Incident::class, 'reported_by');
    }

    public function isAdmin()
{
    return $this->role === 'administrador';
}

public function isManager()
{
    return $this->role === 'encargado';
}

public function isWorker()
{
    return $this->role === 'trabajador';
}
}