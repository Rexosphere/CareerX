<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicantController;
use App\Livewire\Admin\Dashboard as AdminDashboard;

// Public Routes
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/jobs', function () {
    return view('pages.jobs.index');
})->name('jobs.index');

Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

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

// Legal Pages
Route::get('/privacy-policy', function () {
    return view('pages.legal.privacy');
})->name('legal.privacy');

Route::get('/terms-of-service', function () {
    return view('pages.legal.terms');
})->name('legal.terms');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Auth Login Routes
Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/company-login', function () {
    return view('pages.auth.company-login');
})->name('company-login');

Route::get('/company-register', function () {
    return view('pages.auth.company-register');
})->name('company-register');

Route::get('/admin/login', function () {
    return view('pages.auth.admin-login');
})->name('admin.login');

// Admin Routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
});

// Company Routes
Route::middleware(['auth:company'])->group(function () {
    Route::get('/company/profile', [CompanyController::class, 'profile'])->name('company.profile');
    Route::get('/jobs/create', function () {
        return view('pages.jobs.create');
    })->name('jobs.create');
    Route::get('/jobs/{job}/applications', function ($jobId) {
        $job = \App\Models\JobPosting::findOrFail($jobId);
        if ($job->company_id !== auth('company')->id()) {
            abort(403);
        }
        return view('pages.jobs.applications', ['job' => $job]);
    })->name('jobs.applications');
    Route::get('/jobs/{job}/edit', function ($jobId) {
        $job = \App\Models\JobPosting::findOrFail($jobId);
        // Authorization check
        if ($job->company_id !== auth('company')->id()) {
            abort(403);
        }
        return view('pages.jobs.edit', ['job' => $job]);
    })->name('jobs.edit');
    Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');

    // Reuse dashboard for company for now if needed, or redirect
    // Reuse dashboard for company for now if needed, or redirect
    Route::get('/company/dashboard', \App\Livewire\Company\Dashboard::class)->name('company.dashboard');
});

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('pages.auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Student (Web) Routes
Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/onboarding', function () {
        return view('pages.onboarding.index');
    })->name('onboarding');

    Route::get('/profile', function () {
        return view('pages.profile.index');
    })->name('profile');

    Route::get('/academia', function () {
        return view('pages.academia.index');
    })->name('academia');
});

Route::match(['get', 'post'], '/logout', LogoutController::class)->name('logout');
