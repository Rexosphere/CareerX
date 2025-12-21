<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|email|ends_with:@uom.lk|unique:users')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    #[Validate('required|same:password')]
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate();

        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
        ]);

        // Assign student role by default
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        if ($studentRole) {
            $user->roles()->attach($studentRole);
        }

        auth()->login($user);
        $this->redirectRoute('home');
    }
}; ?>

<div class="card bg-base-100 shadow-xl border border-base-300">
    <div class="card-body">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                <x-icon name="o-user-plus" class="w-6 h-6" />
            </div>
            <h2 class="card-title text-3xl font-bold justify-center">
                Create Your Student Account
            </h2>
            <p class="text-base-content/70 mt-2">
                Join the exclusive recruitment platform for University of Moratuwa undergraduates.
            </p>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-alert icon="o-check-circle" class="alert-success mb-4">
                {{ session('message') }}
            </x-alert>
        @endif

        <!-- Form -->
        <form wire:submit="register">
            <!-- Name -->
            <x-input
                label="Full Name"
                wire:model="name"
                icon="o-user"
                placeholder="John Doe"
                type="text"
            />

            <!-- Email -->
            <x-input
                label="University Email Address"
                wire:model="email"
                icon="o-envelope"
                placeholder="index@uom.lk"
                type="email"
                hint="Please use your valid @uom.lk email address."
            />

            <!-- Password -->
            <x-input
                label="Password"
                wire:model="password"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
            />

            <!-- Confirm Password -->
            <x-input
                label="Confirm Password"
                wire:model="password_confirmation"
                type="password"
                icon="o-lock-closed"
                placeholder="••••••••"
            />

            <!-- Submit Button -->
            <div class="mt-6">
                <x-button label="Register" class="btn-primary w-full" type="submit" spinner="register" />
            </div>

            <!-- Divider -->
            <div class="divider text-sm text-base-content/60">Already have an account?</div>

            <!-- Login Link -->
            <a href="{{ route('login') }}" wire:navigate class="btn btn-outline w-full">
                Login
            </a>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-xs text-base-content/60">
            <a href="#" class="link link-hover">Terms of Service</a>
            <span class="mx-2">•</span>
            <a href="#" class="link link-hover">Privacy Policy</a>
        </div>
    </div>
</div>
