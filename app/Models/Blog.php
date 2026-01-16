<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'author_id',
        'company_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'category',
        'status',
        'published_at',
        'views',
        'is_approved',
        'approved_by',
        'approved_at',
        'submitted_at',
        'is_deleted',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
        'submitted_at' => 'datetime',
        'views' => 'integer',
        'is_approved' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title when creating
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Get the author of the blog post (admin user)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the company author of the blog post
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the admin who approved this blog
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope to get only published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope to get draft blogs
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope to get archived blogs
     */
    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Scope to filter by category
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to search by title or content
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to filter by tag
     */
    public function scopeWithTag($query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope to get pending approval blogs
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved blogs
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get non-deleted blogs
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    /**
     * Scope to get soft-deleted blogs
     */
    public function scopeDeleted($query)
    {
        return $query->where('is_deleted', true);
    }

    /**
     * Scope to get company-authored blogs
     */
    public function scopeCompanyBlogs($query)
    {
        return $query->whereNotNull('company_id');
    }

    /**
     * Scope to get user-authored blogs
     */
    public function scopeUserBlogs($query)
    {
        return $query->whereNotNull('author_id');
    }

    /**
     * Check if blog is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at <= now();
    }

    /**
     * Check if blog is draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Publish the blog post
     */
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    /**
     * Archive the blog post
     */
    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get reading time in minutes
     */
    public function getReadingTimeAttribute(): int
    {
        $wordsPerMinute = 200;
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, (int) ceil($wordCount / $wordsPerMinute));
    }

    /**
     * Check if this blog was authored by a company
     */
    public function isCompanyBlog(): bool
    {
        return $this->company_id !== null;
    }

    /**
     * Get the author name (either user or company)
     */
    public function getAuthorName(): string
    {
        if ($this->isCompanyBlog()) {
            return $this->company ? $this->company->name : 'Unknown Company';
        }
        return $this->author ? $this->author->name : 'Unknown Author';
    }

    /**
     * Submit blog for admin review
     */
    public function submitForReview(): void
    {
        $this->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);
    }

    /**
     * Approve the blog
     */
    public function approve(int $userId): void
    {
        $this->update([
            'is_approved' => true,
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }

    /**
     * Reject the blog (set back to draft)
     */
    public function reject(): void
    {
        $this->update([
            'status' => 'draft',
            'is_approved' => false,
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Soft delete the blog
     */
    public function softDelete(): void
    {
        $this->update(['is_deleted' => true]);
    }

    /**
     * Restore soft-deleted blog
     */
    public function restore(): void
    {
        $this->update(['is_deleted' => false]);
    }
}
