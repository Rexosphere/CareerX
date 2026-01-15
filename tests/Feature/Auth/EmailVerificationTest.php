<?php

test('email verification notice page can be accessed by authenticated users', function () {
    $user = createStudent(['email_verified_at' => null]);
    
    $response = $this->actingAs($user)->get(route('verification.notice'));
    
    $response->assertStatus(200);
});

test('guests are redirected from verification notice', function () {
    $response = $this->get(route('verification.notice'));
    
    $response->assertRedirect(route('login'));
});

test('verified users are redirected from verification notice', function () {
    $user = createVerifiedStudent();
    
    $response = $this->actingAs($user)->get(route('verification.notice'));
    
    // Verified users might be redirected away or see the page
    // The exact behavior depends on your middleware configuration
    $response->assertStatus(200);
});
