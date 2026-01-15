<x-layouts.centered title="Reset Password">
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                        <x-icon name="o-key" class="w-6 h-6" />
                    </div>
                    <h2 class="card-title text-3xl font-bold justify-center">
                        Reset Password
                    </h2>
                    <p class="text-base-content/70 mt-2">
                        Enter your new password below.
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <!-- Email -->
                    <x-input
                        label="Email Address"
                        name="email"
                        type="email"
                        icon="o-envelope"
                        placeholder="your.email@example.com"
                        value="{{ old('email', request()->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    @error('email')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <x-input
                        label="New Password"
                        name="password"
                        type="password"
                        icon="o-lock-closed"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    />

                    @error('password')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Password Confirmation -->
                    <x-input
                        label="Confirm Password"
                        name="password_confirmation"
                        type="password"
                        icon="o-lock-closed"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    />

                    <!-- Password Requirements -->
                    <div class="alert alert-info mt-4">
                        <x-icon name="o-information-circle" class="w-5 h-5" />
                        <div class="text-xs">
                            <p class="font-medium mb-1">Password must contain:</p>
                            <ul class="list-disc list-inside">
                                <li>At least 8 characters</li>
                                <li>Mix of letters and numbers</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button
                            label="Reset Password"
                            class="btn-primary w-full"
                            type="submit"
                            icon="o-check"
                        />
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-base-content/60">
                    <a href="{{ route('login') }}" class="link link-hover">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.centered>
