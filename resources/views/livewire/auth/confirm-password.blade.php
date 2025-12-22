<x-layouts.centered title="Confirm Password">
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-warning/10 rounded-full flex items-center justify-center text-warning mx-auto mb-4">
                        <x-icon name="o-lock-closed" class="w-6 h-6" />
                    </div>
                    <h2 class="card-title text-3xl font-bold justify-center">
                        Confirm Password
                    </h2>
                    <p class="text-base-content/70 mt-2">
                        This is a secure area. Please confirm your password before continuing.
                    </p>
                </div>

                <!-- Alert -->
                <div class="alert alert-warning mb-4">
                    <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
                    <div>
                        <p class="text-sm">For your security, please re-enter your password.</p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <x-input
                        label="Password"
                        name="password"
                        type="password"
                        icon="o-lock-closed"
                        placeholder="••••••••"
                        autofocus
                        autocomplete="current-password"
                        required
                    />

                    @error('password')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button
                            label="Confirm"
                            class="btn-primary w-full"
                            type="submit"
                        />
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-base-content/60">
                    <a href="{{ route('dashboard') }}" class="link link-hover">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.centered>
