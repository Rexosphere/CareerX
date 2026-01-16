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
    
    // Verified users are redirected by the Livewire component's mount() method
    $response->assertRedirect(route('home'));
});
