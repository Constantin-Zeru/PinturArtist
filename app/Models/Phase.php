<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'responsible_user_id',
        'name',
        'sort_order',
        'status',
        'phase_date',
        'hours_spent',
        'observations',
        'requires_photo',
        'requires_video',
    ];

    protected $casts = [
        'phase_date' => 'date',
        'hours_spent' => 'decimal:2',
        'requires_photo' => 'boolean',
        'requires_video' => 'boolean',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'phase_material')
            ->withPivot('quantity_used', 'notes');
    }
}