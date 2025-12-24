<?php
use Livewire\Volt\Component;
use App\Models\Course;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public array $selectedCategories = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->selectedCategories = [];
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Course::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->selectedCategories)) {
            $query->whereIn('category', $this->selectedCategories);
        }

        $courses = $query->latest()->paginate(12);

        $categories = Course::select('category')->distinct()->pluck('category');

        return [
            'courses' => $courses,
            'categories' => $categories
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left Sidebar (Filters) --}}
        <aside class="w-full lg:w-1/4 min-w-[280px] flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-lg">Filters</h3>
                <button wire:click="clearFilters" class="text-sm text-primary font-medium hover:underline">Clear All</button>
            </div>

            {{-- Search Input --}}
            <div class="form-control">
                <label class="input input-bordered flex items-center gap-2 shadow-sm">
                    <x-icon name="o-magnifying-glass" class="text-base-content/60 w-5 h-5" />
                    <input wire:model.live.debounce.300ms="search" type="text" class="grow" placeholder="Search courses..." />
                </label>
            </div>

            {{-- Category Filter --}}
            <div class="collapse collapse-arrow bg-base-100 border border-base-300 shadow-sm">
                <input type="checkbox" checked />
                <div class="collapse-title font-bold text-sm">
                    Categories
                </div>
                <div class="collapse-content">
                    <div class="flex flex-col gap-2 pt-2 border-t border-dashed border-base-300">
                        @forelse($categories as $cat)
                            <label class="label cursor-pointer justify-start gap-3">
                                <input wire:model.live="selectedCategories" type="checkbox" value="{{ $cat }}" class="checkbox checkbox-primary checkbox-sm" />
                                <span class="label-text">{{ $cat }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-base-content/50 py-2">No categories available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </aside>

        {{-- Right Content (Grid) --}}
        <div class="flex-1 flex flex-col gap-8">
            {{-- Course Count --}}
            <div class="text-sm text-base-content/70">
                Showing <span class="font-bold text-base-content">{{ $courses->total() }}</span> available courses
            </div>

            {{-- Courses Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col h-full overflow-hidden">
                        {{-- Placeholder Image --}}
                        <figure class="h-48 bg-primary/5 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <x-icon name="o-academic-cap" class="w-16 h-16 text-primary/20" />
                            </div>
                            <div class="absolute top-4 left-4">
                                <div class="badge badge-primary font-bold shadow-sm">{{ $course->category }}</div>
                            </div>
                        </figure>

                        <div class="card-body p-6 flex-grow flex flex-col">
                            <h3 class="card-title text-xl font-bold line-clamp-2 leading-tight min-h-[3.5rem]">{{ $course->title }}</h3>
                            
                            <p class="text-sm text-base-content/60 line-clamp-3 mt-2 flex-grow">
                                {{ Str::limit(strip_tags($course->content), 120) }}
                            </p>

                            <div class="flex items-center justify-end w-full mt-6">
                                <a href="{{ route('courses.show', $course->id) }}" class="btn w-full btn-primary btn-sm px-5" wire:navigate>
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-base-100 border border-base-300 border-dashed rounded-2xl text-center">
                        <div class="w-20 h-20 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <x-icon name="o-academic-cap" class="w-10 h-10 opacity-20" />
                        </div>
                        <h3 class="text-2xl font-bold mb-2">No courses found</h3>
                        <p class="text-base-content/60 mb-8 max-w-sm mx-auto">Try adjusting your filters or search keywords to find what you're looking for.</p>
                        <button wire:click="clearFilters" class="btn btn-outline btn-primary">
                            Clear All Filters
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</div>
