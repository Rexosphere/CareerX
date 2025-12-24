<x-layouts.main title="Edit Job Listing">
    <div class="bg-base-200 min-h-screen">
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
                <div class="flex flex-col gap-4">
                    <a href="{{ route('company.profile') }}"
                        class="inline-flex items-center text-sm font-bold text-primary hover:translate-x-[-4px] transition-transform">
                        <x-icon name="o-arrow-left" class="w-4 h-4 mr-2" />
                        Return to Profile
                    </a>
                    <div class="max-w-5xl">
                        <h1 class="text-3xl md:text-4xl font-bold mb-3">
                            Edit Job Listing
                        </h1>
                        <p class="text-base-content/70 text-base md:text-lg">
                            Keep your job posting up to date to attract the best talent.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto max-w-4xl px-4 py-12 pb-20">
            @livewire('jobs.edit-form', ['job' => $job])
        </div>
    </div>
</x-layouts.main>