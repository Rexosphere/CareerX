<?php
use Livewire\Volt\Component;

new class extends Component {
    public int $studentId;

    public function mount(int $studentId = 1): void
    {
        $this->studentId = $studentId;
    }

    public function with(): array
    {
        // Mock student data
        $student = [
            'id' => 1,
            'name' => 'Chamara Silva',
            'title' => 'Civil Engineering Undergraduate',
            'university' => 'University of Moratuwa',
            'avatar' => 'https://ui-avatars.com/api/?name=Chamara+Silva&background=0d9ef2&color=fff&size=256',
            'online' => true,
            'skills' => ['AutoCAD', 'Revit', 'Structural Analysis', 'Python', 'Project Management', 'Public Speaking', 'Civil 3D', 'MATLAB'],

        ];

        return ['student' => $student];
    }
}; ?>

<div class="flex flex-col max-w-4xl w-full gap-6">
    {{-- Profile Header Card --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body items-center gap-6 p-8">
            {{-- Avatar --}}
            <div class="avatar {{ $student['online'] ? 'online' : '' }} placeholder">
                <div class="w-32 rounded-full ring ring-base-300 ring-offset-base-100 ring-offset-2">
                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" />
                </div>
            </div>

            {{-- Info --}}
            <div class="flex flex-col items-center justify-center text-center gap-1">
                <h1 class="text-3xl font-bold">{{ $student['name'] }}</h1>
                <p class="text-lg text-base-content/70 font-medium">{{ $student['title'] }}</p>
                <div class="flex items-center gap-1 text-base-content/70 text-sm mt-1">
                    <x-icon name="o-academic-cap" class="w-4 h-4" />
                    <span>{{ $student['university'] }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap justify-center gap-3 w-full max-w-md">
                <button class="btn btn-primary gap-2 min-w-[140px]">
                    <x-icon name="o-user-plus" class="w-5 h-5" />
                    <span>Connect via LinkedIn</span>
                </button>
                <button class="btn btn-outline gap-2 min-w-[140px]">
                    <x-icon name="o-arrow-down-tray" class="w-5 h-5" />
                    <span>Download CV</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Skills Section --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6 md:p-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="bg-primary/10 text-primary p-2 rounded-lg">
                    <x-icon name="o-cpu-chip" class="w-5 h-5" />
                </div>
                <h2 class="card-title">Skills</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($student['skills'] as $skill)
                    <span class="badge badge-outline badge-primary badge-lg">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>