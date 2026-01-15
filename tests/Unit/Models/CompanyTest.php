<?php

use App\Models\Company;
use App\Models\JobPosting;

test('company initials returns correct initials for single word name', function () {
    $company = Company::factory()->make(['name' => 'Google']);
    
    expect($company->initials())->toBe('G');
});

test('company initials returns correct initials for multi word name', function () {
    $company = Company::factory()->make(['name' => 'Tech Solutions Inc']);
    
    expect($company->initials())->toBe('TSI');
});

test('company has job postings relationship', function () {
    $company = createCompany();
    
    expect($company->jobPostings())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('company can create job postings', function () {
    $company = createCompany();
    
    $jobPosting = JobPosting::factory()->create(['company_id' => $company->id]);
    
    expect($company->jobPostings)->toHaveCount(1);
    expect($company->jobPostings->first()->id)->toBe($jobPosting->id);
});

test('company password is hashed', function () {
    $company = Company::factory()->create(['password' => 'password123']);
    
    expect($company->password)->not->toBe('password123');
    expect(password_verify('password123', $company->password))->toBeTrue();
});

test('company is authenticatable', function () {
    $company = new Company();
    
    expect($company)->toBeInstanceOf(\Illuminate\Foundation\Auth\User::class);
});

test('company has verified_at timestamp cast as datetime', function () {
    $company = Company::factory()->create(['verified_at' => now()]);
    
    expect($company->verified_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
