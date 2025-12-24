<x-layouts.main title="{{ $user->name }} - Profile">
    <div x-data="{ activeTab: 'profile' }" class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div class="flex items-center gap-6">
                <div class="avatar shadow-2xl rounded-2xl ring ring-primary/20 ring-offset-4 ring-offset-base-100">
                    <div class="w-24 h-24 rounded-2xl bg-base-300 flex items-center justify-center overflow-hidden">
                        @if($user->logo_path)
                            <img src="{{ asset('storage/' . $user->logo_path) }}" />
                        @else
                            <span class="text-3xl font-black text-base-content/20">{{ $user->initials() }}</span>
                        @endif
                    </div>
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight text-base-content">{{ $user->name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <span class="badge badge-primary font-bold px-4">Verified Employer</span>
                        <div class="flex items-center gap-1 text-sm text-base-content/60">
                            <x-icon name="o-envelope" class="w-4 h-4" />
                            {{ $user->email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('jobs.create') }}" class="btn btn-primary shadow-lg shadow-primary/20 gap-2">
                    <x-icon name="o-plus-circle" class="w-5 h-5" />
                    Post New Job
                </a>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="tabs tabs-lifted tabs-lg mb-8">
            <button @click="activeTab = 'profile'"
                :class="activeTab === 'profile' ? 'tab-active font-bold text-primary' : ''"
                class="tab h-14 px-8 border-b-2">
                <x-icon name="o-user-circle" class="w-5 h-5 mr-2" />
                Company Profile
            </button>
            <button @click="activeTab = 'jobs'" :class="activeTab === 'jobs' ? 'tab-active font-bold text-primary' : ''"
                class="tab h-14 px-8 border-b-2">
                <x-icon name="o-briefcase" class="w-5 h-5 mr-2" />
                Job Listings
                <div class="badge badge-sm ml-2"
                    :class="activeTab === 'jobs' ? 'badge-primary text-white' : 'badge-ghost'">{{ $jobs->count() }}
                </div>
            </button>
        </div>

        {{-- Profile Tab Content --}}
        <div x-show="activeTab === 'profile'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            @livewire('company.profile-manager')
        </div>

        {{-- Jobs Tab Content --}}
        <div x-show="activeTab === 'jobs'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            @livewire('company.job-listing-manager')
        </div>
    </div>
</x-layouts.main>