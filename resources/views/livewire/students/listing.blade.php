<?php
use Livewire\Volt\Component;

new class extends Component {
    public array $selectedDepartments = [];
    public array $selectedAvailability = [];
    public int $minExperience = 0;
    public int $maxExperience = 4;
    public string $searchSkills = '';

    public function with(): array
    {
        // Mock data for demonstration
        $students = [
            [
                'id' => 1,
                'name' => 'Saman Perera',
                'department' => 'Computer Science',
                'year' => 3,
                'gpa' => 3.8,
                'avatar' => 'https://ui-avatars.com/api/?name=Saman+Perera&background=0d9ef2&color=fff',
                'skills' => ['React', 'Node.js', 'Figma'],
                'available' => true
            ],
            [
                'id' => 2,
                'name' => 'Nethmi Silva',
                'department' => 'Civil Engineering',
                'year' => 4,
                'gpa' => 3.9,
                'avatar' => 'https://ui-avatars.com/api/?name=Nethmi+Silva&background=0d9ef2&color=fff',
                'skills' => ['AutoCAD', 'Revit', 'Project Mgmt'],
                'available' => true
            ],
            [
                'id' => 3,
                'name' => 'Kavindu Dias',
                'department' => 'Electrical Engineering',
                'year' => 3,
                'gpa' => 3.5,
                'avatar' => 'https://ui-avatars.com/api/?name=Kavindu+Dias&background=0d9ef2&color=fff',
                'skills' => ['Matlab', 'Python', 'Circuits'],
                'available' => false
            ],
            [
                'id' => 4,
                'name' => 'Amara Fernando',
                'department' => 'Mechanical Engineering',
                'year' => 2,
                'gpa' => 3.7,
                'avatar' => 'https://ui-avatars.com/api/?name=Amara+Fernando&background=0d9ef2&color=fff',
                'skills' => ['SolidWorks', 'Thermodynamics'],
                'available' => true
            ],
            [
                'id' => 5,
                'name' => 'Tharindu Raj',
                'department' => 'IT & Management',
                'year' => 4,
                'gpa' => 3.4,
                'avatar' => null,
                'initials' => 'TR',
                'skills' => ['SQL', 'Business Analysis', 'Agile'],
                'available' => false
            ],
            [
                'id' => 6,
                'name' => 'Dilani Perera',
                'department' => 'Architecture',
                'year' => 5,
                'gpa' => 3.9,
                'avatar' => 'https://ui-avatars.com/api/?name=Dilani+Perera&background=0d9ef2&color=fff',
                'skills' => ['3D Max', 'SketchUp', 'Rendering'],
                'available' => true
            ],
        ];

        return [
            'students' => $students,
            'totalStudents' => 1240,
            'departments' => [
                'Computer Science',
                'Civil Engineering',
                'Electrical Engineering',
                'Mechanical Engineering',
                'IT & Management',
                'Architecture'
            ],
            'availabilityOptions' => [
                'Internship',
                'Part-time',
                'Full-time'
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
                <button wire:click="clearFilters" class="text-sm text-primary font-medium hover:underline">Clear All</button>
            </div>

            {{-- Search Input --}}
            <div class="form-control">
                <label class="input input-bordered flex items-center gap-2 shadow-sm">
                    <x-icon name="o-magnifying-glass" class="text-base-content/60 w-5 h-5" />
                    <input wire:model.live="searchSkills" type="text" class="grow" placeholder="Search skills (e.g. React)..." />
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
                                <input wire:model.live="selectedDepartments" type="checkbox" value="{{ $dept }}" class="checkbox checkbox-primary checkbox-sm" />
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
                            <input type="range" min="0" max="4" wire:model.live="maxExperience" class="range range-primary range-sm" />
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
                                <input wire:model.live="selectedAvailability" type="checkbox" value="{{ $option }}" class="checkbox checkbox-primary checkbox-sm" />
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
                    <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="card-body items-center gap-4">
                            {{-- Avatar --}}
                            <div class="relative">
                                <div class="avatar {{ $student['available'] ? 'online' : '' }} placeholder">
                                    <div class="w-24 rounded-full {{ $student['avatar'] ? '' : 'bg-neutral text-neutral-content' }}">
                                        @if($student['avatar'])
                                            <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                                        @else
                                            <span class="text-2xl font-bold">{{ $student['initials'] ?? strtoupper(substr($student['name'], 0, 2)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="text-center flex flex-col gap-1">
                                <h3 class="card-title text-lg justify-center">{{ $student['name'] }}</h3>
                                <p class="text-sm text-base-content/70 font-medium">{{ $student['department'] }}</p>
                                <p class="text-xs text-base-content/60">Year {{ $student['year'] }} • {{ $student['gpa'] }} GPA</p>
                            </div>

                            {{-- Skills --}}
                            <div class="flex flex-wrap justify-center gap-2 mt-1">
                                @foreach($student['skills'] as $skill)
                                    <span class="badge badge-outline badge-primary badge-sm">{{ $skill }}</span>
                                @endforeach
                            </div>

                            {{-- Action Button --}}
                            <a href="{{ route('students.profile', $student['id']) }}" class="btn btn-primary btn-sm w-full mt-auto gap-2" wire:navigate>
                                <span>View Profile</span>
                                <x-icon name="o-arrow-right" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center mt-4">
                <div class="join">
                    <button class="join-item btn btn-sm">
                        <x-icon name="o-chevron-left" class="w-6 h-6" />
                    </button>
                    <button class="join-item btn btn-sm btn-active btn-primary">1</button>
                    <button class="join-item btn btn-sm">2</button>
                    <button class="join-item btn btn-sm">3</button>
                    <button class="join-item btn btn-sm btn-disabled">...</button>
                    <button class="join-item btn btn-sm">12</button>
                    <button class="join-item btn btn-sm">
                        <x-icon name="o-chevron-right" class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
