<?php

use App\Models\Company;

test('company dashboard can be accessed by authenticated companies', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')->get(route('company.dashboard'));
    
    $response->assertStatus(200);
});

test('guests cannot access company dashboard', function () {
    $response = $this->get(route('company.dashboard'));
    
    $response->assertRedirect();
});

test('students cannot access company dashboard', function () {
    $student = createStudent();
    
    $response = $this->actingAs($student)->get(route('company.dashboard'));
    
    $response->assertRedirect();
});
