<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResearchProject extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'description',
        'status',
        'authors',
        'supervisor',
        'department',
        'start_date',
        'end_date',
        'tags',
        'publication_link',
        'doi',
        'conference',
        'journal',
        'abstract',
        'file_path',
        'views',
    ];

    protected $casts = [
        'authors' => 'array',
        'tags' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'views' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function isOngoing(): bool
    {
        return $this->status === 'Ongoing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function isPublished(): bool
    {
        return $this->status === 'Published';
    }
}
