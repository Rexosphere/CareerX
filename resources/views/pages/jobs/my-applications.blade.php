<x-layouts.public title="My Applications">
    <div class="bg-base-100 border-b border-base-300">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="max-w-2xl">
                        <h1 class="text-3xl md:text-4xl font-bold mb-3">
                            My Applications
                        </h1>
                        <p class="text-base-content/70 text-base md:text-lg">
                            Track all your job applications in one place.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline gap-2">
                            <x-icon name="o-arrow-left" class="w-5 h-5" />
                            Back to Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-sm mb-6">
            <ul>
                <li><a href="{{ route('home') }}" class="text-base-content/60 hover:text-primary">Home</a></li>
                <li><a href="{{ route('jobs.index') }}" class="text-base-content/60 hover:text-primary">Jobs</a></li>
                <li class="font-medium">My Applications</li>
            </ul>
        </div>

        <!-- My Applications Component -->
        <livewire:jobs.my-applications />
    </div>
</x-layouts.public>
