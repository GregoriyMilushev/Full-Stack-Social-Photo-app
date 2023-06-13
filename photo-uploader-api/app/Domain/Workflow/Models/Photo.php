<?php

namespace App\Domain\Workflow\Models;

use App\Domain\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPreviewUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
