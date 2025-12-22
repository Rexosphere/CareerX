<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employer_id',
        'title',
        'company_name',
        'company_logo',
        'description',
        'location',
        'type',
        'category',
        'salary_range',
        'requirements',
        'is_active',
        'application_deadline',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'application_deadline' => 'date',
    ];

    /**
     * Get the employer who posted this job
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get all applications for this job posting
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    /**
     * Scope to get only active job postings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get jobs before deadline
     */
    public function scopeOpen($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            });
    }

    /**
     * Check if the job is still accepting applications
     */
    public function isOpen(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->application_deadline === null) {
            return true;
        }

        return $this->application_deadline > now();
    }

    /**
     * Get the number of applications
     */
    public function applicationsCount(): int
    {
        return $this->applications()->count();
    }
}
