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
        $this->redirectRoute('onboarding');
    }
}; ?>

<div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-md mx-auto">
    <div class="card-body p-6 sm:p-8">
        <!-- Header -->
        <div class="text-center mb-5">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-3">
                <x-icon name="o-user-plus" class="w-6 h-6" />
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-base-content mb-1">
                Create Account
            </h2>
            <p class="text-base-content/60 text-sm">
                Join the exclusive platform for University of Moratuwa
            </p>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-alert icon="o-check-circle" class="alert-success mb-4 shadow-sm py-2 text-sm">
                {{ session('message') }}
            </x-alert>
        @endif

        <!-- Form -->
        <form wire:submit="register" class="space-y-3">
            <!-- Name -->
            <div class="form-control">
                <x-input label="Full Name" wire:model="name" icon="o-user" placeholder="John Doe" type="text"
                    class=" input-bordered focus:border-primary focus:ring-primary w-full" />
            </div>

            <!-- Email -->
            <div class="form-control">
                <x-input label="University Email" wire:model="email" icon="o-envelope" placeholder="index@uom.lk"
                    type="email" class=" input-bordered focus:border-primary focus:ring-primary w-full" />
                <label class="label py-0 pt-1">
                    <span class="label-text-alt text-base-content/50">Must be a valid @uom.lk email address</span>
                </label>
            </div>

            <!-- Password -->
            <div class="form-control">
                <x-input label="Password" wire:model="password" type="password" icon="o-lock-closed"
                    placeholder="••••••••" class="input-bordered focus:border-primary focus:ring-primary w-full" />
            </div>

            <!-- Confirm Password -->
            <div class="form-control">
                <x-input label="Confirm Password" wire:model="password_confirmation" type="password"
                    icon="o-lock-closed" placeholder="••••••••"
                    class="input-bordered focus:border-primary focus:ring-primary w-full" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-button label="Create Account"
                    class="btn-primary w-full btn-sm h-10 min-h-10 text-sm font-semibold shadow-md hover:shadow-lg transition-all"
                    type="submit" spinner="register" />
            </div>
        </form>

        <!-- Divider -->
        <div class="divider text-xs text-base-content/50 my-4">OR</div>

        <!-- Login Link -->
        <a href="{{ route('login') }}" wire:navigate
            class="btn btn-outline border-whiteborder-base-300 w-full btn-sm h-10 min-h-10 hover:bg-base-200 hover:border-base-400 font-medium">
            Sign In to Existing Account
        </a>

        <!-- Footer Links -->
        <div class="text-center mt-5 text-xs text-base-content/50 flex justify-center gap-4">
            <a href="#" class="hover:text-primary transition-colors">Terms of Service</a>
            <span>•</span>
            <a href="#" class="hover:text-primary transition-colors">Privacy Policy</a>
        </div>
    </div>
</div>