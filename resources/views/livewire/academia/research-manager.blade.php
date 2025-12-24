<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\ResearchProject;

new class extends Component {
    use WithFileUploads;

    public $projects = [];
    public $showForm = false;
    public $editMode = false;
    public $editingProjectId = null;

    // Form fields
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $type = 'Undergraduate Project';

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('required|string')]
    public string $status = 'Ongoing';

    #[Validate('nullable|string')]
    public string $supervisor = '';

    #[Validate('nullable|string')]
    public string $department = '';

    #[Validate('nullable|date')]
    public $start_date = null;

    #[Validate('nullable|date')]
    public $end_date = null;

    #[Validate('nullable|string')]
    public string $publication_link = '';

    #[Validate('nullable|string')]
    public string $doi = '';

    #[Validate('nullable|string')]
    public string $conference = '';

    #[Validate('nullable|string')]
    public string $journal = '';

    #[Validate('nullable|string')]
    public string $abstract = '';

    #[Validate('nullable|file|mimes:pdf|max:10240')] // 10MB Max
    public $file;

    public array $authors = [];
    public string $newAuthor = '';

    public array $tags = [];
    public string $newTag = '';

    public function mount(): void
    {
        $this->loadProjects();
    }

    public function loadProjects(): void
    {
        $this->projects = auth()->user()->researchProjects()->latest()->get();
    }

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }

    public function addAuthor(): void
    {
        if (trim($this->newAuthor) !== '' && !in_array($this->newAuthor, $this->authors)) {
            $this->authors[] = trim($this->newAuthor);
            $this->newAuthor = '';
        }
    }

    public function removeAuthor(int $index): void
    {
        unset($this->authors[$index]);
        $this->authors = array_values($this->authors);
    }

    public function addTag(): void
    {
        if (trim($this->newTag) !== '' && !in_array($this->newTag, $this->tags)) {
            $this->tags[] = trim($this->newTag);
            $this->newTag = '';
        }
    }

    public function removeTag(int $index): void
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'status' => $this->status,
            'supervisor' => $this->supervisor,
            'department' => $this->department,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'authors' => $this->authors,
            'tags' => $this->tags,
            'publication_link' => $this->publication_link,
            'doi' => $this->doi,
            'conference' => $this->conference,
            'journal' => $this->journal,
            'abstract' => $this->abstract,
        ];

        if ($this->file) {
            $data['file_path'] = $this->file->store('research-papers', 'public');
        }

        if ($this->editMode && $this->editingProjectId) {
            $project = ResearchProject::findOrFail($this->editingProjectId);
            $project->update($data);
            session()->flash('message', 'Research project updated successfully.');
        } else {
            auth()->user()->researchProjects()->create($data);
            session()->flash('message', 'Research project added successfully.');
        }

        $this->loadProjects();
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit(int $id): void
    {
        $project = ResearchProject::findOrFail($id);

        $this->editMode = true;
        $this->editingProjectId = $id;
        $this->showForm = true;

        $this->title = $project->title;
        $this->type = $project->type;
        $this->description = $project->description;
        $this->status = $project->status;
        $this->supervisor = $project->supervisor ?? '';
        $this->department = $project->department ?? '';
        $this->start_date = $project->start_date?->format('Y-m-d');
        $this->end_date = $project->end_date?->format('Y-m-d');
        $this->authors = $project->authors ?? [];
        $this->tags = $project->tags ?? [];
        $this->publication_link = $project->publication_link ?? '';
        $this->doi = $project->doi ?? '';
        $this->conference = $project->conference ?? '';
        $this->journal = $project->journal ?? '';
        $this->abstract = $project->abstract ?? '';
    }

    public function delete(int $id): void
    {
        $project = ResearchProject::findOrFail($id);
        $project->delete();

        $this->loadProjects();
        session()->flash('message', 'Research project deleted successfully.');
    }

    public function resetForm(): void
    {
        $this->editMode = false;
        $this->editingProjectId = null;
        $this->title = '';
        $this->type = 'Undergraduate Project';
        $this->description = '';
        $this->status = 'Ongoing';
        $this->supervisor = '';
        $this->department = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->authors = [];
        $this->tags = [];
        $this->publication_link = '';
        $this->doi = '';
        $this->conference = '';
        $this->journal = '';
        $this->abstract = '';
        $this->file = null;
        $this->newAuthor = '';
        $this->newTag = '';
    }
}; ?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">My Research & Academia</h2>
        <x-button label="{{ $showForm ? 'Cancel' : 'Add Research Project' }}"
                  icon="o-{{ $showForm ? 'x-mark' : 'plus' }}"
                  class="btn-primary"
                  wire:click="toggleForm" />
    </div>

    @if($showForm)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">{{ $editMode ? 'Edit' : 'Add' }} Research Project</h3>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="Project Title *" wire:model="title" icon="o-academic-cap"
                                 placeholder="e.g., Machine Learning for Traffic Prediction" />

                        <x-select label="Project Type *" wire:model="type" icon="o-document-text">
                            <x-select.option value="Undergraduate Project">Undergraduate Project</x-select.option>
                            <x-select.option value="Msc Thesis">Msc Thesis</x-select.option>
                            <x-select.option value="PhD Research">PhD Research</x-select.option>
                            <x-select.option value="Research Paper">Research Paper</x-select.option>
                            <x-select.option value="Conference Paper">Conference Paper</x-select.option>
                            <x-select.option value="Journal Article">Journal Article</x-select.option>
                        </x-select>

                        <x-select label="Status *" wire:model="status" icon="o-chart-bar">
                            <x-select.option value="Ongoing">Ongoing</x-select.option>
                            <x-select.option value="Completed">Completed</x-select.option>
                            <x-select.option value="Published">Published</x-select.option>
                        </x-select>

                        <x-input label="Supervisor" wire:model="supervisor" icon="o-user"
                                 placeholder="e.g., Dr. John Doe" />

                        <x-input label="Department" wire:model="department" icon="o-building-library"
                                 placeholder="e.g., Computer Science & Engineering" />

                        <x-input label="Start Date" wire:model="start_date" type="date" icon="o-calendar" />

                        <x-input label="End Date" wire:model="end_date" type="date" icon="o-calendar" />
                    </div>

                    <x-textarea label="Description *" wire:model="description"
                                placeholder="Describe your research project..." rows="3" />

                    <x-textarea label="Abstract (Optional)" wire:model="abstract"
                                placeholder="Research abstract or summary..." rows="4" />

                    <!-- Authors Section -->
                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Co-Authors / Collaborators</span>
                        </label>
                        <div class="flex gap-2 items-end mb-2">
                            <div class="flex-1">
                                <x-input wire:model="newAuthor" placeholder="Author name"
                                         wire:keydown.enter.prevent="addAuthor" />
                            </div>
                            <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="addAuthor" />
                        </div>
                        @if(count($authors) > 0)
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($authors as $index => $author)
                                    <div class="badge badge-lg gap-2">
                                        {{ $author }}
                                        <button type="button" wire:click="removeAuthor({{ $index }})"
                                                class="btn btn-ghost btn-xs">
                                            <x-icon name="o-x-mark" class="w-3 h-3" />
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Tags Section -->
                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Research Areas / Keywords</span>
                        </label>
                        <div class="flex gap-2 items-end mb-2">
                            <div class="flex-1">
                                <x-input wire:model="newTag" placeholder="e.g., Machine Learning"
                                         wire:keydown.enter.prevent="addTag" />
                            </div>
                            <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="addTag" />
                        </div>
                        @if(count($tags) > 0)
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($tags as $index => $tag)
                                    <div class="badge badge-primary badge-outline gap-2">
                                        {{ $tag }}
                                        <button type="button" wire:click="removeTag({{ $index }})"
                                                class="btn btn-ghost btn-xs">
                                            <x-icon name="o-x-mark" class="w-3 h-3" />
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input label="Publication Link" wire:model="publication_link" icon="o-link"
                                 placeholder="https://..." />

                        <x-input label="DOI" wire:model="doi" icon="o-hashtag"
                                 placeholder="e.g., 10.1000/xyz123" />

                        <x-input label="Conference" wire:model="conference" icon="o-presentation-chart-line"
                                 placeholder="Conference name" />

                        <x-input label="Journal" wire:model="journal" icon="o-book-open"
                                 placeholder="Journal name" />
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Upload Research Paper (PDF)</span>
                        </label>
                        <input type="file" wire:model="file" accept=".pdf"
                               class="file-input file-input-bordered w-full" />
                        @if($file)
                            <div class="text-sm text-success mt-1">
                                Selected: {{ $file->getClientOriginalName() }}
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <x-button label="Cancel" class="btn-ghost" wire:click="toggleForm" type="button" />
                        <x-button label="{{ $editMode ? 'Update' : 'Save' }} Project"
                                  class="btn-primary" type="submit" spinner="save" />
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Projects List -->
    @if(count($projects) > 0)
        <div class="space-y-4">
            @foreach($projects as $project)
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="card-title text-xl">
                                    {{ $project->title }}
                                    <div class="badge badge-{{ $project->status === 'Published' ? 'success' : ($project->status === 'Completed' ? 'info' : 'warning') }}">
                                        {{ $project->status }}
                                    </div>
                                </h3>
                                <div class="text-sm text-base-content/60 mt-1">
                                    {{ $project->type }}
                                    @if($project->supervisor)
                                        | Supervisor: {{ $project->supervisor }}
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $project->id }})"
                                        class="btn btn-ghost btn-sm">
                                    <x-icon name="o-pencil" class="w-4 h-4" />
                                </button>
                                <button wire:click="delete({{ $project->id }})"
                                        class="btn btn-ghost btn-sm text-error"
                                        onclick="return confirm('Are you sure you want to delete this project?')">
                                    <x-icon name="o-trash" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>

                        <p class="text-base-content/80 mt-3">{{ $project->description }}</p>

                        @if($project->abstract)
                            <div class="collapse collapse-arrow bg-base-200/50 mt-2">
                                <input type="checkbox" />
                                <div class="collapse-title font-medium">Abstract</div>
                                <div class="collapse-content">
                                    <p class="text-sm">{{ $project->abstract }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-wrap gap-4 mt-4 text-sm">
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
                                        <div class="badge badge-outline">{{ $author }}</div>
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

                        <div class="flex flex-wrap gap-2 mt-4">
                            @if($project->publication_link)
                                <a href="{{ $project->publication_link }}" target="_blank"
                                   class="btn btn-sm btn-outline gap-2">
                                    <x-icon name="o-link" class="w-4 h-4" />
                                    Publication
                                </a>
                            @endif
                            @if($project->doi)
                                <a href="https://doi.org/{{ $project->doi }}" target="_blank"
                                   class="btn btn-sm btn-outline gap-2">
                                    <x-icon name="o-hashtag" class="w-4 h-4" />
                                    DOI
                                </a>
                            @endif
                            @if($project->file_path)
                                <a href="{{ Storage::url($project->file_path) }}" target="_blank"
                                   class="btn btn-sm btn-outline gap-2">
                                    <x-icon name="o-document-text" class="w-4 h-4" />
                                    PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @if(!$showForm)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center py-12">
                    <x-icon name="o-academic-cap" class="w-16 h-16 mx-auto text-base-content/20" />
                    <h3 class="text-xl font-bold mt-4">No research projects yet</h3>
                    <p class="text-base-content/60 mt-2">Start showcasing your academic work and research projects.</p>
                    <div class="mt-6">
                        <x-button label="Add Your First Project" icon="o-plus"
                                  class="btn-primary" wire:click="toggleForm" />
                    </div>
                </div>
            </div>
        @endif
    @endif

    <x-toast />
</div>
