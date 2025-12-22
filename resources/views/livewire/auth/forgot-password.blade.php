<x-layouts.centered title="Forgot Password">
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                        <x-icon name="o-question-mark-circle" class="w-6 h-6" />
                    </div>
                    <h2 class="card-title text-3xl font-bold justify-center">
                        Forgot Password?
                    </h2>
                    <p class="text-base-content/70 mt-2">
                        No worries! Enter your email and we'll send you a reset link.
                    </p>
                </div>

                <!-- Status Message -->
                @if (session('status'))
                    <x-alert icon="o-check-circle" class="alert-success mb-4">
                        {{ session('status') }}
                    </x-alert>
                @endif

                <!-- Instructions -->
                <div class="alert alert-info mb-4">
                    <x-icon name="o-information-circle" class="w-5 h-5" />
                    <div class="text-sm">
                        <p>Enter your registered email address and we'll send you a link to reset your password.</p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <x-input
                        label="Email Address"
                        name="email"
                        type="email"
                        icon="o-envelope"
                        placeholder="index@uom.lk"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />

                    @error('email')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button
                            label="Send Reset Link"
                            class="btn-primary w-full"
                            type="submit"
                            icon="o-paper-airplane"
                        />
                    </div>
                </form>

                <!-- Divider -->
                <div class="divider text-sm text-base-content/60">Remember your password?</div>

                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="btn btn-ghost w-full">
                    <x-icon name="o-arrow-left" class="w-4 h-4" />
                    Back to Login
                </a>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-base-content/60">
                    <a href="#" class="link link-hover">Need Help?</a>
                    <span class="mx-2">•</span>
                    <a href="#" class="link link-hover">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.centered>
