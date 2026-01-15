<?php

test('student authentication does not affect company guard', function () {
    $student = createStudent();
    $company = createCompany();
    
    // Authenticate as student
    $this->actingAs($student);
    
    // Try to access company dashboard
    $response = $this->get(route('company.dashboard'));
    
    // Should be redirected because student guard is different from company guard
    $response->assertRedirect();
});

test('company authentication does not affect student guard', function () {
    $company = createCompany();
    
    // Authenticate as company
    $this->actingAs($company, 'company');
    
    // Try to access student profile
    $response = $this->get(route('profile'));
    
    // Should be redirected because company guard is different from student guard
    $response->assertRedirect();
});

test('company authentication does not affect admin guard', function () {
    $company = createCompany();
    
    // Authenticate as company
    $this->actingAs($company, 'company');
    
    // Try to access admin dashboard
    $response = $this->get(route('admin.dashboard'));
    
    // Should be redirected
    $response->assertRedirect();
});

test('authenticated student can access student routes', function () {
    $student = createVerifiedStudent();
    
    $response = $this->actingAs($student)->get(route('profile'));
    
    $response->assertOk();
});

test('authenticated company can access company routes', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')->get(route('company.dashboard'));
    
    $response->assertOk();
});
