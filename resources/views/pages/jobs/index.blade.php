<x-layouts.public title="Job Board">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-sm mb-6">
            <ul>
                <li><a href="{{ route('home') }}" class="text-base-content/60 hover:text-primary">Home</a></li>
                <li class="font-medium">Jobs</li>
            </ul>
        </div>

        <!-- Page Heading -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Available Opportunities</h1>
            <p class="text-base-content/70">Discover your next career step from top industry partners.</p>
        </div>

        <!-- Job Listing Component -->
        <livewire:jobs.listing />
    </div>
</x-layouts.public>
