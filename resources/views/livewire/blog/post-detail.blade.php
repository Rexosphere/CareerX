<?php
use Livewire\Volt\Component;
use App\Models\Blog;
use Illuminate\Support\Str;

new class extends Component {
    public string $slug;
    public ?Blog $post = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        
        // Find the blog post by slug
        $this->post = Blog::with('author')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Increment view count
        $this->post->incrementViews();
    }

    public function with(): array
    {
        // Parse markdown content to HTML
        $parsedContent = Str::markdown($this->post->content);
        
        // Get related posts from the same category
        $relatedPosts = Blog::published()
            ->with('author')
            ->where('category', $this->post->category)
            ->where('id', '!=', $this->post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return [
            'post' => $this->post,
            'parsedContent' => $parsedContent,
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
                {{-- Category --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="badge badge-primary badge-sm font-bold uppercase">
                        {{ $post->category }}
                    </span>
                    @if($post->tags && count($post->tags) > 0)
                        @foreach($post->tags as $tag)
                            <span class="badge badge-outline badge-sm font-bold uppercase">{{ $tag }}</span>
                        @endforeach
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6">
                    {{ $post->title }}
                </h1>

                {{-- Author Meta --}}
                <div class="flex items-center justify-between border-b border-base-300 pb-6 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="w-12 rounded-full ring ring-base-300 ring-offset-base-100 ring-offset-2 bg-primary text-primary-content">
                                <span class="text-lg font-bold">{{ $post->author ? substr($post->author->name, 0, 1) : 'A' }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-sm">{{ $post->author->name ?? 'Anonymous' }}</span>
                            <span class="text-base-content/70 text-xs">
                                {{ $post->published_at->format('M d, Y') }} • {{ $post->reading_time }} min read • {{ number_format($post->views) }} views
                            </span>
                        </div>
                    </div>

                    {{-- Share Buttons (Mobile/Tablet) --}}
                    <div class="flex gap-2 lg:hidden">
                        <button
                            onclick="navigator.share ? navigator.share({title: '{{ $post->title }}', url: window.location.href}) : navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'))"
                            class="btn btn-ghost btn-circle btn-sm" title="Share">
                            <x-icon name="o-share" class="w-6 h-6" />
                        </button>
                        <button x-data="{ saved: false }" @click="saved = !saved" :class="saved ? 'text-primary' : ''"
                            class="btn btn-ghost btn-circle btn-sm" title="Bookmark">
                            <x-icon x-show="!saved" name="o-bookmark" class="w-6 h-6" />
                            <x-icon x-show="saved" x-cloak name="s-bookmark" class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            @if($post->featured_image)
                <figure class="w-full aspect-video sm:aspect-[21/9] overflow-hidden">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" />
                </figure>
            @endif

            {{-- Article Body --}}
            <div class="card-body p-6 sm:p-10">
                <div id="mainarticle" class="prose prose-lg max-w-none">
                    {!! $parsedContent !!}
                </div>

                {{-- Post-article Engagement --}}
                <div class="mt-12 pt-8 border-t border-base-300">
                    @if($post->tags && count($post->tags) > 0)
                        <h3 class="text-lg font-bold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2 mb-8">
                            @foreach($post->tags as $tag)
                                <span class="badge badge-outline">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center justify-end">
                        <button
                            onclick="window.open('mailto:support@careerx.lk?subject=Report Issue: {{ urlencode($post->title) }}&body=I would like to report an issue with this blog post: ' + window.location.href, '_blank')"
                            class="link link-primary text-sm font-medium">Report Issue</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Posts --}}
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-6">Related Articles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($relatedPosts as $related)
                    <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                        <figure class="h-40">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                    <x-icon name="o-document-text" class="w-10 h-10 text-base-content/20" />
                                </div>
                            @endif
                        </figure>
                        <div class="card-body p-5">
                            <span class="badge badge-primary badge-sm font-semibold uppercase">{{ $related->category }}</span>
                            <h4 class="card-title text-lg leading-tight hover:text-primary transition-colors">
                                {{ $related->title }}</h4>
                            <p class="text-base-content/70 text-sm line-clamp-2">{{ $related->excerpt ?? Str::limit(strip_tags($related->content), 100) }}</p>
                            <a href="{{ route('blog.show', $related->slug) }}" wire:navigate
                                class="btn btn-ghost btn-sm justify-start gap-1 px-0 mt-2 text-primary">
                                Read Article
                                <x-icon name="o-arrow-right" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-base-content/60">
                        <p>No related articles found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </article>

    {{-- Sidebar (Desktop only) --}}
    <aside class="hidden lg:block w-20 shrink-0">
        <div class="sticky top-24 flex flex-col gap-4 items-center">
            <p class="text-xs font-bold text-base-content/40 uppercase tracking-widest rotate-180"
                style="writing-mode: vertical-rl;">Share</p>
            <div class="divider divider-vertical h-8"></div>

            <div class="tooltip tooltip-left" data-tip="Share on LinkedIn">
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                    target="_blank" rel="noopener noreferrer" class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                    </svg>
                </a>
            </div>

            <div class="tooltip tooltip-left" data-tip="Share on Facebook">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                    rel="noopener noreferrer" class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
            </div>

            <div class="tooltip tooltip-left" data-tip="Share on Twitter">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                    target="_blank" rel="noopener noreferrer" class="btn btn-circle btn-outline btn-sm hover:btn-info">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                </a>
            </div>
        </div>
    </aside>
</div>