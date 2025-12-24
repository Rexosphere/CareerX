<?php

use Livewire\Volt\Component;
use App\Models\ResearchProject;

new class extends Component {
    public $userId;
    public $projects = [];

    public function mount($userId): void
    {
        $this->userId = $userId;
        $this->loadProjects();
    }

    public function loadProjects(): void
    {
        $this->projects = ResearchProject::where('user_id', $this->userId)
            ->latest()
            ->get();
    }

    public function incrementView($projectId): void
    {
        $project = ResearchProject::find($projectId);
        if ($project) {
            $project->incrementViews();
            $this->loadProjects();
        }
    }
}; ?>

<div class="space-y-4">
    @if(count($projects) > 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-lg flex items-center gap-2">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                    Research & Academia
                </h3>

                <div class="space-y-4 mt-4">
                    @foreach($projects as $project)
                        <div class="border border-base-300 rounded-lg p-4 hover:bg-base-200/50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg">
                                        {{ $project->title }}
                                        <div class="badge badge-{{ $project->status === 'Published' ? 'success' : ($project->status === 'Completed' ? 'info' : 'warning') }} badge-sm ml-2">
                                            {{ $project->status }}
                                        </div>
                                    </h4>
                                    <div class="text-sm text-base-content/60 mt-1">
                                        {{ $project->type }}
                                        @if($project->supervisor)
                                            | Supervisor: {{ $project->supervisor }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <p class="text-base-content/80 mt-3">{{ $project->description }}</p>

                            @if($project->abstract)
                                <div class="collapse collapse-arrow bg-base-200/50 mt-3">
                                    <input type="checkbox" wire:click="incrementView({{ $project->id }})" />
                                    <div class="collapse-title text-sm font-medium">Read Abstract</div>
                                    <div class="collapse-content">
                                        <p class="text-sm">{{ $project->abstract }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-4 mt-3 text-sm text-base-content/70">
                                @if($project->department)
                                    <div class="flex items-center gap-1">
                                        <x-icon name="o-building-library" class="w-4 h-4" />
                                        {{ $project->department }}
                                    </div>
                                @endif
                                @if($project->start_date)
                                    <div class="flex items-center gap-1">
                                        <x-icon name="o-calendar" class="w-4 h-4" />
                                        {{ $project->start_date->format('M Y') }}
                                        @if($project->end_date)
                                            - {{ $project->end_date->format('M Y') }}
                                        @endif
                                    </div>
                                @endif
                                @if($project->views > 0)
                                    <div class="flex items-center gap-1">
                                        <x-icon name="o-eye" class="w-4 h-4" />
                                        {{ $project->views }} views
                                    </div>
                                @endif
                            </div>

                            @if($project->authors && count($project->authors) > 0)
                                <div class="mt-3">
                                    <span class="text-sm font-medium">Co-Authors:</span>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($project->authors as $author)
                                            <div class="badge badge-outline badge-sm">{{ $author }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($project->tags && count($project->tags) > 0)
                                <div class="mt-3">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($project->tags as $tag)
                                            <div class="badge badge-primary badge-sm">{{ $tag }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($project->conference || $project->journal)
                                <div class="mt-3 text-sm">
                                    @if($project->conference)
                                        <div class="flex items-center gap-1">
                                            <x-icon name="o-presentation-chart-line" class="w-4 h-4" />
                                            <span class="font-medium">Conference:</span> {{ $project->conference }}
                                        </div>
                                    @endif
                                    @if($project->journal)
                                        <div class="flex items-center gap-1 mt-1">
                                            <x-icon name="o-book-open" class="w-4 h-4" />
                                            <span class="font-medium">Journal:</span> {{ $project->journal }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-2 mt-4">
                                @if($project->publication_link)
                                    <a href="{{ $project->publication_link }}" target="_blank"
                                       class="btn btn-xs btn-outline gap-1">
                                        <x-icon name="o-link" class="w-3 h-3" />
                                        Publication
                                    </a>
                                @endif
                                @if($project->doi)
                                    <a href="https://doi.org/{{ $project->doi }}" target="_blank"
                                       class="btn btn-xs btn-outline gap-1">
                                        <x-icon name="o-hashtag" class="w-3 h-3" />
                                        DOI
                                    </a>
                                @endif
                                @if($project->file_path)
                                    <a href="{{ Storage::url($project->file_path) }}" target="_blank"
                                       class="btn btn-xs btn-outline gap-1">
                                        <x-icon name="o-document-text" class="w-3 h-3" />
                                        View PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
