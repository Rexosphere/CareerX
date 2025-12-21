<?php
use Livewire\Volt\Component;

new class extends Component {
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function with(): array
    {
        // Mock blog post data
        $post = [
            'title' => 'Navigating the UoM Internship Landscape: A Guide for 3rd Years',
            'author' => [
                'name' => 'Amara Perera',
                'title' => 'CS Batch \'20',
                'avatar' => 'https://ui-avatars.com/api/?name=Amara+Perera&background=0d9ef2&color=fff&size=128',
                'online' => true,
            ],
            'date' => 'Oct 12, 2023',
            'readTime' => '5 min read',
            'categories' => ['Internships', 'Career Guidance', 'Academic'],
            'featuredImage' => 'https://picsum.photos/seed/blogpost/1200/600',
            'content' => '<p class="text-xl text-base-content/70 font-medium mb-8">Securing an internship is a pivotal moment in any UoM undergraduate\'s journey. It bridges the gap between theoretical knowledge gained in lecture halls and the practical demands of the industry.</p>

            <h2 class="text-2xl font-bold mt-8 mb-4">Understanding the Timeline</h2>
            <p class="mb-4">For most faculties at UoM, the internship period officially begins after the 4th or 6th semester. However, the preparation should start much earlier. Companies often start their recruitment drives as early as January for mid-year intakes.</p>
            <p class="mb-4">It\'s crucial to have your CV polished and your GitHub repositories (for CS/IT students) or portfolios updated by the end of your 2nd year. Don\'t wait until the last minute.</p>

            <div class="alert alert-info my-6">
                <x-icon name="o-information-circle" class="w-6 h-6" />
                <div>
                    <h4 class="font-bold">Pro Tip for CS Students</h4>
                    <p class="text-sm">Don\'t just list your projects. Explain the <strong>problem</strong> you solved, the <strong>tech stack</strong> you used, and the <strong>outcome</strong>. Recruiters love context.</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold mt-8 mb-4">Networking is Key</h2>
            <p class="mb-4">The University of Moratuwa has a massive alumni network spread across top-tier tech companies globally. Platforms like LinkedIn are your best friend here. Don\'t hesitate to reach out to seniors for guidance or mock interviews.</p>

            <ul class="list-disc list-inside mb-4 space-y-2">
                <li>Attend career fairs organized by the Rotaract Club or Faculty Unions.</li>
                <li>Participate in hackathons – they are often scouting grounds for recruiters.</li>
                <li>Join mentorship programs offered by the university.</li>
            </ul>

            <h3 class="text-xl font-bold mt-6 mb-3">Preparing for the Interview</h3>
            <p class="mb-4">Technical skills are non-negotiable, but soft skills are the differentiator. Can you communicate your ideas clearly? Can you work in a team? During the interview:</p>

            <ol class="list-decimal list-inside mb-4 space-y-2">
                <li>Be honest about what you don\'t know.</li>
                <li>Show enthusiasm for learning.</li>
                <li>Ask questions about the company culture.</li>
            </ol>

            <blockquote class="border-l-4 border-primary pl-4 italic my-6 text-base-content/70">
                "The best interns aren\'t always the ones who know everything. They are the ones who are most willing to learn and adapt."
                <br><span class="text-sm font-semibold not-italic text-base-content mt-2 block">— Tech Lead @ WSO2</span>
            </blockquote>

            <h2 class="text-2xl font-bold mt-8 mb-4">Conclusion</h2>
            <p class="mb-4">The internship landscape might seem daunting, but remember that every senior you see thriving in the industry once stood exactly where you are. Preparation, persistence, and a positive attitude will take you far. Good luck!</p>',
            'tags' => ['#Internship', '#UoM', '#CareerAdvice', '#SoftwareEngineering'],
            'likes' => 245,
            'comments' => 18,
        ];

        $relatedPosts = [
            [
                'id' => 1,
                'title' => 'Top 10 Technical Interview Questions for 2024',
                'excerpt' => 'Get ready for your next interview with this curated list of common questions asked by tech giants.',
                'category' => 'Interview Prep',
                'image' => 'https://picsum.photos/seed/related1/400/200',
                'slug' => 'tech-interview-questions-2024'
            ],
            [
                'id' => 2,
                'title' => 'Balancing Academics and Extra-Curriculars',
                'excerpt' => 'How to maintain a healthy GPA while leading a student club. Tips from a 4th year student.',
                'category' => 'Campus Life',
                'image' => 'https://picsum.photos/seed/related2/400/200',
                'slug' => 'balancing-academics'
            ],
            [
                'id' => 3,
                'title' => 'CV Mistakes to Avoid as a Fresh Grad',
                'excerpt' => 'Don\'t let these common errors send your resume to the rejection pile. Check your CV now.',
                'category' => 'CV Writing',
                'image' => 'https://picsum.photos/seed/related3/400/200',
                'slug' => 'cv-mistakes-avoid'
            ],
        ];

        return [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ];
    }
}; ?>

<div class="flex flex-col lg:flex-row gap-8">
    {{-- Article Container --}}
    <article class="flex-1 min-w-0">
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            {{-- Article Header --}}
            <div class="card-body p-6 sm:p-10">
                {{-- Categories --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post['categories'] as $index => $category)
                        <span class="badge {{ $index === 0 ? 'badge-primary' : 'badge-outline' }} badge-sm font-bold uppercase">
                            {{ $category }}
                        </span>
                    @endforeach
                </div>

                {{-- Title --}}
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6">
                    {{ $post['title'] }}
                </h1>

                {{-- Author Meta --}}
                <div class="flex items-center justify-between border-b border-base-300 pb-6 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="avatar {{ $post['author']['online'] ? 'online' : '' }} placeholder">
                            <div class="w-12 rounded-full ring ring-base-300 ring-offset-base-100 ring-offset-2">
                                <img src="{{ $post['author']['avatar'] }}" alt="{{ $post['author']['name'] }}" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-sm">{{ $post['author']['name'] }}</span>
                            <span class="text-base-content/70 text-xs">{{ $post['author']['title'] }} • {{ $post['date'] }} • {{ $post['readTime'] }}</span>
                        </div>
                    </div>

                    {{-- Share Buttons (Mobile/Tablet) --}}
                    <div class="flex gap-2 lg:hidden">
                        <button class="btn btn-ghost btn-circle btn-sm">
                            <x-icon name="o-share" class="w-6 h-6" />
                        </button>
                        <button class="btn btn-ghost btn-circle btn-sm">
                            <x-icon name="o-bookmark" class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <figure class="w-full aspect-video sm:aspect-[21/9] overflow-hidden">
                <img src="{{ $post['featuredImage'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" />
            </figure>

            {{-- Article Body --}}
            <div class="card-body p-6 sm:p-10">
                <div class="prose prose-lg max-w-none">
                    {!! $post['content'] !!}
                </div>

                {{-- Post-article Engagement --}}
                <div class="mt-12 pt-8 border-t border-base-300">
                    <h3 class="text-lg font-bold mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($post['tags'] as $tag)
                            <a href="#" class="badge badge-outline hover:badge-primary transition-colors">{{ $tag }}</a>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex gap-4">
                            <button class="btn btn-ghost btn-sm gap-2">
                                <x-icon name="o-hand-thumb-up" class="w-5 h-5" />
                                <span class="font-medium">{{ $post['likes'] }} Likes</span>
                            </button>
                            <button class="btn btn-ghost btn-sm gap-2">
                                <x-icon name="o-chat-bubble-left" class="w-5 h-5" />
                                <span class="font-medium">{{ $post['comments'] }} Comments</span>
                            </button>
                        </div>
                        <button class="link link-primary text-sm font-medium">Report Issue</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Posts --}}
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-6">Related Articles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                        <figure class="h-40">
                            <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" class="w-full h-full object-cover" />
                        </figure>
                        <div class="card-body p-5">
                            <span class="badge badge-primary badge-sm font-semibold uppercase">{{ $related['category'] }}</span>
                            <h4 class="card-title text-lg leading-tight hover:text-primary transition-colors">{{ $related['title'] }}</h4>
                            <p class="text-base-content/70 text-sm line-clamp-2">{{ $related['excerpt'] }}</p>
                            <a href="{{ route('blog.show', $related['slug']) }}" wire:navigate class="btn btn-ghost btn-sm justify-start gap-1 px-0 mt-2 text-primary">
                                Read Article
                                <x-icon name="o-arrow-right" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </article>

    {{-- Sidebar (Desktop only) --}}
    <aside class="hidden lg:block w-20 shrink-0">
        <div class="sticky top-24 flex flex-col gap-4 items-center">
            <p class="text-xs font-bold text-base-content/40 uppercase tracking-widest rotate-180" style="writing-mode: vertical-rl;">Share</p>
            <div class="divider divider-vertical h-8"></div>

            <div class="tooltip tooltip-left" data-tip="Share on LinkedIn">
                <button class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </button>
            </div>

            <div class="tooltip tooltip-left" data-tip="Share on Facebook">
                <button class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </button>
            </div>

            <div class="tooltip tooltip-left" data-tip="Share on Twitter">
                <button class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </button>
            </div>
        </div>
    </aside>
</div>
