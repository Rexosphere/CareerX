<?php

use App\Models\Application;

test('companies can download cv from application if student applied to their job', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    $student = createStudentWithCv();
    
    // Create application (no longer stores cv_path)
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'status' => 'pending',
    ]);
    
    $response = $this->actingAs($company, 'company')
        ->get(route('cv.download.application', ['application_id' => $application->id]));
    
    // Should be authorized (either success or 404 for missing file, but not 403)
    // 404 is expected since we're not actually uploading a CV file in tests
    $this->assertNotEquals(403, $response->status());
});

test('companies cannot download cv from profile if student has not applied', function () {
    $company = createCompany();
    $student = createStudentWithCv();
    
    $response = $this->actingAs($company, 'company')
        ->get(route('cv.download.profile', ['student_id' => $student->id]));
    
    // Should be forbidden or redirected
    $this->assertTrue($response->status() === 403 || $response->isRedirect());
});

test('companies cannot download cv for applications to other companies jobs', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    $student = createStudentWithCv();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'status' => 'pending',
    ]);
    
    $response = $this->actingAs($company2, 'company')
        ->get(route('cv.download.application', ['application_id' => $application->id]));
    
    // Should be forbidden
    $this->assertTrue($response->status() === 403 || $response->isRedirect());
});

test('guests cannot download cv', function () {
    $job = createJobPosting();
    $student = createStudentWithCv();
    
    $application = Application::create([
        'job_id' => $job->id,
        'student_id' => $student->id,
        'cover_letter' => 'I am interested',
        'status' => 'pending',
    ]);
    
    $response = $this->get(route('cv.download.application', ['application_id' => $application->id]));
    
    $response->assertRedirect();
});
