<x-layouts.main title="Email Verified Successfully">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 bg-base-200/50">
        <div class="card bg-base-100 shadow-2xl border border-base-200 w-full max-w-md mx-auto">
            <div class="card-body p-6 sm:p-8">
                <!-- Success Icon -->
                <div class="text-center mb-5">
                    <div class="w-16 h-16 bg-success/10 rounded-2xl flex items-center justify-center text-success mx-auto mb-4">
                        <x-icon name="o-check-circle" class="w-10 h-10" />
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-base-content mb-1">
                        @if($alreadyVerified)
                            Already Verified!
                        @else
                            Email Verified!
                        @endif
                    </h2>
                    <p class="text-base-content/60 text-sm">
                        Your email address has been successfully verified
                    </p>
                </div>

                <!-- Email Badge -->
                <div class="alert alert-success mb-5">
                    <x-icon name="o-envelope" class="w-5 h-5" />
                    <div class="text-sm">
                        <p class="font-medium mb-1">Verified email:</p>
                        <p class="font-mono text-xs">{{ $email }}</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-4 mb-5">
                    <div class="alert alert-info">
                        <x-icon name="o-information-circle" class="w-5 h-5" />
                        <div class="text-sm">
                            <p class="font-medium mb-2">Next Steps:</p>
                            <ol class="list-decimal list-inside space-y-1.5 ml-2 text-xs">
                                <li>Return to your original browser or device</li>
                                <li>Refresh the verification page</li>
                                <li>You'll be automatically redirected to continue</li>
                            </ol>
                        </div>
                    </div>

                    <p class="text-xs text-base-content/60 text-center">
                        If you opened this link on the same device, you may already be logged in. 
                        Click the button below to continue.
                    </p>
                </div>

                <!-- Action Button -->
                <a href="{{ route('home') }}" class="btn btn-primary w-full btn-sm h-10 min-h-10 text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                    <x-icon name="o-home" class="w-4 h-4" />
                    Go to Home
                </a>

                <!-- Additional Help -->
                <div class="text-center mt-4 text-xs text-base-content/50">
                    <p>If you're having trouble, try logging in again on your original device.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
