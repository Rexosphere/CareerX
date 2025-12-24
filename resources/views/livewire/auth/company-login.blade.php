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

    public function mount(): void
    {
        if (auth('company')->check()) {
            $this->redirectRoute('company.dashboard');
        }
    }

    public function login(): void
    {
        $this->validate();

        if (auth('company')->attempt(['name' => $this->company_id, 'password' => $this->password], $this->remember)) {
            // Check status
            if (auth('company')->user()->status !== 'active') {
                auth('company')->logout();
                $this->addError('company_id', 'Your account is pending approval or has been rejected.');
                return;
            }

            session()->regenerate();
            $this->redirectRoute('company.dashboard', navigate: true);
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
                <x-input label="Company Name" wire:model="company_id" icon="o-identification"
                    placeholder="Enter your registered company name" type="text"
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

        <!-- Register Section -->
        <div class="mt-8 pt-6 border-t border-base-200">
            <div
                class="bg-primary/5 rounded-xl p-4 flex flex-col items-center gap-3 text-center border border-primary/10">
                <p class="text-sm font-medium text-base-content/70">
                    Not a partner yet?
                </p>
                <a href="{{ route('company-register') }}" class="btn btn-outline btn-primary btn-sm w-full font-bold">
                    Register Your Company
                </a>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-xs text-base-content/50 flex justify-center gap-4">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                <x-icon name="o-arrow-left" class="w-3 h-3" /> Back to Home
            </a>
            <span>•</span>
            <a href="#" class="hover:text-primary transition-colors">Support Portal</a>
        </div>
    </div>
</div>