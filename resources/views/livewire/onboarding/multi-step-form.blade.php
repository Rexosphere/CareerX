<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public int $currentStep = 1;
    public int $totalSteps = 2;

    // Step 1 fields
    #[Validate('required|string|max:255')]
    public string $full_name = '';

    #[Validate('required|string|max:20')]
    public string $student_id = '';

    #[Validate('required|string')]
    public string $department = '';

    public string $about_me = '';

    // Step 2 fields
    public array $skills = [];
    public string $skillInput = '';

    #[Validate('nullable|file|mimes:pdf|max:5120')]
    public $cv_file = null;

    public function mount(): void
    {
        // Initialize with demo data for Step 2
        $this->skills = ['Java', 'Project Management', 'UI/UX Design'];
    }

    public function addSkill(): void
    {
        if (trim($this->skillInput) !== '' && !in_array(trim($this->skillInput), $this->skills)) {
            $this->skills[] = trim($this->skillInput);
            $this->skillInput = '';
        }
    }

    public function removeSkill(int $index): void
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'full_name' => 'required|string|max:255',
                'student_id' => 'required|string|max:20',
                'department' => 'required|string',
            ]);
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit(): void
    {
        $this->validate();

        // Handle CV file upload
        $cvPath = null;
        if ($this->cv_file) {
            $cvPath = $this->cv_file->store('cvs', 'public');
        }

        // Map department abbreviation to full course name
        $departmentMap = [
            'cse' => 'Computer Science & Engineering',
            'entc' => 'Electronic & Telecommunication Engineering',
            'civil' => 'Civil Engineering',
            'mech' => 'Mechanical Engineering',
            'it' => 'Information Technology',
            'archi' => 'Architecture',
            'nds' => 'Interdisciplinary Studies',
        ];

        // Create or update student profile
        auth()->user()->studentProfile()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'student_id' => $this->student_id,
                'course' => $departmentMap[$this->department] ?? $this->department,
                'year' => 1, // Default to first year, can be enhanced later
                'bio' => $this->about_me,
                'skills' => $this->skills,
                'cv_path' => $cvPath,
                'available_for_hire' => true,
            ]
        );

        // Update user's full name if provided
        auth()->user()->update([
            'name' => $this->full_name,
        ]);

        session()->flash('message', 'Profile setup completed successfully!');

        $this->redirect(route('home'));
    }

    public function getProgressPercentage(): int
    {
        return (int) (($this->currentStep / $this->totalSteps) * 100);
    }
}; ?>

<div class="card bg-base-100 shadow-xl border border-base-300">
    <div class="card-body">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-black text-base-content mb-2">
                {{ $currentStep === 1 ? 'Complete Your Profile' : 'Skills & CV Upload' }}
            </h1>
            <p class="text-base-content/70">
                {{ $currentStep === 1 ? 'Please provide your personal details to get started.' : 'Showcase your talents to potential employers.' }}
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between items-end mb-3">
                <p class="text-primary text-sm font-bold uppercase">Step {{ $currentStep }} of {{ $totalSteps }}</p>
                <span class="text-base-content/60 text-sm">{{ $this->getProgressPercentage() }}% Completed</span>
            </div>
            <progress class="progress progress-primary w-full" value="{{ $this->getProgressPercentage() }}"
                max="100"></progress>
            <p class="text-sm font-medium text-base-content mt-2">
                {{ $currentStep === 1 ? 'Personal Details' : 'Skills & Resume' }}
            </p>
        </div>

        <div class="divider mt-0"></div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-alert icon="o-check-circle" class="alert-success mb-6">
                {{ session('message') }}
            </x-alert>
        @endif

        <!-- Step 1: Personal Details -->
        @if ($currentStep === 1)
            <form wire:submit="nextStep" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Full Name (2/3 width) -->
                    <div class="md:col-span-2">
                        <x-input label="Full Name" wire:model="full_name" icon="o-user" placeholder="e.g. Chamara Silva" />
                    </div>

                    <!-- Student ID (1/3 width) -->
                    <div>
                        <x-input label="Student ID" wire:model="student_id" icon="o-identification"
                            placeholder="e.g. 190000X" class="uppercase" />
                    </div>
                </div>

                <!-- Department -->
                <x-select label="Department" wire:model="department" icon="o-academic-cap" :options="[
                ['id' => '', 'name' => 'Select your department'],
                ['id' => 'cse', 'name' => 'Computer Science & Engineering'],
                ['id' => 'entc', 'name' => 'Electronic & Telecommunication Engineering'],
                ['id' => 'civil', 'name' => 'Civil Engineering'],
                ['id' => 'mech', 'name' => 'Mechanical Engineering'],
                ['id' => 'it', 'name' => 'Information Technology'],
                ['id' => 'archi', 'name' => 'Architecture'],
                ['id' => 'nds', 'name' => 'Interdisciplinary Studies'],
            ]"
                    option-value="id" option-label="name" />

                <!-- About Me -->
                <x-textarea label="About Me" wire:model="about_me"
                    placeholder="Briefly describe your academic interests, career goals, and what makes you unique..."
                    rows="4" hint="Optional" />

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-4 border-t border-base-300">
                    <x-button label="Cancel" class="btn-ghost hidden md:inline-flex" />
                    <x-button label="Next Step" icon-right="o-arrow-right" class="btn-primary" type="submit"
                        spinner="nextStep" />
                </div>
            </form>
        @endif

        <!-- Step 2: Skills & CV -->
        @if ($currentStep === 2)
            <form wire:submit="submit" class="space-y-6">
                <!-- Skills Section -->
                <div>
                    <label class="label">
                        <span class="label-text flex items-center  mb-2 gap-2">
                            <x-icon name="o-academic-cap" class="w-4 h-4 text-primary" />
                            <span class="font-medium ">Key Skills</span>
                        </span>
                    </label>

                    <div class="space-y-3">
                        <x-input wire:model="skillInput" wire:keydown.enter.prevent="addSkill"
                            placeholder="Type a skill (e.g., Python, UI Design) and hit Enter..." icon="o-plus-circle" />

                        <!-- Skill Chips -->
                        <div class="flex flex-wrap gap-2">
                            @foreach ($skills as $index => $skill)
                                <div class="badge badge-primary badge-lg gap-2">
                                    <span>{{ $skill }}</span>
                                    <button wire:click="removeSkill({{ $index }})" type="button"
                                        class="btn btn-ghost btn-xs btn-circle">
                                        <x-icon name="o-x-mark" class="w-3 h-3" />
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- CV Upload Section -->
                <div class="w-full">
                    <label class="label">
                        <span class="label-text flex items-center gap-2">
                            <x-icon name="o-document-text" class="w-4 h-4 text-primary" />
                            <span class="font-medium">Resume / CV</span>
                        </span>
                    </label>

                    <x-file wire:model="cv_file" accept="application/pdf" hint="Max file size: 5MB. PDF only."
                        class="w-full text-center">
                        <div class="flex flex-col w-full h-full items-center justify-center py-8">
                            <div class="mb-3 rounded-full bg-primary/10 p-3 mx-auto">
                                <x-icon name="o-cloud-arrow-up" class="w-8 h-8 text-primary" />
                            </div>
                            <div class="text-center w-full">
                                <p class="text-sm font-medium">
                                    <span class="text-primary font-bold hover:underline cursor-pointer">Click to
                                        browse</span>
                                    <span class="opacity-70">or drag CV here</span>
                                </p>
                            </div>
                        </div>
                    </x-file>

                    @if ($cv_file)
                        <div class="mt-4 alert alert-success">
                            <x-icon name="o-document-duplicate" class="w-5 h-5" />
                            <div class="flex-1">
                                <p class="font-medium">{{ $cv_file->getClientOriginalName() }}</p>
                                <p class="text-xs opacity-70">{{ number_format($cv_file->getSize() / 1024 / 1024, 1) }} MB</p>
                            </div>
                            <button wire:click="$set('cv_file', null)" type="button" class="btn btn-ghost btn-sm btn-circle">
                                <x-icon name="o-trash" class="w-4 h-4" />
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-4 border-t border-base-300">
                    <x-button label="Back" icon="o-arrow-left" wire:click="previousStep" class="btn-ghost" />
                    <x-button label="Finish Setup" icon-right="o-check" class="btn-primary" type="submit"
                        spinner="submit" />
                </div>
            </form>
        @endif
    </div>
</div>