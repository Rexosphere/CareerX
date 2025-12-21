<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $validated = $this->validate();

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $this->redirectRoute('home');
        } else {
            $this->addError('email', 'Invalid credentials.');
        }
    }
}; ?>

<div class="card bg-base-100 shadow-xl border border-base-300">
    <div class="card-body">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                <x-icon name="o-arrow-right-on-rectangle" class="w-6 h-6" />
            </div>
            <h2 class="card-title text-3xl font-bold justify-center">
                Welcome Back
            </h2>
            <p class="text-base-content/70 mt-2">
                Sign in to access your student account and explore opportunities.
            </p>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-alert icon="o-check-circle" class="alert-success mb-4">
                {{ session('message') }}
            </x-alert>
        @endif

        <!-- Form -->
        <form wire:submit="login">
            <!-- Email -->
            <x-input
                label="Email Address"
                wire:model="email"
                icon="o-envelope"
                placeholder="index@uom.lk"
                type="email"
            />

            <!-- Password -->
            <x-input
                label="Password"
                wire:model="password"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
            >
                <x-slot:append>
                    <a href="#" class="link link-primary text-xs">Forgot?</a>
                </x-slot:append>
            </x-input>

            <!-- Remember Me -->
            <x-checkbox label="Remember me" wire:model="remember" />

            <!-- Submit Button -->
            <div class="mt-6">
                <x-button label="Login" class="btn-primary w-full" type="submit" spinner="login" />
            </div>

            <!-- Divider -->
            <div class="divider text-sm text-base-content/60">Don't have an account?</div>

            <!-- Register Link -->
            <a href="{{ route('register') }}" wire:navigate class="btn btn-outline w-full">
                Create Account
            </a>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-xs text-base-content/60">
            <a href="#" class="link link-hover">Need Help?</a>
            <span class="mx-2">•</span>
            <a href="#" class="link link-hover">Contact Support</a>
        </div>
    </div>
</div>
