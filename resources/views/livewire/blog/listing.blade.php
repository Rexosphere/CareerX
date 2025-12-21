<?php
use Livewire\Volt\Component;

new class extends Component {
    public string $search = '';
    public string $selectedCategory = 'All';

    public function with(): array
    {
        $posts = [
            [
                'id' => 1,
                'title' => '5 Tips for Acing Your First Technical Interview',
                'excerpt' => 'Technical interviews can be daunting. From data structures to soft skills, here is your comprehensive guide to making a lasting impression.',
                'author' => 'Sarah Jenkins',
                'date' => 'Oct 24, 2023',
                'category' => 'Interview Prep',
                'image' => 'https://picsum.photos/seed/blog1/800/450',
                'slug' => '5-tips-technical-interview'
            ],
            [
                'id' => 2,
                'title' => 'Navigating the Corporate World as a Fresher',
                'excerpt' => 'Stepping out of university and into a corporate job is a massive shift. Learn how to adapt to office culture, manage expectations, and find a mentor.',
                'author' => 'David Chen',
                'date' => 'Nov 02, 2023',
                'category' => 'Career Advice',
                'image' => 'https://picsum.photos/seed/blog2/800/450',
                'slug' => 'navigating-corporate-world'
            ],
            [
                'id' => 3,
                'title' => 'Top 10 Tech Skills in Demand for 2024',
                'excerpt' => 'Stay ahead of the curve by mastering these essential technologies. From AI ethics to cloud computing, here is what employers are looking for.',
                'author' => 'Priya Patel',
                'date' => 'Nov 10, 2023',
                'category' => 'Tech Trends',
                'image' => 'https://picsum.photos/seed/blog3/800/450',
                'slug' => 'tech-skills-2024'
            ],
            [
                'id' => 4,
                'title' => 'Alumni Spotlight: From UoM to Google',
                'excerpt' => 'Read the inspiring journey of Malith, a UoM graduate who navigated the competitive landscape to land a Senior Engineering role at Google.',
                'author' => 'Admin',
                'date' => 'Nov 15, 2023',
                'category' => 'Alumni Stories',
                'image' => 'https://picsum.photos/seed/blog4/800/450',
                'slug' => 'alumni-google'
            ],
            [
                'id' => 5,
                'title' => 'Resume Writing Workshop Recap',
                'excerpt' => 'Missed the workshop last week? We\'ve compiled the top takeaways on how to structure your CV to pass ATS scanners and impress recruiters.',
                'author' => 'Career Center',
                'date' => 'Nov 18, 2023',
                'category' => 'Workshop',
                'image' => 'https://picsum.photos/seed/blog5/800/450',
                'slug' => 'resume-workshop-recap'
            ],
            [
                'id' => 6,
                'title' => 'Balancing Academics and Internships',
                'excerpt' => 'Finding the right balance between maintaining a high GPA and gaining industry experience is tough. Here are strategies to manage your time effectively.',
                'author' => 'Kasun Perera',
                'date' => 'Nov 20, 2023',
                'category' => 'Student Life',
                'image' => 'https://picsum.photos/seed/blog6/800/450',
                'slug' => 'balancing-academics-internships'
            ],
        ];

        $categories = ['All', 'Internships', 'Career Advice', 'Tech Trends', 'Alumni Stories'];

        return [
            'posts' => $posts,
            'categories' => $categories,
        ];
    }
}; ?>

<div class="w-full max-w-7xl mx-auto px-6 lg:px-8 py-8 flex flex-col gap-6">
    {{-- Search and Filter Section --}}
    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between w-full">
        {{-- Search --}}
        <label class="input input-bordered flex items-center gap-2 w-full md:w-96 shadow-sm">
            <x-icon name="o-magnifying-glass" class="text-base-content/60 w-5 h-5" />
            <input wire:model.live="search" type="text" class="grow" placeholder="Search articles..." />
        </label>

        {{-- Filter Chips --}}
        <div class="flex gap-2 flex-wrap items-center">
            @foreach($categories as $category)
                <button
                    wire:click="$set('selectedCategory', '{{ $category }}')"
                    class="btn btn-sm {{ $selectedCategory === $category ? 'btn-primary' : 'btn-outline' }}"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Blog Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
        @foreach($posts as $post)
            <article class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                {{-- Image --}}
                <figure class="relative h-48 overflow-hidden">
                    <div class="absolute inset-0 bg-base-300 animate-pulse"></div>
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 relative z-10" loading="lazy" />
                </figure>

                {{-- Card Body --}}
                <div class="card-body p-5 flex flex-col h-full">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="badge badge-primary badge-outline badge-sm font-bold uppercase">{{ $post['category'] }}</span>
                    </div>

                    <h3 class="card-title text-lg leading-tight hover:text-primary transition-colors line-clamp-2">
                        {{ $post['title'] }}
                    </h3>

                    <p class="text-sm text-base-content/70 leading-relaxed line-clamp-3 flex-grow">
                        {{ $post['excerpt'] }}
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between border-t border-base-300">
                        <div class="flex items-center gap-2 text-xs text-base-content/70">
                            <span class="font-medium text-base-content">{{ $post['author'] }}</span>
                            <span>•</span>
                            <span>{{ $post['date'] }}</span>
                        </div>
                        <a href="{{ route('blog.show', $post['slug']) }}" wire:navigate class="text-primary text-sm font-semibold flex items-center gap-1 hover:gap-2 transition-all">
                            Read More
                            <x-icon name="o-arrow-right" class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-center py-8">
        <div class="join">
            <button class="join-item btn btn-sm">
                <x-icon name="o-chevron-left" class="w-6 h-6" />
            </button>
            <button class="join-item btn btn-sm btn-active btn-primary">1</button>
            <button class="join-item btn btn-sm">2</button>
            <button class="join-item btn btn-sm">3</button>
            <button class="join-item btn btn-sm btn-disabled">...</button>
            <button class="join-item btn btn-sm">
                <x-icon name="o-chevron-right" class="w-6 h-6" />
            </button>
        </div>
    </div>
</div>
