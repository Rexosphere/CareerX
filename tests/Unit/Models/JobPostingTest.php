<?php

use App\Models\JobPosting;
use App\Models\Company;
use App\Models\Application;

test('job posting has company relationship', function () {
    $jobPosting = createJobPosting();
    
    expect($jobPosting->company())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($jobPosting->company)->toBeInstanceOf(Company::class);
});

test('job posting has applications relationship', function () {
    $jobPosting = createJobPosting();
    
    expect($jobPosting->applications())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('active scope returns only active job postings', function () {
    createJobPosting(null, ['is_active' => true, 'title' => 'Active Job']);
    createJobPosting(null, ['is_active' => false, 'title' => 'Inactive Job']);
    
    $activeJobs = JobPosting::active()->get();
    
    expect($activeJobs)->toHaveCount(1);
    expect($activeJobs->first()->title)->toBe('Active Job');
});

test('open scope returns active jobs without deadline', function () {
    createJobPosting(null, ['is_active' => true, 'application_deadline' => null]);
    createJobPosting(null, ['is_active' => false, 'application_deadline' => null]);
    
    $openJobs = JobPosting::open()->get();
    
    expect($openJobs)->toHaveCount(1);
});

test('open scope returns active jobs with future deadline', function () {
    createJobPosting(null, ['is_active' => true, 'application_deadline' => now()->addDays(7)]);
    createJobPosting(null, ['is_active' => true, 'application_deadline' => now()->subDays(7)]);
    
    $openJobs = JobPosting::open()->get();
    
    expect($openJobs)->toHaveCount(1);
});

test('isOpen returns true when job is active with no deadline', function () {
    $job = createJobPosting(null, ['is_active' => true, 'application_deadline' => null]);
    
    expect($job->isOpen())->toBeTrue();
});

test('isOpen returns true when job is active with future deadline', function () {
    $job = createJobPosting(null, ['is_active' => true, 'application_deadline' => now()->addDays(7)]);
    
    expect($job->isOpen())->toBeTrue();
});

test('isOpen returns false when job is inactive', function () {
    $job = createJobPosting(null, ['is_active' => false, 'application_deadline' => now()->addDays(7)]);
    
    expect($job->isOpen())->toBeFalse();
});

test('isOpen returns false when deadline has passed', function () {
    $job = createJobPosting(null, ['is_active' => true, 'application_deadline' => now()->subDays(1)]);
    
    expect($job->isOpen())->toBeFalse();
});

test('applicationsCount returns correct number of applications', function () {
    $job = createJobPosting();
    $student = createStudent();
    
    Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'Test',
        'status' => 'pending',
    ]);
    
    Application::create([
        'job_id' => $job->id,
        'student_id' => createStudent()->id,
        'cover_letter' => 'Test 2',
        'status' => 'pending',
    ]);
    
    expect($job->applicationsCount())->toBe(2);
});

test('canEdit returns true when user owns the job posting', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    
    expect($job->canEdit($company))->toBeTrue();
});

test('canEdit returns false when user does not own the job posting', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    
    expect($job->canEdit($company2))->toBeFalse();
});

test('canEdit returns false when user is null', function () {
    $job = createJobPosting();
    
    expect($job->canEdit(null))->toBeFalse();
});

test('canDelete returns true when user owns the job posting', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    
    expect($job->canDelete($company))->toBeTrue();
});

test('canDelete returns false when user does not own the job posting', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    
    expect($job->canDelete($company2))->toBeFalse();
});

test('job posting supports soft deletes', function () {
    $job = createJobPosting();
    $jobId = $job->id;
    
    $job->delete();
    
    expect(JobPosting::find($jobId))->toBeNull();
    expect(JobPosting::withTrashed()->find($jobId))->not->toBeNull();
});

test('requirements are cast to array', function () {
    $job = createJobPosting(null, ['requirements' => ['PHP', 'Laravel', 'MySQL']]);
    
    expect($job->requirements)->toBeArray();
    expect($job->requirements)->toBe(['PHP', 'Laravel', 'MySQL']);
});

test('application_deadline is cast to date', function () {
    $job = createJobPosting(null, ['application_deadline' => '2026-12-31']);
    
    expect($job->application_deadline)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
