<x-layouts.main title="Job Applications">
    <div class="bg-base-200 min-h-screen">
        <div class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
                <div class="flex flex-col gap-4">
                    <a href="{{ route('company.dashboard') }}"
                        class="inline-flex items-center text-sm font-bold text-primary hover:translate-x-[-4px] transition-transform">
                        <x-icon name="o-arrow-left" class="w-4 h-4 mr-2" />
                        Return to Dashboard
                    </a>
                    <div class="max-w-5xl">
                        <h1 class="text-3xl md:text-4xl font-bold mb-3">
                            Applications for: {{ $job->title }}
                        </h1>
                        <p class="text-base-content/70 text-base md:text-lg">
                            Review and manage candidates who applied for this position.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto max-w-7xl px-4 md:px-6 py-12">
            @livewire('company.job-applications-listing', ['jobId' => $job->id])
        </div>
    </div>
</x-layouts.main>