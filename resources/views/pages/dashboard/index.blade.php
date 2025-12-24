<x-layouts.app title="Employer Dashboard">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Employer Dashboard</h1>
            <p class="text-base-content/70 mt-1 text-base">Welcome back, {{ auth('company')->user()->name }}! Here's
                what's happening with your jobs today.</p>
        </div>
    </div>

    <!-- Dashboard Component -->
    <livewire:dashboard.stats />
</x-layouts.app>