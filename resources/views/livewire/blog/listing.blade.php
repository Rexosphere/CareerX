<?php
use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Blog;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $selectedCategory = 'All';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        // Build query for published blogs
        $query = Blog::published()->with('author');

        // Apply search filter
        if (!empty($this->search)) {
            $query->search($this->search);
        }

        // Apply category filter
        if ($this->selectedCategory !== 'All') {
            $query->category($this->selectedCategory);
        }

        // Get paginated posts
        $posts = $query->latest('published_at')->paginate(9);

        // Get unique categories from published blogs
        $categories = ['All'];
        $dbCategories = Blog::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();
        $categories = array_merge($categories, $dbCategories);

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
        @forelse($posts as $post)
            <article class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                {{-- Image --}}
                <figure class="relative h-48 overflow-hidden">
                    <div class="absolute inset-0 bg-base-300 animate-pulse"></div>
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 relative z-10" loading="lazy" />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center relative z-10">
                            <x-icon name="o-document-text" class="w-16 h-16 text-base-content/20" />
                        </div>
                    @endif
                </figure>

                {{-- Card Body --}}
                <div class="card-body p-5 flex flex-col h-full">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="badge badge-primary badge-outline badge-sm font-bold uppercase">{{ $post->category }}</span>
                    </div>

                    <h3 class="card-title text-lg leading-tight hover:text-primary transition-colors line-clamp-2">
                        {{ $post->title }}
                    </h3>

                    <p class="text-sm text-base-content/70 leading-relaxed line-clamp-3 flex-grow">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between border-t border-base-300">
                        <div class="flex items-center gap-2 text-xs text-base-content/70">
                            <span class="font-medium text-base-content">{{ $post->author->name ?? 'Anonymous' }}</span>
                            <span>•</span>
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('blog.show', $post->slug) }}" wire:navigate class="text-primary text-sm font-semibold flex items-center gap-1 hover:gap-2 transition-all">
                            Read More
                            <x-icon name="o-arrow-right" class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                    <x-icon name="o-document-text" class="w-10 h-10 text-primary opacity-50" />
                </div>
                <h3 class="font-bold text-xl mb-1">No Articles Found</h3>
                <p class="text-base-content/60 max-w-sm mx-auto">
                    @if(!empty($search))
                        No articles match your search. Try different keywords.
                    @else
                        There are no published articles at the moment. Check back soon!
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
        <div class="flex items-center justify-center py-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
