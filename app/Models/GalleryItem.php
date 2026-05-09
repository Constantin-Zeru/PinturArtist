<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'phase_id',
        'uploaded_by',
        'media_kind',
        'file_path',
        'file_name',
        'comment',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}