<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;

new class extends Component {
    #[Validate('required')]
    public string $company_id = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        // Assuming 'company_id' is stored in the 'email' column or a specific 'username' column for companies
        // Adjust the key 'email' below if your database uses a different column name for the identifier
        if (auth()->attempt(['email' => $this->company_id, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $this->redirectRoute('dashboard');
        } else {
            throw ValidationException::withMessages([
                'company_id' => 'The provided credentials do not match our records.',
            ]);
        }
    }
}; ?>

<div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-md mx-auto">
    <div class="card-body p-8 sm:p-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-5">
                <x-icon name="o-building-office-2" class="w-7 h-7" />
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-base-content mb-2">
                Company Portal
            </h2>
            <p class="text-base-content/60 text-sm">
                Sign in with your Company ID to access recruitment tools
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-5">
            <!-- Company ID -->
            <div class="form-control">
                <x-input label="Company ID" wire:model="company_id" icon="o-identification"
                    placeholder="Enter your Company ID" type="text"
                    class="input-bordered focus:border-primary focus:ring-primary" />
            </div>

            <!-- Password -->
            <div class="form-control">
                <x-input label="Password" wire:model="password" type="password" icon="o-lock-closed"
                    placeholder="••••••••" class="input-bordered focus:border-primary focus:ring-primary" />
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
                <x-button label="Company Login"
                    class="btn-primary w-full text-base font-semibold shadow-md hover:shadow-lg transition-all"
                    type="submit" spinner="login" />
            </div>
        </form>

        <!-- Divider -->


        <!-- Footer Links -->
        <div class="text-center mt-8 text-xs text-base-content/50 flex justify-center gap-4">
            <a href="#" class="hover:text-primary transition-colors">Partner with Us</a>
            <span>•</span>
            <a href="#" class="hover:text-primary transition-colors">Support</a>
        </div>
    </div>
</div>