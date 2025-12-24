<?php

use Livewire\Volt\Component;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public string $title = '';
    public string $category = '';
    public string $type = 'Full-time';
    public string $location = '';
    public string $salary_range = '';
    public string $description = '';
    public string $prerequisites = '';
    public $application_deadline;

    public function create()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string|min:20',
            'prerequisites' => 'nullable|string',
            'application_deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $company = Auth::guard('company')->user();

        JobPosting::create([
            'company_id' => $company->id,
            'company_name' => $company->name,
            'company_logo' => $company->logo_path,
            'title' => $this->title,
            'category' => $this->category,
            'type' => $this->type,
            'location' => $this->location,
            'salary_range' => $this->salary_range,
            'description' => $this->description,
            'prerequisites' => $this->prerequisites,
            'application_deadline' => $this->application_deadline,
            'is_active' => true,
        ]);

        session()->flash('message', 'Job posting created successfully!');
        $this->redirectRoute('company.profile', navigate: true);
    }
}; ?>

<div class="card bg-base-100 shadow-2xl border border-base-200 overflow-hidden">
    {{-- Decorative Header --}}
    <div class="bg-primary/5 p-8 border-b border-base-200 relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-2xl font-black tracking-tight text-base-content flex items-center gap-3">
                <div
                    class="bg-primary h-[40px] w-[40px] flex items-center justify-center text-primary-content p-1 rounded-xl">
                    <x-icon name="o-briefcase" class="" />
                </div>
                Job Opportunity Details
            </h3>
            <p class="text-base-content/60 mt-2 font-medium">Define the role and requirements to attract the best
                candidates.</p>
        </div>
        {{-- Abstract background shapes --}}
        <!-- <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div> -->
    </div>

    <div class="card-body px-8 sm:p-10">
        <form wire:submit="create" class="space-y-10">
            {{-- Section 1: Basic Info --}}
            <div class="space-y-6">

                <div class="grid grid-cols-1 gap-6">
                    <x-input label="Job Title" wire:model="title" placeholder="e.g. Senior Full Stack Developer"
                        icon="o-pencil-square" class="input-lg font-bold" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-select label="Category" wire:model="category" icon="o-tag" :options="[
        ['id' => 'Software Engineering', 'name' => 'Software Engineering'],
        ['id' => 'Data Science & AI', 'name' => 'Data Science & AI'],
        ['id' => 'Product Management', 'name' => 'Product Management'],
        ['id' => 'Design', 'name' => 'Design'],
        ['id' => 'Marketing', 'name' => 'Marketing'],
        ['id' => 'Engineering', 'name' => 'Engineering'],
        ['id' => 'Finance', 'name' => 'Finance'],
        ['id' => 'Other', 'name' => 'Other']
    ]" placeholder="Select a category" />

                        <x-select label="Employment Type" wire:model="type" icon="o-clock" :options="[
        ['id' => 'Full-time', 'name' => 'Full-time'],
        ['id' => 'Part-time', 'name' => 'Part-time'],
        ['id' => 'Contract', 'name' => 'Contract'],
        ['id' => 'Internship', 'name' => 'Internship'],
        ['id' => 'Freelance', 'name' => 'Freelance']
    ]" />
                    </div>
                </div>
            </div>


            {{-- Section 2: Logistics --}}
            <div class="space-y-6">


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input label="Work Location" wire:model="location" placeholder="e.g. Remote or Moratuwa, SL"
                        icon="o-map-pin" />

                    <x-input label="Salary Range (Optional)" wire:model="salary_range"
                        placeholder="e.g. LKR 150k - 250k" icon="o-banknotes" />

                    <x-datepicker label="Application Deadline" wire:model="application_deadline" icon="o-calendar"
                        placeholder="Select date" />
                </div>
            </div>


            {{-- Section 3: The Pitch --}}
            <div class="space-y-6">


                <x-textarea label="Job Description" wire:model="description"
                    placeholder="Describe the role, responsibilities, and ideal candidate profile..." rows="12"
                    class="text-base leading-relaxed" hint="Markdown is supported for formatting." />

                <x-textarea label="Prerequisites" wire:model="prerequisites"
                    placeholder="List any prerequisites or basic requirements..." rows="6"
                    class="text-base leading-relaxed" />
            </div>

            {{-- Action Buttons --}}
            <div class="pt-8 border-t border-base-200 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('company.profile') }}" class="btn btn-ghost px-8">
                    Discard Changes
                </a>
                <x-button label="Publish Job Listing" type="submit"
                    class="btn-primary px-12 shadow-lg shadow-primary/20" spinner="create" />
            </div>
        </form>
    </div>
</div>