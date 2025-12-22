<x-layouts.centered title="Two-Factor Authentication">
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary mx-auto mb-4">
                        <x-icon name="o-shield-check" class="w-6 h-6" />
                    </div>
                    <h2 class="card-title text-3xl font-bold justify-center">
                        Two-Factor Authentication
                    </h2>
                    <p class="text-base-content/70 mt-2" x-data="{ recovery: false }" x-text="recovery ? 'Enter one of your recovery codes' : 'Enter the code from your authenticator app'">
                        Enter the code from your authenticator app
                    </p>
                </div>

                <div x-data="{ recovery: false }">
                    <!-- Authentication Code Form -->
                    <form method="POST" action="{{ route('two-factor.login') }}" x-show="! recovery">
                        @csrf

                        <x-input
                            label="Authentication Code"
                            name="code"
                            type="text"
                            inputmode="numeric"
                            placeholder="000000"
                            icon="o-key"
                            autofocus
                            autocomplete="one-time-code"
                        />

                        <div class="mt-6 space-y-3">
                            <x-button
                                label="Verify"
                                class="btn-primary w-full"
                                type="submit"
                            />

                            <button
                                type="button"
                                class="btn btn-ghost btn-sm w-full"
                                x-on:click="recovery = true"
                            >
                                Use a recovery code
                            </button>
                        </div>
                    </form>

                    <!-- Recovery Code Form -->
                    <form method="POST" action="{{ route('two-factor.login') }}" x-show="recovery" style="display: none;">
                        @csrf

                        <x-input
                            label="Recovery Code"
                            name="recovery_code"
                            type="text"
                            placeholder="abcd-efgh-ijkl"
                            icon="o-lifebuoy"
                            autocomplete="one-time-code"
                        />

                        <div class="mt-6 space-y-3">
                            <x-button
                                label="Verify"
                                class="btn-primary w-full"
                                type="submit"
                            />

                            <button
                                type="button"
                                class="btn btn-ghost btn-sm w-full"
                                x-on:click="recovery = false"
                            >
                                Use an authentication code
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-base-content/60">
                    <a href="{{ route('login') }}" class="link link-hover">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.centered>
