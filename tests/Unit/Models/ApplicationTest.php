<?php

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;

test('application has job posting relationship', function () {
    $job = createJobPosting();
    $student = createStudent();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'Test cover letter',
        'status' => 'pending',
    ]);
    
    expect($application->jobPosting())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($application->jobPosting)->toBeInstanceOf(JobPosting::class);
});

test('application has student relationship', function () {
    $job = createJobPosting();
    $student = createStudent();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'Test cover letter',
        'status' => 'pending',
    ]);
    
    expect($application->student())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($application->student)->toBeInstanceOf(User::class);
});

test('pending scope returns only pending applications', function () {
    $job = createJobPosting();
    $student1 = createStudent();
    $student2 = createStudent();
    
    Application::create(['job_id' => $job->id, 'student_id' => $student1->id, 'status' => 'pending', 'cover_letter' => 'Test']);
    Application::create(['job_id' => $job->id, 'student_id' => $student2->id, 'status' => 'reviewed', 'cover_letter' => 'Test']);
    
    expect(Application::pending()->count())->toBe(1);
});

test('reviewed scope returns only reviewed applications', function () {
    $job = createJobPosting();
    $student1 = createStudent();
    $student2 = createStudent();
    
    Application::create(['job_id' => $job->id, 'student_id' => $student1->id, 'status' => 'pending', 'cover_letter' => 'Test']);
    Application::create(['job_id' => $job->id, 'student_id' => $student2->id, 'status' => 'reviewed', 'cover_letter' => 'Test']);
    
    expect(Application::reviewed()->count())->toBe(1);
});

test('shortlisted scope returns only shortlisted applications', function () {
    $job = createJobPosting();
    $student1 = createStudent();
    $student2 = createStudent();
    
    Application::create(['job_id' => $job->id, 'student_id' => $student1->id, 'status' => 'pending', 'cover_letter' => 'Test']);
    Application::create(['job_id' => $job->id, 'student_id' => $student2->id, 'status' => 'shortlisted', 'cover_letter' => 'Test']);
    
    expect(Application::shortlisted()->count())->toBe(1);
});

test('accepted scope returns only accepted applications', function () {
    $job = createJobPosting();
    $student1 = createStudent();
    $student2 = createStudent();
    
    Application::create(['job_id' => $job->id, 'student_id' => $student1->id, 'status' => 'pending', 'cover_letter' => 'Test']);
    Application::create(['job_id' => $job->id, 'student_id' => $student2->id, 'status' => 'accepted', 'cover_letter' => 'Test']);
    
    expect(Application::accepted()->count())->toBe(1);
});

test('rejected scope returns only rejected applications', function () {
    $job = createJobPosting();
    $student1 = createStudent();
    $student2 = createStudent();
    
    Application::create(['job_id' => $job->id, 'student_id' => $student1->id, 'status' => 'pending', 'cover_letter' => 'Test']);
    Application::create(['job_id' => $job->id, 'student_id' => $student2->id, 'status' => 'rejected', 'cover_letter' => 'Test']);
    
    expect(Application::rejected()->count())->toBe(1);
});

test('isPending returns true for pending application', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'pending',
        'cover_letter' => 'Test',
    ]);
    
    expect($application->isPending())->toBeTrue();
});

test('isPending returns false for non-pending application', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'accepted',
        'cover_letter' => 'Test',
    ]);
    
    expect($application->isPending())->toBeFalse();
});

test('isAccepted returns true for accepted application', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'accepted',
        'cover_letter' => 'Test',
    ]);
    
    expect($application->isAccepted())->toBeTrue();
});

test('isRejected returns true for rejected application', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'rejected',
        'cover_letter' => 'Test',
    ]);
    
    expect($application->isRejected())->toBeTrue();
});

test('markAsReviewed updates status to reviewed', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'pending',
        'cover_letter' => 'Test',
    ]);
    
    $application->markAsReviewed();
    
    expect($application->fresh()->status)->toBe('reviewed');
});

test('markAsShortlisted updates status to shortlisted', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'pending',
        'cover_letter' => 'Test',
    ]);
    
    $application->markAsShortlisted();
    
    expect($application->fresh()->status)->toBe('shortlisted');
});

test('accept updates status to accepted', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'pending',
        'cover_letter' => 'Test',
    ]);
    
    $application->accept();
    
    expect($application->fresh()->status)->toBe('accepted');
});

test('reject updates status to rejected', function () {
    $application = Application::create([
        'job_id' => createJobPosting()->id,
        'student_id' => createStudent()->id,
        'status' => 'pending',
        'cover_letter' => 'Test',
    ]);
    
    $application->reject();
    
    expect($application->fresh()->status)->toBe('rejected');
});
