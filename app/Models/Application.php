<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'student_id',
        'cover_letter',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job posting this application is for
     */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    /**
     * Get the student who submitted this application
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Scope to get pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get reviewed applications
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Scope to get shortlisted applications
     */
    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    /**
     * Scope to get accepted applications
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope to get rejected applications
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if application is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if application is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if application is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Mark application as reviewed
     */
    public function markAsReviewed(): void
    {
        $this->update(['status' => 'reviewed']);
    }

    /**
     * Mark application as shortlisted
     */
    public function markAsShortlisted(): void
    {
        $this->update(['status' => 'shortlisted']);
    }

    /**
     * Mark application as accepted
     */
    public function accept(): void
    {
        $this->update(['status' => 'accepted']);
    }

    /**
     * Mark application as rejected
     */
    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }
}
