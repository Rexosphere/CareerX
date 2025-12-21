<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/jobs', function () {
    return view('pages.jobs.index');
})->name('jobs.index');

Route::get('/students', function () {
    return view('pages.students.index');
})->name('students.index');

Route::get('/students/{id}', function ($id) {
    return view('pages.students.profile', ['studentId' => $id]);
})->name('students.profile');

Route::get('/resources', function () {
    return view('pages.resources.index');
})->name('resources.index');

Route::get('/blog', function () {
    return view('pages.blog.index');
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    return view('pages.blog.show', ['slug' => $slug, 'post' => []]);
})->name('blog.show');

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');

    Route::get('/onboarding', function () {
        return view('pages.onboarding.index');
    })->name('onboarding');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
