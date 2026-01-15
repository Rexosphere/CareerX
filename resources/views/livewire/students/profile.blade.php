<?php
use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public int $studentId;

    public function mount(int $studentId = 1): void
    {
        $this->studentId = $studentId;
    }

    public function with(): array
    {
        $user = User::with(['studentProfile', 'researchProjects'])->findOrFail($this->studentId);
        $profile = $user->studentProfile;

        // Check if current user can access CV
        $canAccessCv = false;
        if (auth()->check()) {
            // Allow if viewing own profile
            if (auth()->id() === $this->studentId) {
                $canAccessCv = true;
            }
            // Allow if company has received application from this student
            elseif (auth('company')->check()) {
                $companyId = auth('company')->id();
                $canAccessCv = \App\Models\Application::whereHas('jobPosting', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                })
                ->where('student_id', $this->studentId)
                ->exists();
            }
        }

        return [
            'user' => $user,
            'profile' => $profile,
            'canAccessCv' => $canAccessCv,
        ];
    }
}; ?>

<div class="flex flex-col max-w-4xl w-full gap-6">
    {{-- Profile Header Card --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body items-center gap-6 p-8">
            {{-- Avatar --}}
            <div class="avatar placeholder">
                <div class="w-32 rounded-full ring ring-base-300 ring-offset-base-100 ring-offset-2 bg-neutral text-neutral-content">
                    @if($profile?->profile_photo_path)
                        <img src="{{ Storage::url($profile->profile_photo_path) }}" alt="{{ $user->name }}" />
                    @else
                        <span class="text-4xl font-bold">{{ $user->initials() }}</span>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="flex flex-col items-center justify-center text-center gap-1">
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                @if($profile)
                    <p class="text-lg text-base-content/70 font-medium">
                        {{ $profile->course }} {{ $profile->year ? '- Year ' . $profile->year : '' }}
                    </p>
                    <div class="flex items-center gap-1 text-base-content/70 text-sm mt-1">
                        <x-icon name="o-academic-cap" class="w-4 h-4" />
                        <span>University of Moratuwa</span>
                    </div>
                    @if($profile->bio)
                        <p class="text-base-content/70 text-sm mt-3 max-w-2xl">{{ $profile->bio }}</p>
                    @endif
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap justify-center gap-3 w-full max-w-md">
                @if($profile?->linkedin)
                    <a href="{{ $profile->linkedin }}" target="_blank" class="btn btn-primary gap-2 min-w-[140px]">
                        <x-icon name="o-user-plus" class="w-5 h-5" />
                        <span>LinkedIn</span>
                    </a>
                @endif
                @if($profile?->github)
                    <a href="{{ $profile->github }}" target="_blank" class="btn btn-outline gap-2 min-w-[140px]">
                        <x-icon name="o-code-bracket" class="w-5 h-5" />
                        <span>GitHub</span>
                    </a>
                @endif
                @if($profile?->cv_path && $canAccessCv)
                    <a href="{{ route('cv.download.profile', $user->id) }}" target="_blank" class="btn btn-outline gap-2 min-w-[140px]">
                        <x-icon name="o-arrow-down-tray" class="w-5 h-5" />
                        <span>Download CV</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Skills Section --}}
    @if($profile?->skills && count($profile->skills) > 0)
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-6 md:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="bg-primary/10 text-primary p-2 rounded-lg">
                        <x-icon name="o-cpu-chip" class="w-5 h-5" />
                    </div>
                    <h2 class="card-title">Skills</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($profile->skills as $skill)
                        <span class="badge badge-outline badge-primary badge-lg">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Research & Academia Section --}}
    <livewire:academia.research-display :userId="$user->id" />
</div>