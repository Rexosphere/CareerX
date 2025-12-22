<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

new class extends Component {
    #[Validate('required|string|max:255|unique:companies,name')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:companies,email')]
    public string $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public bool $registered = false;

    public function register(): void
    {
        $this->validate();

        Company::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => 'pending',
        ]);

        $this->registered = true;
    }
}; ?>

<div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-xl mx-auto overflow-hidden">
    <div class="card-body p-8 sm:p-12">
        @if($registered)
            <div class="text-center py-8">
                <div
                    class="w-24 h-24 bg-warning/10 rounded-full flex items-center justify-center text-warning mx-auto mb-8 animate-pulse">
                    <x-icon name="o-clock" class="w-12 h-12" />
                </div>
                <h2 class="text-3xl font-black tracking-tight text-base-content mb-4">
                    Registration Pending
                </h2>
                <div class="space-y-4 max-w-sm mx-auto">
                    <p class="text-base-content/70">
                        Thank you for registering <span class="font-bold text-base-content">{{ $name }}</span>!
                    </p>
                    <p class="text-sm text-base-content/60 leading-relaxed">
                        Your request has been sent to the CareerX administration team for review. You will receive an email
                        once your account is activated.
                    </p>
                </div>

                <div class="mt-12 pt-8 border-t border-base-200">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-outline gap-2 px-8">
                        <x-icon name="o-home" class="w-5 h-5" />
                        Back to Homepage
                    </a>
                </div>
            </div>
        @else
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-6">
                    <x-icon name="o-building-office-2" class="w-8 h-8" />
                </div>
                <h2 class="text-3xl font-black tracking-tight text-base-content mb-3">
                    Partner with CareerX
                </h2>
                <p class="text-base-content/60 text-sm max-w-xs mx-auto">
                    Join our network to recruit top talent from the University of Moratuwa.
                </p>
            </div>

            <!-- Form -->
            <form wire:submit="register" class="space-y-6">
                <!-- Company Name -->
                <div class="form-control">
                    <x-input label="Company Name" wire:model="name" icon="o-identification"
                        placeholder="e.g. Acme Corporation"
                        class="input-bordered focus:border-primary focus:ring-primary h-12" />
                </div>

                <!-- Email -->
                <div class="form-control">
                    <x-input label="Official Email Address" wire:model="email" type="email" icon="o-envelope"
                        placeholder="recruitment@company.com"
                        class="input-bordered focus:border-primary focus:ring-primary h-12"
                        hint="We will use this for account verification" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="form-control">
                        <x-input label="Password" wire:model="password" type="password" icon="o-lock-closed"
                            placeholder="••••••••" class="input-bordered focus:border-primary focus:ring-primary h-12" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control">
                        <x-input label="Confirm Password" wire:model="password_confirmation" type="password"
                            icon="o-shield-check" placeholder="••••••••"
                            class="input-bordered focus:border-primary focus:ring-primary h-12" />
                    </div>
                </div>

                <!-- Notice -->
                <div class="bg-base-200/50 p-4 rounded-xl border border-base-300 flex items-start gap-4">
                    <x-icon name="o-information-circle" class="w-6 h-6 text-primary shrink-0 mt-0.5" />
                    <p class="text-xs text-base-content/70 leading-relaxed">
                        By registering, you agree to our terms of service. All new company accounts are subject to
                        administrative review before job postings can be made live.
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <x-button label="Register Company"
                        class="btn-primary w-full h-12 text-base font-bold shadow-lg hover:shadow-primary/20 transition-all"
                        type="submit" spinner="register" />
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-10 pt-6 border-t border-base-200">
                <p class="text-sm text-base-content/60">
                    Already registered?
                    <a href="{{ route('company-login') }}"
                        class="link link-primary font-bold decoration-2 underline-offset-4">Sign in here</a>
                </p>
            </div>
        @endif
    </div>
</div>