<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $search = '';
    public string $category = '';
    public string $location = '';

    public function performSearch()
    {
        // Redirect to jobs listing page with search parameters
        return redirect()->route('jobs.index', [
            'search' => $this->search,
            'category' => $this->category,
            'location' => $this->location,
        ]);
    }
}; ?>

<div class="w-full max-w-5xl mx-auto px-4">
    <div class="bg-base-100 rounded-2xl shadow-xl border border-base-300 p-3 sm:p-4 backdrop-blur-sm">
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-2 items-stretch sm:items-center">
            <!-- Search Input -->
            <div class="flex-1 flex items-center gap-3 px-4 py-3 border-b sm:border-b-0 sm:border-r border-base-300 min-w-0">
                <x-icon name="o-magnifying-glass" class="w-5 h-5 text-base-content/60 flex-shrink-0" />
                <input
                    wire:model="search"
                    type="text"
                    placeholder="I'm looking for...    (Eg : Job title, Position, Company)"
                    class="w-full outline-none text-base-content placeholder:text-base-content/50 text-sm sm:text-base bg-transparent focus:placeholder:text-base-content/30 transition-colors"
                />
            </div>

            <!-- Job Category Dropdown -->
            <div class="relative flex-1 flex items-center gap-2 px-4 py-3 border-b sm:border-b-0 sm:border-r border-base-300 min-w-0">
                <select
                    wire:model="category"
                    class="w-full outline-none text-base-content text-sm sm:text-base bg-transparent cursor-pointer appearance-none pr-6 focus:text-primary transition-colors"
                >
                    <option value="" class="bg-base-100 text-base-content">Job Category</option>
                    <option value="software" class="bg-base-100 text-base-content">Software Engineering</option>
                    <option value="data" class="bg-base-100 text-base-content">Data Science</option>
                    <option value="design" class="bg-base-100 text-base-content">Design</option>
                    <option value="marketing" class="bg-base-100 text-base-content">Marketing</option>
                    <option value="sales" class="bg-base-100 text-base-content">Sales</option>
                    <option value="finance" class="bg-base-100 text-base-content">Finance</option>
                    <option value="engineering" class="bg-base-100 text-base-content">Engineering</option>
                    <option value="other" class="bg-base-100 text-base-content">Other</option>
                </select>
                <x-icon name="o-chevron-down" class="w-4 h-4 text-base-content/60 flex-shrink-0 pointer-events-none absolute right-4" />
            </div>

            <!-- Location Dropdown -->
            <div class="relative flex-1 flex items-center gap-2 px-4 py-3 min-w-0">
                <select
                    wire:model="location"
                    class="w-full outline-none text-base-content text-sm sm:text-base bg-transparent cursor-pointer appearance-none pr-6 focus:text-primary transition-colors"
                >
                    <option value="" class="bg-base-100 text-base-content">Location</option>
                    <option value="colombo" class="bg-base-100 text-base-content">Colombo</option>
                    <option value="kandy" class="bg-base-100 text-base-content">Kandy</option>
                    <option value="galle" class="bg-base-100 text-base-content">Galle</option>
                    <option value="jaffna" class="bg-base-100 text-base-content">Jaffna</option>
                    <option value="remote" class="bg-base-100 text-base-content">Remote</option>
                    <option value="hybrid" class="bg-base-100 text-base-content">Hybrid</option>
                    <option value="onsite" class="bg-base-100 text-base-content">On-site</option>
                </select>
                <x-icon name="o-chevron-down" class="w-4 h-4 text-base-content/60 flex-shrink-0 pointer-events-none absolute right-4" />
            </div>

            <!-- Search Button -->
            <button
                wire:click="performSearch"
                class="btn btn-primary px-6 sm:px-10 py-3 rounded-xl text-sm sm:text-base font-semibold uppercase tracking-wide hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2 min-h-[3rem] whitespace-nowrap"
            >
                <span class="hidden sm:inline">Search</span>
                <x-icon name="o-magnifying-glass" class="w-5 h-5" />
            </button>
        </div>
    </div>
</div>
