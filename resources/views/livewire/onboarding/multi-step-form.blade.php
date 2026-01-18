<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public int $currentStep = 1;
    public int $totalSteps = 2;

    // Step 1 fields
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

    public array $departmentsList = [];

    public function mount(): void
    {
        // Initialize departments list
        $this->departmentsList = [
            // Faculty of Architecture
            ['id' => 'Department of Architecture', 'name' => 'Department of Architecture'],
            ['id' => 'Department of Building Economics', 'name' => 'Department of Building Economics'],
            ['id' => 'Department of Town and Country Planning', 'name' => 'Department of Town and Country Planning'],
            ['id' => 'Department of Integrated Design', 'name' => 'Department of Integrated Design'],

            // Faculty of Engineering
            ['id' => 'Department of Chemical and Process Engineering', 'name' => 'Department of Chemical and Process Engineering'],
            ['id' => 'Department of Civil Engineering', 'name' => 'Department of Civil Engineering'],
            ['id' => 'Department of Computer Science and Engineering', 'name' => 'Department of Computer Science and Engineering'],
            ['id' => 'Department of Earth Resources Engineering', 'name' => 'Department of Earth Resources Engineering'],
            ['id' => 'Department of Electrical Engineering', 'name' => 'Department of Electrical Engineering'],
            ['id' => 'Department of Electronic and Telecommunication Engineering', 'name' => 'Department of Electronic and Telecommunication Engineering'],
            ['id' => 'Department of Materials Science and Engineering', 'name' => 'Department of Materials Science and Engineering'],
            ['id' => 'Department of Mechanical Engineering', 'name' => 'Department of Mechanical Engineering'],
            ['id' => 'Department of Textile and Apparel Engineering', 'name' => 'Department of Textile and Apparel Engineering'],
            ['id' => 'Department of Transport Management and Logistic Engineering', 'name' => 'Department of Transport Management and Logistic Engineering'],

            // Faculty of Information Technology
            ['id' => 'Department of Information Technology', 'name' => 'Department of Information Technology'],
            ['id' => 'Department of Computational Mathematics', 'name' => 'Department of Computational Mathematics'],
            ['id' => 'Department of Interdisciplinary Studies', 'name' => 'Department of Interdisciplinary Studies'],

            // Faculty of Business
            ['id' => 'Department of Decision Sciences', 'name' => 'Department of Decision Sciences'],
            ['id' => 'Department of Industrial Management', 'name' => 'Department of Industrial Management'],
            ['id' => 'Department of Management of Technology', 'name' => 'Department of Management of Technology'],

            // Faculty of Medicine
            ['id' => 'Department of Anatomy', 'name' => 'Department of Anatomy'],
            ['id' => 'Department of Biochemistry and Clinical Chemistry', 'name' => 'Department of Biochemistry and Clinical Chemistry'],
            ['id' => 'Department of Medical Education', 'name' => 'Department of Medical Education'],
            ['id' => 'Department of Medical Technology', 'name' => 'Department of Medical Technology'],
            ['id' => 'Department of Medicine and Mental Health', 'name' => 'Department of Medicine and Mental Health'],
            ['id' => 'Department of Microbiology and Parasitology', 'name' => 'Department of Microbiology and Parasitology'],
            ['id' => 'Department of Pathology and Forensic Medicine', 'name' => 'Department of Pathology and Forensic Medicine'],
            ['id' => 'Department of Pediatrics and Neonatology', 'name' => 'Department of Pediatrics and Neonatology'],
            ['id' => 'Department of Pharmacology', 'name' => 'Department of Pharmacology'],
            ['id' => 'Department of Physiology', 'name' => 'Department of Physiology'],
            ['id' => 'Department of Public Health and Family Medicine', 'name' => 'Department of Public Health and Family Medicine'],
            ['id' => 'Department of Surgery and Anesthesia', 'name' => 'Department of Surgery and Anesthesia'],
        ];

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

        // Create or update student profile
        auth()->user()->studentProfile()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'student_id' => $this->student_id,
                'course' => $this->department,
                'year' => 1, // Default to first year, can be enhanced later
                'bio' => $this->about_me,
                'skills' => $this->skills,
                'cv_path' => $cvPath,
                'available_for_hire' => true,
            ]
        );

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
                <!-- Student ID -->
                <x-input label="Student ID" wire:model="student_id" icon="o-identification" placeholder="e.g. 190000X"
                    class="uppercase" />

                <!-- Department -->
                <x-select label="Department" wire:model="department" icon="o-academic-cap" :options="$departmentsList"
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