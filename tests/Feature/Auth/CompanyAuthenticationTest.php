<?php

use App\Models\Company;

test('company login page can be rendered', function () {
    $response = $this->get(route('company-login'));
    
    $response->assertStatus(200);
});

test('company registration page can be rendered', function () {
    $response = $this->get(route('company-register'));
    
    $response->assertStatus(200);
});

test('guests can access company login page', function () {
    $response = $this->get(route('company-login'));
    
    $response->assertOk();
});

test('guests cannot access company dashboard', function () {
    $response = $this->get(route('company.dashboard'));
    
    $response->assertRedirect();
});

test('authenticated companies can access dashboard', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')->get(route('company.dashboard'));
    
    $response->assertStatus(200);
});

test('students cannot access company dashboard', function () {
    $student = createStudent();
    
    $response = $this->actingAs($student)->get(route('company.dashboard'));
    
    $response->assertRedirect();
});

test('companies can access job creation page', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')->get(route('jobs.create'));
    
    $response->assertStatus(200);
});

test('guests cannot access job creation page', function () {
    $response = $this->get(route('jobs.create'));
    
    $response->assertRedirect();
});
