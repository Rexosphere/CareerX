<x-layouts.public title="Job Board">
    <div class="bg-base-100 border-b border-base-300">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="max-w-2xl">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">
                        Available Opportunities
                    </h1>
                    <p class="text-base-content/70 text-base md:text-lg">
                        Discover your next career step from top industry partners.
                    </p>
                </div>
                @auth('web')
                    @if(auth('web')->user()->isStudent())
                        <div class="flex-shrink-0">
                            <a href="{{ route('my-applications') }}" class="btn btn-primary gap-2">
                                <x-icon name="o-briefcase" class="w-5 h-5" />
                                My Applications
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-sm mb-6">
            <ul>
                <li><a href="{{ route('home') }}" class="text-base-content/60 hover:text-primary">Home</a></li>
                <li class="font-medium">Jobs</li>
            </ul>
        </div>

        <!-- Job Listing Component -->
        <livewire:jobs.listing />
    </div>
</x-layouts.public>