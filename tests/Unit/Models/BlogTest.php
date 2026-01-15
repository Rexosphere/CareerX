<?php

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

test('blog auto-generates slug from title on create', function () {
    $user = createStudent();
    
    $blog = Blog::create([
        'author_id' => $user->id,
        'title' => 'My Amazing Blog Post',
        'content' => 'Content here',
        'status' => 'draft',
    ]);
    
    expect($blog->slug)->toBe('my-amazing-blog-post');
});

test('blog uses provided slug if given', function () {
    $user = createStudent();
    
    $blog = Blog::create([
        'author_id' => $user->id,
        'title' => 'My Amazing Blog Post',
        'slug' => 'custom-slug',
        'content' => 'Content here',
        'status' => 'draft',
    ]);
    
    expect($blog->slug)->toBe('custom-slug');
});

test('blog has author relationship', function () {
    $user = createStudent();
    
    $blog = Blog::create([
        'author_id' => $user->id,
        'title' => 'Test Blog',
        'content' => 'Content',
        'status' => 'draft',
    ]);
    
    expect($blog->author())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($blog->author)->toBeInstanceOf(User::class);
});

test('published scope returns only published blogs', function () {
    $user = createStudent();
    
    Blog::create([
        'author_id' => $user->id,
        'title' => 'Published Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);
    
    Blog::create([
        'author_id' => $user->id,
        'title' => 'Draft Blog',
        'content' => 'Content',
        'status' => 'draft',
    ]);
    
    expect(Blog::published()->count())->toBe(1);
});

test('published scope excludes blogs with future publish date', function () {
    $user = createStudent();
    
    Blog::create([
        'author_id' => $user->id,
        'title' => 'Future Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now()->addWeek(),
    ]);
    
    expect(Blog::published()->count())->toBe(0);
});

test('draft scope returns only draft blogs', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Published', 'content' => 'C', 'status' => 'published', 'published_at' => now()]);
    Blog::create(['author_id' => $user->id, 'title' => 'Draft', 'content' => 'C', 'status' => 'draft']);
    
    expect(Blog::draft()->count())->toBe(1);
});

test('archived scope returns only archived blogs', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Published', 'content' => 'C', 'status' => 'published', 'published_at' => now()]);
    Blog::create(['author_id' => $user->id, 'title' => 'Archived', 'content' => 'C', 'status' => 'archived']);
    
    expect(Blog::archived()->count())->toBe(1);
});

test('category scope filters by category', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Tech Post', 'content' => 'C', 'category' => 'Technology', 'status' => 'draft']);
    Blog::create(['author_id' => $user->id, 'title' => 'Design Post', 'content' => 'C', 'category' => 'Design', 'status' => 'draft']);
    
    expect(Blog::category('Technology')->count())->toBe(1);
});

test('search scope searches in title', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Laravel Tips', 'content' => 'Other content', 'status' => 'draft']);
    Blog::create(['author_id' => $user->id, 'title' => 'React Guide', 'content' => 'Different content', 'status' => 'draft']);
    
    expect(Blog::search('Laravel')->count())->toBe(1);
});

test('search scope searches in content', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Post 1', 'content' => 'Laravel framework tips', 'status' => 'draft']);
    Blog::create(['author_id' => $user->id, 'title' => 'Post 2', 'content' => 'React library guide', 'status' => 'draft']);
    
    expect(Blog::search('Laravel')->count())->toBe(1);
});

test('withTag scope filters by tag', function () {
    $user = createStudent();
    
    Blog::create(['author_id' => $user->id, 'title' => 'Post 1', 'content' => 'C', 'tags' => ['php', 'laravel'], 'status' => 'draft']);
    Blog::create(['author_id' => $user->id, 'title' => 'Post 2', 'content' => 'C', 'tags' => ['javascript', 'react'], 'status' => 'draft']);
    
    expect(Blog::withTag('laravel')->count())->toBe(1);
});

test('isPublished returns true for published blog', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Published Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);
    
    expect($blog->isPublished())->toBeTrue();
});

test('isPublished returns false for draft blog', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Draft Blog',
        'content' => 'Content',
        'status' => 'draft',
    ]);
    
    expect($blog->isPublished())->toBeFalse();
});

test('isPublished returns false for future published blog', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Future Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now()->addWeek(),
    ]);
    
    expect($blog->isPublished())->toBeFalse();
});

test('isDraft returns true for draft blog', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Draft Blog',
        'content' => 'Content',
        'status' => 'draft',
    ]);
    
    expect($blog->isDraft())->toBeTrue();
});

test('publish method sets status to published', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Draft Blog',
        'content' => 'Content',
        'status' => 'draft',
    ]);
    
    $blog->publish();
    
    expect($blog->fresh()->status)->toBe('published');
    expect($blog->fresh()->published_at)->not->toBeNull();
});

test('archive method sets status to archived', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Published Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now(),
    ]);
    
    $blog->archive();
    
    expect($blog->fresh()->status)->toBe('archived');
});

test('incrementViews increases view count', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Blog',
        'content' => 'Content',
        'status' => 'published',
        'published_at' => now(),
        'views' => 5,
    ]);
    
    $blog->incrementViews();
    
    expect($blog->fresh()->views)->toBe(6);
});

test('reading time attribute calculates correctly', function () {
    $content = str_repeat('word ', 400); // 400 words
    
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Blog',
        'content' => $content,
        'status' => 'draft',
    ]);
    
    expect($blog->reading_time)->toBe(2); // 400 words / 200 wpm = 2 minutes
});

test('tags are cast to array', function () {
    $blog = Blog::create([
        'author_id' => createStudent()->id,
        'title' => 'Blog',
        'content' => 'Content',
        'tags' => ['laravel', 'php', 'testing'],
        'status' => 'draft',
    ]);
    
    expect($blog->tags)->toBeArray();
    expect($blog->tags)->toBe(['laravel', 'php', 'testing']);
});
