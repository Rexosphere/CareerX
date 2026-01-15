<?php

use App\Models\JobPosting;
use App\Models\Application;

test('companies can view their own job postings applications', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    
    $response = $this->actingAs($company, 'company')
        ->get(route('jobs.applications', ['job' => $job->id]));
    
    $response->assertStatus(200);
});

test('companies cannot view other companies job applications', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    
    $response = $this->actingAs($company2, 'company')
        ->get(route('jobs.applications', ['job' => $job->id]));
    
    $response->assertStatus(403);
});

test('companies can edit their own job postings', function () {
    $company = createCompany();
    $job = createJobPosting($company);
    
    $response = $this->actingAs($company, 'company')
        ->get(route('jobs.edit', ['job' => $job->id]));
    
    $response->assertStatus(200);
});

test('companies cannot edit other companies job postings', function () {
    $company1 = createCompany();
    $company2 = createCompany();
    $job = createJobPosting($company1);
    
    $response = $this->actingAs($company2, 'company')
        ->get(route('jobs.edit', ['job' => $job->id]));
    
    $response->assertStatus(403);
});

test('companies can view applicants page', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')
        ->get(route('applicants.index'));
    
    $response->assertStatus(200);
});

test('guests cannot view applicants page', function () {
    $response = $this->get(route('applicants.index'));
    
    $response->assertRedirect();
});
