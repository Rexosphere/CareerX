<x-layouts.centered title="Verify Email">
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                        <x-icon name="o-envelope" class="w-6 h-6" />
                    </div>
                    <h2 class="card-title text-3xl font-bold justify-center">
                        Verify Your Email
                    </h2>
                    <p class="text-base-content/70 mt-2">
                        We've sent a verification link to your email address. Please check your inbox.
                    </p>
                </div>

                <!-- Status Message -->
                @if (session('status') == 'verification-link-sent')
                    <x-alert icon="o-check-circle" class="alert-success mb-4">
                        A new verification link has been sent to your email address.
                    </x-alert>
                @endif

                <!-- Instructions -->
                <div class="alert alert-info mb-4">
                    <x-icon name="o-information-circle" class="w-5 h-5" />
                    <div>
                        <p class="font-medium">Check your email</p>
                        <p class="text-xs">Click the verification link sent to {{ auth()->user()->email }}</p>
                    </div>
                </div>

                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-button
                        label="Resend Verification Email"
                        class="btn-primary w-full"
                        type="submit"
                        icon="o-paper-airplane"
                    />
                </form>

                <!-- Divider -->
                <div class="divider text-sm text-base-content/60">or</div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button
                        label="Logout"
                        class="btn-ghost w-full"
                        type="submit"
                        icon="o-arrow-right-on-rectangle"
                    />
                </form>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-base-content/60">
                    <p>Didn't receive the email? Check your spam folder.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.centered>
