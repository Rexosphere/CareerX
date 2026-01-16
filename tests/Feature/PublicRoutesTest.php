<?php

test('home page can be accessed', function () {
    $response = $this->get(route('home'));
    
    $response->assertStatus(200);
});

test('jobs listing page can be accessed', function () {
    $response = $this->get(route('jobs.index'));
    
    $response->assertStatus(200);
});

test('courses index page can be accessed', function () {
    $response = $this->get(route('courses.index'));
    
    $response->assertStatus(200);
});

test('students listing page can be accessed', function () {
    $response = $this->get(route('students.index'));
    
    $response->assertStatus(200);
});

test('student profile page can be accessed with id', function () {
    $student = createStudent();
    
    $response = $this->get(route('students.profile', ['id' => $student->id]));
    
    $response->assertStatus(200);
});

test('blog index page can be accessed', function () {
    $response = $this->get(route('blog.index'));
    
    $response->assertStatus(200);
});

test('blog detail page can be accessed with slug', function () {
    // Create author first for foreign key
    $author = createStudent();
    
    // Create a blog post for the test
    App\Models\Blog::create([
        'author_id' => $author->id,
        'title' => 'Test Blog Post',
        'slug' => 'test-slug',
        'excerpt' => 'Test excerpt',
        'content' => 'Test content',
        'category' => 'Technology',
        'status' => 'published',
        'published_at' => now(),
    ]);
    
    $response = $this->get(route('blog.show', ['slug' => 'test-slug']));
    
    $response->assertStatus(200);
});

test('privacy policy page can be accessed', function () {
    $response = $this->get(route('legal.privacy'));
    
    $response->assertStatus(200);
});

test('terms of service page can be accessed', function () {
    $response = $this->get(route('legal.terms'));
    
    $response->assertStatus(200);
});

test('about page can be accessed', function () {
    $response = $this->get(route('about'));
    
    $response->assertStatus(200);
});
