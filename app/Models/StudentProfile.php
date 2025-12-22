<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
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
        'gpa',
        'available_for_hire',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
        'projects' => 'array',
        'available_for_hire' => 'boolean',
        'gpa' => 'float',
        'year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
