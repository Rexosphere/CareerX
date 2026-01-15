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
            $this->redirectRoute('profile');
        } else {
            $this->addError('email', 'Invalid credentials.');
        }
    }
}; ?>

<div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-md mx-auto">
    <div class="card-body p-8 sm:p-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-5">
                <x-icon name="o-arrow-right-on-rectangle" class="w-7 h-7" />
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-base-content mb-2">
                Welcome Back
            </h2>
            <p class="text-base-content/60 text-sm">
                Sign in to access your dashboard and opportunities
            </p>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-alert icon="o-check-circle" class="alert-success mb-6 shadow-sm">
                {{ session('message') }}
            </x-alert>
        @endif

        <!-- Form -->
        <form wire:submit="login" class="space-y-5">
            <!-- Email -->
            <div class="form-control">
                <x-input label="Email Address" wire:model="email" icon="o-envelope" placeholder="your.email@example.com"
                    type="email" class="input-bordered focus:border-primary focus:ring-primary" />
            </div>

            <!-- Password -->
            <div class="form-control">
                <x-input label="Password" wire:model="password" type="password" icon="o-lock-closed"
                    placeholder="••••••••" class="input-bordered focus:border-primary focus:ring-primary">
                </x-input>
                <div class="flex justify-end mt-1">
                    <a href="{{ route('password.request') }}"
                        class="link link-primary text-xs font-semibold hover:no-underline">Forgot Password?</a>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <x-checkbox label="Keep me signed in" wire:model="remember" class="checkbox-primary checkbox-sm" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-button label="Sign In"
                    class="btn-primary w-full text-base font-semibold shadow-md hover:shadow-lg transition-all"
                    type="submit" spinner="login" />
            </div>
        </form>

        <!-- Divider -->
        <div class="divider text-xs text-base-content/50 my-6">OR</div>

        <!-- Register Link -->
        <a href="{{ route('register') }}" wire:navigate
            class="btn btn-outline border-white border-base-300 w-full hover:bg-base-200 hover:border-base-400 font-medium">
            Create New Account
        </a>

        <!-- Footer Links -->
        <div class="text-center mt-8 text-xs text-base-content/50 flex justify-center gap-4">
            <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
            <span>•</span>
            <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
        </div>
    </div>
</div>