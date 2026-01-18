<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'profile_photo_path', // Added
        'student_id',
        'phone', // Added
        'course',
        'year',
        'bio',
        'skills',
        'experience',
        'projects',
        'cv_path',
        'linkedin',
        'github',
        'portfolio',
        'available_for_hire',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'projects' => 'array',
        'available_for_hire' => 'boolean',
        'year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
