<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function mount(): void
    {
        if (auth('admin')->check()) {
            $this->redirectRoute('admin.dashboard');
        }
    }

    public function login(): void
    {
        $this->validate();

        if (auth('admin')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $this->redirectRoute('admin.dashboard', navigate: true);
            return;
        }

        $this->addError('email', 'Invalid credentials.');
    }
}; ?>

<div
    class="card bg-base-100/80 backdrop-blur-md shadow-2xl border-t-4 border-t-error border-x border-b border-base-200 w-full max-w-md mx-auto overflow-hidden relative group">
    <!-- Decorative background elements -->
    <div
        class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-error/10 rounded-full blur-2xl group-hover:bg-error/20 transition-all duration-700">
    </div>
    <div
        class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 bg-error/5 rounded-full blur-2xl group-hover:bg-error/15 transition-all duration-700">
    </div>

    <div class="card-body p-8 sm:p-10 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="relative w-16 h-16 mx-auto mb-5">
                <div
                    class="absolute inset-0 bg-error/20 rounded-2xl rotate-3 transition-transform group-hover:rotate-6">
                </div>
                <div
                    class="absolute inset-0 bg-base-100 rounded-2xl shadow-sm flex items-center justify-center border border-error/20 -rotate-3 transition-transform group-hover:-rotate-6">
                    <x-icon name="o-shield-check" class="w-8 h-8 text-error" />
                </div>
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-base-content mb-1">
                Admin Access
            </h2>
            <p class="text-error/80 text-sm font-medium uppercase tracking-widest">
                Authorized Personnel Only
            </p>
        </div>

        <!-- Error Message -->
        @if ($errors->has('email'))
            <div
                class="alert alert-error mb-6 shadow-sm rounded-lg border border-error/20 bg-error/10 text-error-content text-sm">
                <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
                <span>{{ $errors->first('email') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form wire:submit="login" class="space-y-5">
            <!-- Email -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text mb-2 font-medium">Administrator Email</span>
                </label>
                <label
                    class="input w-full input-bordered flex items-center gap-2 focus-within:border-error focus-within:ring-error text-base-content/80 bg-base-200/50">
                    <x-icon name="o-user" class="w-5 h-5 opacity-70" />
                    <input type="email" wire:model="email" class="grow" placeholder="admin@careerx.com" />
                </label>
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text mb-2 font-medium">Secure Key</span>
                </label>
                <label
                    class="input w-full input-bordered flex items-center gap-2 focus-within:border-error focus-within:ring-error text-base-content/80 bg-base-200/50">
                    <x-icon name="o-lock-closed" class="w-5 h-5 opacity-70" />
                    <input type="password" wire:model="password" class="grow" placeholder="••••••••" />
                </label>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="cursor-pointer label p-0 gap-2">
                    <input type="checkbox" wire:model="remember" class="checkbox checkbox-error checkbox-sm rounded" />
                    <span class="label-text text-sm">Remember Session</span>
                </label>
                <a href="{{ route('password.request') }}"
                    class="link link-hover text-xs text-base-content/60 hover:text-error transition-colors">
                    Lost Credentials?
                </a>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="btn btn-error w-full text-white shadow-lg hover:shadow-error/30 hover:scale-[1.01] transition-all duration-200 font-bold tracking-wide">
                    <x-icon name="o-lock-open" class="w-5 h-5 mr-1" />
                    Authenticate
                    <span wire:loading wire:target="login" class="loading loading-spinner loading-sm ml-2"></span>
                </button>
            </div>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-8 pt-6 border-t border-base-200/50">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm text-base-content/50 hover:text-base-content transition-colors group/link">
                <x-icon name="o-arrow-left" class="w-4 h-4 group-hover/link:-translate-x-1 transition-transform" />
                Return to Public Site
            </a>
        </div>
    </div>
</div>