<?php

use App\Models\Application;

test('companies can download cv from application if student applied to their job', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    $student = createStudent();
    
    // Create application
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'cv_path' => 'cv/test.pdf',
        'status' => 'pending',
    ]);
    
    $response = $this->actingAs($company, 'company')
        ->get(route('cv.download.application', ['application_id' => $application->id]));
    
    // Should be able to access (200) or download (redirect/file response)
    $this->assertTrue(
        $response->isOk() || $response->isRedirect() || $response->headers->get('content-type') === 'application/pdf'
    );
});

test('companies cannot download cv from profile if student has not applied', function () {
    $company = createCompany();
    $student = createStudent();
    
    $response = $this->actingAs($company, 'company')
        ->get(route('cv.download.profile', ['student_id' => $student->id]));
    
    // Should be forbidden or redirected
    $this->assertTrue($response->status() === 403 || $response->isRedirect());
});

test('companies cannot download cv for applications to other companies jobs', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    $student = createStudent();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'cv_path' => 'cv/test.pdf',
        'status' => 'pending',
    ]);
    
    $response = $this->actingAs($company2, 'company')
        ->get(route('cv.download.application', ['application_id' => $application->id]));
    
    // Should be forbidden
    $this->assertTrue($response->status() === 403 || $response->isRedirect());
});

test('guests cannot download cv', function () {
    $job = createJobPosting();
    $student = createStudent();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'cv_path' => 'cv/test.pdf',
        'status' => 'pending',
    ]);
    
    $response = $this->get(route('cv.download.application', ['application_id' => $application->id]));
    
    $response->assertRedirect();
});
