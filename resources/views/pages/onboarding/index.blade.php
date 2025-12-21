<x-layouts.centered title="Student Profile Setup">
    <!-- Top Navigation Bar -->
    <div class="fixed top-0 left-0 right-0 z-50 navbar bg-base-100 border-b border-base-300 shadow-sm">
        <div class="flex-1">
            <div class="flex items-center gap-2 text-primary px-4">
                <x-icon name="o-academic-cap" class="w-12 h-12" />
                <span class="text-lg font-bold">UoM Recruitment</span>
            </div>
        </div>
        <div class="flex-none gap-2 px-4">
            <button class="btn btn-ghost btn-sm gap-2">
                <x-icon name="o-question-mark-circle" class="w-6 h-6" />
                <span class="hidden sm:inline">Help</span>
            </button>
            @auth
                <div class="avatar placeholder">
                    <div class="bg-base-300 text-neutral-content rounded-full w-10">
                        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Content (with top padding for fixed navbar) -->
    <div class="pt-20 pb-10 w-full max-w-3xl mx-auto">
        <livewire:onboarding.multi-step-form />
    </div>

    <!-- Decorative Footer Element -->
    <div class="fixed bottom-0 left-0 w-full h-1 bg-primary z-50"></div>
</x-layouts.centered>
