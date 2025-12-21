<?php
use Livewire\Volt\Component;

new class extends Component {
    public string $search = '';
    public string $selectedCategory = 'All';

    public function with(): array
    {
        $videos = [
            [
                'id' => 1,
                'title' => 'Mastering the Technical Interview',
                'speaker' => 'Dr. Amal Perera',
                'date' => 'Oct 24, 2023',
                'duration' => '12:40',
                'category' => 'Interview Prep',
                'categoryColor' => 'primary',
                'thumbnail' => 'https://picsum.photos/seed/video1/640/360',
                'resources' => [
                    ['icon' => 'document-text', 'title' => 'DS & Algo Cheat Sheet (PDF)'],
                    ['icon' => 'link', 'title' => 'Mock Interview Platform'],
                ]
            ],
            [
                'id' => 2,
                'title' => 'Writing a CV that Stands Out',
                'speaker' => 'Sarah Jenkins (HR Manager)',
                'date' => 'Nov 02, 2023',
                'duration' => '08:15',
                'category' => 'Resume Tips',
                'categoryColor' => 'success',
                'thumbnail' => 'https://picsum.photos/seed/video2/640/360',
                'resources' => [
                    ['icon' => 'arrow-down-tray', 'title' => 'Standard CV Template (DOCX)'],
                ]
            ],
            [
                'id' => 3,
                'title' => 'Networking for Introverts',
                'speaker' => 'Alumni Association',
                'date' => 'Sep 15, 2023',
                'duration' => '15:30',
                'category' => 'Networking',
                'categoryColor' => 'secondary',
                'thumbnail' => 'https://picsum.photos/seed/video3/640/360',
                'resources' => [
                    ['icon' => 'newspaper', 'title' => 'Conversation Starters Guide'],
                    ['icon' => 'calendar-days', 'title' => 'Upcoming Networking Events'],
                ]
            ],
            [
                'id' => 4,
                'title' => 'LinkedIn Profile Mastery',
                'speaker' => 'Kasun De Silva',
                'date' => 'Aug 20, 2023',
                'duration' => '09:45',
                'category' => 'Social Media',
                'categoryColor' => 'info',
                'thumbnail' => 'https://picsum.photos/seed/video4/640/360',
                'resources' => [
                    ['icon' => 'check-circle', 'title' => 'Profile Checklist'],
                ]
            ],
            [
                'id' => 5,
                'title' => 'Salary Negotiation for Grads',
                'speaker' => 'Finance Club',
                'date' => 'Jul 10, 2023',
                'duration' => '22:10',
                'category' => 'Soft Skills',
                'categoryColor' => 'warning',
                'thumbnail' => 'https://picsum.photos/seed/video5/640/360',
                'resources' => [
                    ['icon' => 'calculator', 'title' => 'Market Rate Calculator'],
                    ['icon' => 'chat-bubble-left-right', 'title' => 'Negotiation Scripts'],
                ]
            ],
            [
                'id' => 6,
                'title' => 'Making the Most of Your Internship',
                'speaker' => 'Student Panel',
                'date' => 'Jun 05, 2023',
                'duration' => '18:05',
                'category' => 'Internships',
                'categoryColor' => 'accent',
                'thumbnail' => 'https://picsum.photos/seed/video6/640/360',
                'resources' => [
                    ['icon' => 'clipboard-document-check', 'title' => 'Internship Goal Tracker'],
                ]
            ],
        ];

        $categories = ['All', 'Interview Prep', 'Resume Tips', 'Networking', 'Industry Insights', 'Soft Skills'];

        return [
            'videos' => $videos,
            'categories' => $categories,
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
    {{-- Search and Filter Bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-10">
        <div class="card-body p-4">
            <div class="flex flex-col lg:flex-row gap-4 items-center">
                {{-- Search Input --}}
                <div class="w-full lg:max-w-md">
                    <label class="input input-bordered flex items-center gap-2 h-12">
                        <x-icon name="o-magnifying-glass" class="w-5 h-5 text-base-content/60" />
                        <input wire:model.live="search" type="text" class="grow" placeholder="Search for advice, speakers..." />
                    </label>
                </div>

                {{-- Category Filters --}}
                <div class="flex flex-1 w-full overflow-x-auto gap-3 items-center pb-1 lg:pb-0">
                    @foreach($categories as $category)
                        <button
                            wire:click="$set('selectedCategory', '{{ $category }}')"
                            class="btn btn-sm whitespace-nowrap {{ $selectedCategory === $category ? 'btn-neutral' : 'btn-ghost' }}"
                        >
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Video Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($videos as $video)
            <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                {{-- Video Thumbnail --}}
                <figure class="relative aspect-video bg-base-300 group cursor-pointer overflow-hidden">
                    <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500" />

                    {{-- Play Button Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="btn btn-circle btn-primary btn-lg group-hover:scale-110 transition-transform">
                            <x-icon name="o-play" class="w-8 h-8" />
                        </div>
                    </div>

                    {{-- Duration Badge --}}
                    <div class="absolute bottom-3 right-3 badge badge-neutral badge-sm">{{ $video['duration'] }}</div>
                </figure>

                {{-- Card Body --}}
                <div class="card-body p-5">
                    <div class="mb-4">
                        {{-- Category Badge --}}
                        <div class="badge badge-{{ $video['categoryColor'] }} badge-outline badge-sm mb-2 font-bold uppercase">
                            {{ $video['category'] }}
                        </div>

                        {{-- Title and Speaker --}}
                        <h3 class="card-title text-lg leading-tight mb-1">{{ $video['title'] }}</h3>
                        <p class="text-sm text-base-content/70">{{ $video['speaker'] }} • {{ $video['date'] }}</p>
                    </div>

                    {{-- Related Resources --}}
                    <div class="mt-auto border-t border-base-300 pt-4">
                        <p class="text-xs font-bold uppercase tracking-wider mb-3">Related Resources</p>
                        <ul class="space-y-2">
                            @foreach($video['resources'] as $resource)
                                <li class="flex items-start gap-2 group/item cursor-pointer">
                                    <x-icon :name="'o-' . $resource['icon']" class="w-4 h-4 text-base-content/60 group-hover/item:text-primary transition-colors" />
                                    <span class="text-sm text-base-content/70 group-hover/item:text-primary transition-colors">{{ $resource['title'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Load More Button --}}
    <div class="flex justify-center mt-12 mb-8">
        <button class="btn btn-outline">
            Load More Videos
        </button>
    </div>
</div>
