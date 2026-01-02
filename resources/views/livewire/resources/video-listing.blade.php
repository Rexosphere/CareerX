<?php
use Livewire\Volt\Component;
use App\Models\Course;

new class extends Component {
    public string $search = '';
    public string $selectedCategory = 'All';

    public function with(): array
    {
        $query = Course::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCategory !== 'All') {
            $query->where('category', $this->selectedCategory);
        }

        $videos = $query->latest()->get()->map(function ($video) {
            return [
                'id' => $video->id,
                'title' => $video->title,
                'category' => $video->category,
                'categoryColor' => $this->getCategoryColor($video->category),
                'youtube_id' => $this->extractYoutubeId($video->content),
                'date' => $video->created_at->format('M d, Y'),
            ];
        });

        $categories = [
            'All',
            'Cv creating sessions',
            'Interview facing sessions',
            'Industrial careers sessions',
            'Academia careers sessions'
        ];

        return [
            'videos' => $videos,
            'categories' => $categories,
        ];
    }

    private function getCategoryColor($category)
    {
        return match ($category) {
            'Cv creating sessions' => 'primary',
            'Interview facing sessions' => 'success',
            'Industrial careers sessions' => 'warning',
            'Academia careers sessions' => 'info',
            default => 'neutral'
        };
    }

    private function extractYoutubeId($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1] ?? null;
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
                        <input wire:model.live="search" type="text" class="grow" placeholder="Search for sessions..." />
                    </label>
                </div>

                {{-- Category Filters --}}
                <div class="flex flex-1 w-full overflow-x-auto gap-3 items-center pb-1 lg:pb-0">
                    @foreach($categories as $category)
                        <button wire:click="$set('selectedCategory', '{{ $category }}')"
                            class="btn btn-sm whitespace-nowrap {{ $selectedCategory === $category ? 'btn-neutral' : 'btn-ghost' }}">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Video Grid --}}
    @if($videos->isEmpty())
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-icon name="o-video-camera" class="w-8 h-8 text-base-content/30" />
            </div>
            <h3 class="font-bold text-lg mb-1">No Sessions Found</h3>
            <p class="text-base-content/60">Try adjusting your search or category filter.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                    {{-- Video Embed --}}
                    <figure class="relative aspect-video bg-black rounded-t-xl overflow-hidden">
                        @if($video['youtube_id'])
                            <iframe class="w-full h-full absolute inset-0"
                                src="https://www.youtube.com/embed/{{ $video['youtube_id'] }}" title="{{ $video['title'] }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-white/50">
                                <span class="text-sm">Video Unavailable</span>
                            </div>
                        @endif
                    </figure>

                    {{-- Card Body --}}
                    <div class="card-body p-5">
                        <div class="mb-2">
                            {{-- Category Badge --}}
                            <div class="badge badge-{{ $video['categoryColor'] }} text-white badge-sm mb-2 font-bold uppercase shadow-sm">
                                {{ $video['category'] }}
                            </div>

                            {{-- Title --}}
                            <h3 class="card-title text-lg leading-tight mb-1">{{ $video['title'] }}</h3>
                            <p class="text-sm text-base-content/70">{{ $video['date'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>