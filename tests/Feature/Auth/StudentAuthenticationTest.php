<?php

use App\Models\User;

test('student registration page can be rendered', function () {
    $response = $this->get(route('register'));
    
    $response->assertStatus(200);
});

test('student login page can be rendered', function () {
    $response = $this->get(route('login'));
    
    $response->assertStatus(200);
});

test('guests can access login page', function () {
    $response = $this->get(route('login'));
    
    $response->assertOk();
});

test('authenticated students are redirected from login page', function () {
    $user = createStudent();
    
    $response = $this->actingAs($user)->get(route('login'));
    
    $response->assertRedirect();
});

test('guests cannot access onboarding', function () {
    $response = $this->get(route('onboarding'));
    
    $response->assertRedirect(route('login'));
});

test('unverified students cannot access onboarding', function () {
    $user = createStudent(['email_verified_at' => null]);
    
    $response = $this->actingAs($user)->get(route('onboarding'));
    
    $response->assertRedirect(route('verification.notice'));
});

test('verified students can access onboarding', function () {
    $user = createVerifiedStudent();
    
    $response = $this->actingAs($user)->get(route('onboarding'));
    
    $response->assertStatus(200);
});

test('guests cannot access profile', function () {
    $response = $this->get(route('profile'));
    
    $response->assertRedirect(route('login'));
});

test('unverified students cannot access profile', function () {
    $user = createStudent(['email_verified_at' => null]);
    
    $response = $this->actingAs($user)->get(route('profile'));
    
    $response->assertRedirect(route('verification.notice'));
});

test('verified students can access profile', function () {
    $user = createVerifiedStudent();
    
    $response = $this->actingAs($user)->get(route('profile'));
    
    $response->assertStatus(200);
});

test('guests cannot access academia', function () {
    $response = $this->get(route('academia'));
    
    $response->assertRedirect(route('login'));
});

test('verified students can access academia', function () {
    $user = createVerifiedStudent();
    
    $response = $this->actingAs($user)->get(route('academia'));
    
    $response->assertStatus(200);
});
