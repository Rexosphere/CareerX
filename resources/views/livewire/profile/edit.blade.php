<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;

new class extends Component {
    use WithFileUploads;

    public $user;
    public $profile;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|max:1000')]
    public string $bio = '';

    #[Validate('nullable|image|max:1024')] // 1MB Max
    public $photo;

    #[Validate('nullable|file|mimes:pdf|max:5120')] // 5MB Max PDF
    public $cv_file;

    public array $skills = [];
    public string $newSkill = '';

    public function mount(): void
    {
        $this->user = auth()->user();
        // Ensure profile exists or create a blank one
        $this->profile = $this->user->studentProfile()->firstOrCreate([
            'user_id' => $this->user->id
        ]);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->profile->phone ?? '';
        $this->bio = $this->profile->bio ?? '';
        $this->skills = $this->profile->skills ?? [];
    }

    public function addSkill(): void
    {
        $this->validate(['newSkill' => 'required|string|min:2']);

        if (!in_array($this->newSkill, $this->skills)) {
            $this->skills[] = $this->newSkill;
        }
        $this->newSkill = '';
    }

    public function removeSkill(int $index): void
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function deleteCV(): void
    {
        if ($this->profile->cv_path) {
            // Delete the file from storage
            \Storage::disk('public')->delete($this->profile->cv_path);

            // Update the profile
            $this->profile->update(['cv_path' => null]);

            session()->flash('message', 'CV deleted successfully.');
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $photoPath = $this->profile->profile_photo_path;
        if ($this->photo) {
            $photoPath = $this->photo->store('profile-photos', 'public');
        }

        $cvPath = $this->profile->cv_path;
        if ($this->cv_file) {
            // Delete old CV if exists
            if ($cvPath) {
                \Storage::disk('public')->delete($cvPath);
            }
            // Store new CV
            $cvPath = $this->cv_file->store('cvs', 'public');
        }

        $this->profile->update([
            'phone' => $this->phone,
            'bio' => $this->bio,
            'skills' => $this->skills,
            'profile_photo_path' => $photoPath,
            'cv_path' => $cvPath,
        ]);

        // Reset the file input
        $this->cv_file = null;

        session()->flash('message', 'Profile updated successfully.');
    }
}; ?>

<div class="space-y-6">
    <!-- Profile Header & Avatar -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body flex-row items-center gap-6">
            <div class="relative group">
                <div class="avatar placeholder">
                    <div
                        class="bg-neutral text-neutral-content rounded-full w-24 h-24 ring ring-primary ring-offset-base-100 ring-offset-2">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt="Profile" />
                        @elseif ($profile->profile_photo_path)
                            <img src="{{ Storage::url($profile->profile_photo_path) }}" alt="Profile" />
                        @else
                            <span class="text-3xl font-bold">{{ strtoupper(substr($name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
                <!-- Photo Upload Trigger -->
                <label class="absolute bottom-0 right-0 btn btn-circle btn-xs btn-primary cursor-pointer shadow-lg"
                    for="photo-upload">
                    <x-icon name="o-camera" class="w-3 h-3" />
                </label>
                <input type="file" id="photo-upload" wire:model="photo" class="hidden" accept="image/*" />
            </div>

            <div>
                <h2 class="card-title text-2xl">{{ $name }}</h2>
                <p class="text-base-content/60">{{ $email }}</p>
                @if($profile->student_id)
                    <div class="badge badge-outline mt-2">{{ $profile->student_id }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4">Basic Information</h3>
                    <form wire:submit="save" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Full Name" wire:model="name" icon="o-user" />
                            <x-input label="Email Address" wire:model="email" icon="o-envelope" />
                            <x-input label="Contact Number" wire:model="phone" icon="o-phone"
                                placeholder="+94 7X XXX XXXX" />
                        </div>

                        <x-textarea label="Bio" wire:model="bio" placeholder="Tell us a little about yourself..."
                            rows="3" />

                        <div class="flex justify-end pt-2">
                            <x-button label="Save Changes" class="btn-primary" type="submit" spinner="save" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4">Skills & Expertise</h3>

                    <!-- Add Skill Form -->
                    <div class="flex gap-2 items-end mb-6">
                        <div class="flex-1">
                            <x-input label="Add New Skill" wire:model="newSkill" placeholder="e.g. Project Management"
                                wire:keydown.enter="addSkill" />
                        </div>
                        <x-button icon="o-plus" class="btn-primary" wire:click="addSkill" spinner="addSkill" />
                    </div>

                    <!-- Skills Table/List -->
                    @if(count($skills) > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra bg-base-200/50 rounded-lg">
                                <thead>
                                    <tr>
                                        <th class="w-full">Skill Name</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($skills as $index => $skill)
                                        <tr>
                                            <td class="font-medium">{{ $skill }}</td>
                                            <td class="text-right">
                                                <button wire:click="removeSkill({{ $index }})"
                                                    class="btn btn-ghost btn-sm text-error">
                                                    <x-icon name="o-trash" class="w-4 h-4" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div
                            class="text-center py-6 text-base-content/50 bg-base-200/30 rounded-lg border border-dashed border-base-300">
                            No skills added yet. Add your top skills above!
                        </div>
                    @endif
                </div>
            </div>

            <!-- CV Upload Section -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4">Resume / CV</h3>

                    <!-- Existing CV Display - Only show when CV exists and no new file selected -->
                    @if($profile->cv_path && !$cv_file)
                        <div class="alert alert-info">
                            <x-icon name="o-document-text" class="w-6 h-6" />
                            <div class="flex-1">
                                <p class="font-medium">Current CV</p>
                                <p class="text-xs opacity-70">Your CV is uploaded and ready</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ Storage::url($profile->cv_path) }}" target="_blank"
                                    class="btn btn-sm btn-ghost gap-2">
                                    <x-icon name="o-eye" class="w-4 h-4" />
                                    View
                                </a>
                                <button wire:click="deleteCV" wire:confirm="Are you sure you want to delete your CV?"
                                    class="btn btn-sm btn-ghost text-error gap-2">
                                    <x-icon name="o-trash" class="w-4 h-4" />
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- CV File Upload - Only show when no CV exists OR when user wants to replace -->
                    @if(!$profile->cv_path || $cv_file)
                        <div class="w-full">
                            <x-file wire:model="cv_file" accept="application/pdf" hint="Max file size: 5MB. PDF only."
                                class="w-full text-center">
                                <div class="flex flex-col w-full h-full items-center justify-center py-8">
                                    <div class="mb-3 rounded-full bg-primary/10 p-3 mx-auto">
                                        <x-icon name="o-cloud-arrow-up" class="w-8 h-8 text-primary" />
                                    </div>
                                    <div class="text-center w-full">
                                        <p class="text-sm font-medium">
                                            <span class="text-primary font-bold hover:underline cursor-pointer">
                                                Click to browse
                                            </span>
                                            <span class="opacity-70">or drag CV here</span>
                                        </p>
                                    </div>
                                </div>
                            </x-file>

                            <!-- New CV Preview -->
                            @if ($cv_file)
                                <div class="mt-4 alert alert-success">
                                    <x-icon name="o-document-duplicate" class="w-5 h-5" />
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $cv_file->getClientOriginalName() }}</p>
                                        <p class="text-xs opacity-70">
                                            {{ number_format($cv_file->getSize() / 1024 / 1024, 1) }} MB
                                            @if($profile->cv_path)
                                                - Will replace existing CV when saved
                                            @endif
                                        </p>
                                    </div>
                                    <button wire:click="$set('cv_file', null)" type="button"
                                        class="btn btn-ghost btn-sm btn-circle">
                                        <x-icon name="o-x-mark" class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Save Button for CV -->
                                <div class="flex justify-end pt-2 mt-2 border-t border-base-300">
                                    <x-button label="Save CV" class="btn-primary" wire:click="save" spinner="save" />
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar / Tips -->
        <div class="space-y-6">
            <div class="card bg-primary/5 border border-primary/10 shadow-sm">
                <div class="card-body">
                    <h3 class="font-bold text-primary flex items-center gap-2">
                        <x-icon name="o-light-bulb" class="w-5 h-5" />
                        Profile Tips
                    </h3>
                    <ul class="list-disc list-inside text-sm space-y-2 text-base-content/80 mt-2">
                        <li>Keep your contact details up to date so recruiters can reach you.</li>
                        <li>Add specific technical and soft skills to stand out.</li>
                        <li>A professional profile picture increases visibility.</li>
                        <li>Upload your latest CV to make it easy for employers to review your qualifications.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-toast />
</div>