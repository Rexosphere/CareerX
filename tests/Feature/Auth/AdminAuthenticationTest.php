<?php

test('admin login page can be rendered', function () {
    $response = $this->get(route('admin.login'));
    
    $response->assertStatus(200);
});

test('guests cannot access admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));
    
    $response->assertRedirect();
});

test('students cannot access admin dashboard', function () {
    $student = createStudent();
    
    $response = $this->actingAs($student)->get(route('admin.dashboard'));
    
    $response->assertRedirect();
});

test('companies cannot access admin dashboard', function () {
    $company = createCompany();
    
    $response = $this->actingAs($company, 'company')->get(route('admin.dashboard'));
    
    $response->assertRedirect();
});
