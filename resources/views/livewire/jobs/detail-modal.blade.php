<?php
use Livewire\Volt\Component;

new class extends Component {
    public ?int $jobId = null;
    public bool $showModal = false;

    #[Livewire\Attributes\On('open-job-modal')]
    public function openModal(int $jobId): void
    {
        $this->jobId = $jobId;
        $this->showModal = true;
    }

    public function with(): array
    {
        if (!$this->jobId) {
            return ['job' => null];
        }

        $job = \App\Models\JobPosting::with('company')->find($this->jobId);

        if (!$job) {
            return ['job' => null];
        }

        // Use current company logo from profile if available, otherwise fall back to stored logo or avatar
        $logo = null;
        if ($job->company && $job->company->logo_path) {
            $logo = asset('storage/' . $job->company->logo_path);
        } elseif ($job->company_logo) {
            $logo = $job->company_logo;
        } else {
            $logo = 'https://ui-avatars.com/api/?name=' . urlencode($job->company_name);
        }

        // Check if user has already applied
        $hasApplied = false;
        $applicationStatus = null;
        if (auth('web')->check() && auth('web')->user()->isStudent()) {
            $application = auth('web')->user()->applications()
                ->where('job_id', $this->jobId)
                ->first();
            
            if ($application) {
                $hasApplied = true;
                $applicationStatus = $application->status;
            }
        }

        $jobDetails = [
            'id' => $job->id,
            'title' => $job->title,
            'company' => $job->company_name,
            'companyWebsite' => '#', // Can add to company profile later
            'logo' => $logo,
            'location' => $job->location,
            'salary' => $job->salary_range ?? 'Negotiable',
            'postedDays' => (int) $job->created_at->diffInDays(),
            'type' => $job->type,
            'workMode' => 'On-site', // Default for now
            'preferredDept' => $job->category,
            'deadline' => $job->application_deadline instanceof \Carbon\Carbon ? $job->application_deadline->format('M d, Y') : 'No deadline',
            'about' => $job->description,
            'prerequisites' => $job->prerequisites,
            'responsibilities' => [], // Can be extracted from description if structured
            'requirements' => is_array($job->requirements) ? $job->requirements : [],
            'hasApplied' => $hasApplied,
            'applicationStatus' => $applicationStatus,
        ];

        return [
            'job' => $jobDetails,
        ];
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->jobId = null;
    }

    // ... rest of the methods

    public function saveJob(): void
    {
        if (!auth()->check()) {
            session()->flash('error', 'Please login to save jobs.');
            $this->redirectRoute('login');
            return;
        }

        $job = \App\Models\JobPosting::find($this->jobId);

        if (!$job) {
            session()->flash('error', 'Job not found.');
            return;
        }

        // Toggle save/unsave
        $existingSave = auth()->user()->savedJobs()
            ->where('job_posting_id', $this->jobId)
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            session()->flash('message', 'Job removed from saved jobs.');
        } else {
            auth()->user()->savedJobs()->create([
                'job_posting_id' => $this->jobId,
            ]);
            session()->flash('message', 'Job saved successfully!');
        }

        $this->dispatch('job-saved');
    }

    public function applyNow(): void
    {
        // Check if user is logged in as a student
        if (!auth('web')->check() || !auth('web')->user()->isStudent()) {
            session()->flash('error', 'Please login as a student to apply.');
            $this->redirectRoute('login');
            return;
        }

        $job = \App\Models\JobPosting::find($this->jobId);

        if (!$job) {
            session()->flash('error', 'Job not found.');
            return;
        }

        if (!$job->isOpen()) {
            session()->flash('error', 'This job is no longer accepting applications.');
            return;
        }

        // Check if already applied
        $existingApplication = auth()->user()->applications()
            ->where('job_id', $this->jobId)
            ->first();

        if ($existingApplication) {
            session()->flash('error', 'You have already applied for this job.');
            return;
        }

        // Create application
        auth()->user()->applications()->create([
            'job_id' => $this->jobId,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Application submitted successfully!');
        $this->closeModal();
        $this->dispatch('application-submitted', jobId: $this->jobId);
    }
}; ?>

<div>
    @if($showModal)
        <!-- Modal Overlay -->
        <div class="modal modal-open">
            <div class="modal-box max-w-3xl max-h-[90vh] p-0 overflow-hidden">
                <!-- Sticky Header -->
                <div
                    class="sticky top-0 z-10 flex items-center justify-between border-b border-base-300 px-6 py-4 bg-base-100/95 backdrop-blur">
                    <h2 class="text-xl font-bold pr-4 truncate">
                        {{ $job['title'] }}
                    </h2>
                    <button wire:click="closeModal" class="btn btn-ghost btn-circle btn-sm">
                        <x-icon name="o-x-mark" class="w-6 h-6" />
                    </button>
                </div>

                <!-- Scrollable Body -->
                <div class="overflow-y-auto max-h-[calc(90vh-180px)] p-6 md:p-8">
                    <!-- Hero Section -->
                    <div class="flex flex-col gap-6 md:flex-row md:items-start mb-8">
                        <!-- Logo -->
                        <div class="shrink-0">
                            <div
                                class="w-20 h-20 overflow-hidden rounded-xl border border-base-300 bg-base-100 shadow-sm flex items-center justify-center">
                                <img src="{{ $job['logo'] }}" alt="{{ $job['company'] }} Logo"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="flex flex-col flex-1 gap-2">
                            <div>
                                <h3 class="text-2xl font-bold">{{ $job['company'] }}</h3>
                                <a href="{{ $job['companyWebsite'] }}" target="_blank"
                                    class="link link-primary text-sm font-medium">
                                    Visit Website <x-icon name="o-arrow-top-right-on-square" class="w-4 h-4" />
                                </a>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-base-content/70 text-sm mt-1">
                                <div class="flex items-center gap-1">
                                    <x-icon name="o-map-pin" class="text-primary w-5 h-5" />
                                    <span>{{ $job['location'] }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <x-icon name="o-currency-dollar" class="text-primary w-5 h-5" />
                                    <span>{{ $job['salary'] }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <x-icon name="o-clock" class="text-primary w-5 h-5" />
                                    <span>Posted {{ $job['postedDays'] }} days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Badges -->
                    <div class="flex flex-wrap gap-2 mb-8 pb-8 border-b border-base-300">
                        <div class="badge badge-primary gap-2">
                            <x-icon name="o-briefcase" class="w-4 h-4" />
                            {{ $job['type'] }}
                        </div>
                        <div class="badge badge-primary gap-2">
                            <x-icon name="o-building-office" class="w-4 h-4" />
                            {{ $job['workMode'] }}
                        </div>
                        <div class="badge badge-success gap-2">
                            <x-icon name="o-academic-cap" class="w-4 h-4" />
                            {{ $job['preferredDept'] }}
                        </div>
                        @if($job['hasApplied'])
                            <div class="badge badge-success gap-2">
                                <x-icon name="o-check-circle" class="w-4 h-4" />
                                Applied ({{ ucfirst($job['applicationStatus']) }})
                            </div>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <div class="space-y-8 text-base-content/70">
                        <!-- About -->
                        <div>
                            <h4 class="text-lg font-bold mb-3 flex items-center gap-2 text-base-content">
                                <x-icon name="o-information-circle" class="text-primary w-6 h-6" />
                                About the Role
                            </h4>
                            <p class="leading-relaxed whitespace-pre-line">{{ $job['about'] }}</p>
                        </div>

                        <!-- Prerequisites -->
                        @if(!empty($job['prerequisites']))
                            <div>
                                <h4 class="text-lg font-bold mb-3 flex items-center gap-2 text-base-content">
                                    <x-icon name="o-exclamation-circle" class="text-primary w-6 h-6" />
                                    Prerequisites
                                </h4>
                                <p class="leading-relaxed whitespace-pre-line">{{ $job['prerequisites'] }}</p>
                            </div>
                        @endif

                        <!-- Responsibilities -->
                        @if(!empty($job['responsibilities']))
                            <div>
                                <h4 class="text-lg font-bold mb-3 flex items-center gap-2 text-base-content">
                                    <x-icon name="o-clipboard-document-check" class="text-primary w-6 h-6" />
                                    Key Responsibilities
                                </h4>
                                <ul class="space-y-3 pl-1">
                                    @foreach($job['responsibilities'] as $responsibility)
                                        <li class="flex items-start gap-3">
                                            <x-icon name="o-check-circle" class="text-primary w-5 h-5 mt-0.5" />
                                            <span class="leading-relaxed">{{ $responsibility }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Requirements -->
                        @if(!empty($job['requirements']))
                            <div>
                                <h4 class="text-lg font-bold mb-3 flex items-center gap-2 text-base-content">
                                    <x-icon name="o-shield-check" class="text-primary w-6 h-6" />
                                    Requirements
                                </h4>
                                <ul class="space-y-3 pl-1">
                                    @foreach($job['requirements'] as $requirement)
                                        <li class="flex items-start gap-3">
                                            <span class="w-1.5 h-1.5 rounded-full bg-base-content/40 mt-2.5 shrink-0"></span>
                                            <span class="leading-relaxed">{{ $requirement }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sticky Footer -->
                <div
                    class="sticky bottom-0 z-10 border-t border-base-300 bg-base-200 p-4 sm:px-8 sm:py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="hidden sm:flex flex-col">
                        <span class="text-sm text-base-content/70">Application deadline:</span>
                        <span class="text-sm font-semibold">{{ $job['deadline'] }}</span>
                    </div>
                    <div class="flex w-full sm:w-auto gap-3">
                        @if(auth('web')->user()?->isStudent())
                            <button wire:click="saveJob" class="btn btn-outline gap-2 flex-1 sm:flex-none">
                                <x-icon name="o-bookmark" class="w-5 h-5" />
                                Save
                            </button>
                        @endif

                        @if($job['hasApplied'])
                            <button disabled class="btn btn-success btn-outline gap-2 flex-1 sm:flex-none shadow-sm opacity-60 cursor-not-allowed">
                                <x-icon name="o-check-circle" class="w-5 h-5" />
                                Already Applied
                            </button>
                        @else
                            <button wire:click="applyNow" class="btn btn-primary gap-2 flex-1 sm:flex-none shadow-sm">
                                Apply Now
                                <x-icon name="o-arrow-right" class="w-5 h-5" />
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button wire:click="closeModal">close</button>
            </form>
        </div>
    @endif
</div>