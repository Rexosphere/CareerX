<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    #[Url(as: 'q')]
    public string $searchSkills = '';

    public array $selectedDepartments = [];
    public array $selectedAvailability = [];
    public int $minExperience = 0;
    public int $maxExperience = 4;

    public function with(): array
    {
        // Build query from database
        $query = StudentProfile::query()
            ->with('user')
            ->whereHas('user'); // Only profiles with associated users

        // Search filter - search in user name and skills
        if (!empty($this->searchSkills)) {
            $searchTerm = '%' . $this->searchSkills . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', $searchTerm);
                })
                    ->orWhere('skills', 'like', $searchTerm)
                    ->orWhere('bio', 'like', $searchTerm)
                    ->orWhere('course', 'like', $searchTerm);
            });
        }

        // Department/Course filter
        if (!empty($this->selectedDepartments)) {
            $query->whereIn('course', $this->selectedDepartments);
        }

        // Experience/Year filter
        if ($this->maxExperience < 4) {
            $query->where('year', '<=', $this->maxExperience + 1);
        }

        // Availability filter
        if (!empty($this->selectedAvailability)) {
            if (in_array('Available', $this->selectedAvailability)) {
                $query->where('available_for_hire', true);
            }
        }

        // Get students and format data
        $students = $query->latest()->get()->map(function ($profile) {
            $skills = is_array($profile->skills) ? $profile->skills : [];
            $avatarUrl = null;

            if ($profile->profile_photo_path) {
                $avatarUrl = Storage::url($profile->profile_photo_path);
            } else {
                $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->name ?? 'Student') . '&background=0d9ef2&color=fff';
            }

            return [
                'id' => $profile->user_id,
                'name' => $profile->user->name ?? 'Unknown',
                'department' => $profile->course ?? 'Not specified',
                'year' => $profile->year ?? 1,
                'avatar' => $avatarUrl,
                'skills' => array_slice($skills, 0, 3), // Show max 3 skills
                'available' => $profile->available_for_hire ?? false,
            ];
        })->toArray();

        // Get unique departments/courses from database
        $departments = StudentProfile::query()
            ->whereNotNull('course')
            ->distinct()
            ->pluck('course')
            ->filter()
            ->values()
            ->toArray();

        // If no departments found, use default list
        if (empty($departments)) {
            $departments = [
                'Computer Science',
                'Civil Engineering',
                'Electrical Engineering',
                'Mechanical Engineering',
                'IT & Management',
                'Architecture'
            ];
        }

        return [
            'students' => $students,
            'totalStudents' => count($students),
            'departments' => $departments,
            'availabilityOptions' => [
                'Available',
                'Not Available'
            ]
        ];
    }

    public function clearFilters(): void
    {
        $this->selectedDepartments = [];
        $this->selectedAvailability = [];
        $this->minExperience = 0;
        $this->maxExperience = 4;
        $this->searchSkills = '';
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Left Sidebar (Filters) --}}
        <aside class="w-full lg:w-1/4 min-w-[280px] flex flex-col gap-6">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-lg">Filters</h3>
                <button wire:click="clearFilters" class="text-sm text-primary font-medium hover:underline">Clear
                    All</button>
            </div>

            {{-- Search Input --}}
            <div class="form-control">
                <label class="input input-bordered flex items-center gap-2 shadow-sm">
                    <x-icon name="o-magnifying-glass" class="text-base-content/60 w-5 h-5" />
                    <input wire:model.live="searchSkills" type="text" class="grow"
                        placeholder="Search skills (e.g. React)..." />
                </label>
            </div>

            {{-- Department Filter --}}
            <div class="collapse collapse-arrow bg-base-100 border border-base-300 shadow-sm">
                <input type="checkbox" checked />
                <div class="collapse-title font-bold text-sm">
                    Department
                </div>
                <div class="collapse-content">
                    <div class="flex flex-col gap-2 pt-2 border-t border-dashed border-base-300">
                        @foreach($departments as $dept)
                            <label class="label cursor-pointer justify-start gap-3">
                                <input wire:model.live="selectedDepartments" type="checkbox" value="{{ $dept }}"
                                    class="checkbox checkbox-primary checkbox-sm" />
                                <span class="label-text">{{ $dept }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Experience Level Filter --}}
            <div class="collapse collapse-arrow bg-base-100 border border-base-300 shadow-sm">
                <input type="checkbox" checked />
                <div class="collapse-title font-bold text-sm">
                    Experience (Years)
                </div>
                <div class="collapse-content">
                    <div class="pt-6 pb-4 border-t border-dashed border-base-300 px-2">
                        <div class="flex flex-col items-center gap-4">
                            <input type="range" min="0" max="4" wire:model.live="maxExperience"
                                class="range range-primary range-sm" />
                            <div class="flex justify-between w-full text-xs text-base-content/70 font-medium">
                                <span>0 Years</span>
                                <span>{{ $maxExperience }} Years</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Availability Filter --}}
            <div class="collapse collapse-arrow bg-base-100 border border-base-300 shadow-sm">
                <input type="checkbox" />
                <div class="collapse-title font-bold text-sm">
                    Availability
                </div>
                <div class="collapse-content">
                    <div class="flex flex-col gap-2 pt-2 border-t border-dashed border-base-300">
                        @foreach($availabilityOptions as $option)
                            <label class="label cursor-pointer justify-start gap-3">
                                <input wire:model.live="selectedAvailability" type="checkbox" value="{{ $option }}"
                                    class="checkbox checkbox-primary checkbox-sm" />
                                <span class="label-text">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        {{-- Right Content (Grid) --}}
        <div class="flex-1 flex flex-col gap-8">
            {{-- Student Count --}}
            <div class="text-sm text-base-content/70">
                Showing <span class="font-bold text-base-content">{{ $totalStudents }}</span> active students
            </div>

            {{-- Talent Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($students as $student)
                    <div
                        class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="card-body items-center gap-4">
                            {{-- Avatar --}}
                            <div class="relative">
                                <div class="avatar {{ $student['available'] ? 'online' : '' }} placeholder">
                                    <div
                                        class="w-24 rounded-full {{ $student['avatar'] ? '' : 'bg-neutral text-neutral-content' }}">
                                        @if($student['avatar'])
                                            <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                                        @else
                                            <span
                                                class="text-2xl font-bold">{{ $student['initials'] ?? strtoupper(substr($student['name'], 0, 2)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="text-center flex flex-col gap-1">
                                <h3 class="card-title text-lg justify-center">{{ $student['name'] }}</h3>
                                <p class="text-sm text-base-content/70 font-medium">{{ $student['department'] }}</p>
                                <p class="text-xs text-base-content/60">Year {{ $student['year'] }}</p>
                            </div>

                            {{-- Skills --}}
                            <div class="flex flex-wrap justify-center gap-2 mt-1">
                                @foreach($student['skills'] as $skill)
                                    <span class="badge badge-outline badge-primary badge-sm">{{ $skill }}</span>
                                @endforeach
                            </div>

                            {{-- Action Button --}}
                            <a href="{{ route('students.profile', $student['id']) }}"
                                class="btn btn-primary btn-sm w-full mt-auto gap-2" wire:navigate>
                                <span>View Profile</span>
                                <x-icon name="o-arrow-right" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(count($students) > 0)
                <div class="flex justify-center mt-4">
                    <div class="text-sm text-base-content/60">
                        Showing {{ count($students) }} students
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>