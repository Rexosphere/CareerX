@volt('verify-email')
<?php

use Livewire\Attributes\On;

new class extends \Livewire\Volt\Component {
    public $status = '';
    
    public function mount(): void
    {
        // If already verified, redirect immediately
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirectRoute('home');
        }
    }
    
    public function checkVerification(): void
    {
        // Refresh the user model from database
        auth()->user()->refresh();
        
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirectRoute('home');
        }
    }
    
    public function resendVerification(): void
    {
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirectRoute('home');
            return;
        }

        auth()->user()->sendEmailVerificationNotification();

        $this->status = 'verification-link-sent';
    }
}; ?>


<x-layouts.main title="Verify Email Address">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 bg-base-200/50" wire:poll.3s="checkVerification">
        <div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-md mx-auto">
            <div class="card-body p-6 sm:p-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mx-auto mb-3">
                        <x-icon name="o-envelope" class="w-6 h-6" />
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-base-content mb-1">
                        Verify Your Email
                    </h2>
                    <p class="text-base-content/60 text-sm">
                        We've sent a verification link to your email address
                    </p>
                </div>

                <!-- Success Message -->
                @if ($status === 'verification-link-sent' || session()->has('message'))
                    <x-alert icon="o-check-circle" class="alert-success mb-4 shadow-sm py-2 text-sm">
                        A fresh verification link has been sent to your email address.
                    </x-alert>
                @endif

                <!-- Auto-checking indicator -->
                <div class="alert alert-info mb-4">
                    <x-icon name="o-arrow-path" class="w-5 h-5 animate-spin" />
                    <div class="text-sm">
                        <p class="font-medium">Checking verification status...</p>
                        <p class="text-xs opacity-75">This page will auto-refresh when you verify your email</p>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-neutral mb-5">
                    <x-icon name="o-information-circle" class="w-5 h-5" />
                    <div class="text-sm">
                        <p class="font-medium mb-1">Email sent to:</p>
                        <p class="font-mono text-xs">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-3 mb-5 text-sm text-base-content/70">
                    <p>To complete your registration, please:</p>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Check your email inbox</li>
                        <li>Look for an email from CareerX</li>
                        <li>Click the verification link in the email</li>
                    </ol>
                    <p class="text-xs mt-3 text-base-content/50">
                        <strong>Note:</strong> If you don't see the email, check your spam or junk folder.
                    </p>
                    <p class="text-xs mt-2 text-info">
                        <strong>Tip:</strong> You can open the verification link on any browser or device!
                    </p>
                </div>

                <div class="divider text-xs text-base-content/50 my-4">Didn't receive the email?</div>

                <!-- Resend Button -->
                <form wire:submit="resendVerification" class="space-y-3">
                    <x-button label="Resend Verification Email"
                        class="btn-primary w-full btn-sm h-10 min-h-10 text-sm font-semibold shadow-md hover:shadow-lg transition-all"
                        type="submit" spinner="resendVerification" />
                </form>

                <!-- Logout Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('logout') }}" 
                        class="text-sm text-base-content/60 hover:text-primary transition-colors">
                        Sign out
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
@endvolt
