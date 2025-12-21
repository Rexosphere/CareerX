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
            'about' => 'A passionate engineering student with a focus on structural analysis and project management. Eager to apply academic knowledge in a practical environment. I have a strong foundation in mathematics and physics, coupled with hands-on experience in CAD software and material testing. I am looking for internship opportunities where I can contribute to meaningful infrastructure projects while learning from experienced professionals.',
            'skills' => ['AutoCAD', 'Revit', 'Structural Analysis', 'Python', 'Project Management', 'Public Speaking', 'Civil 3D', 'MATLAB'],
            'experience' => [
                [
                    'title' => 'Intern Civil Engineer',
                    'company' => 'Maga Engineering (Pvt) Ltd',
                    'period' => 'Jan 2023 - Present',
                    'description' => 'Assisting in site supervision and quality control for the new City Center complex. Collaborating with senior engineers to review structural drawings and coordinate with subcontractors.',
                    'type' => 'work'
                ],
                [
                    'title' => 'Secretary',
                    'company' => 'Civil Engineering Society',
                    'period' => 'May 2022 - May 2023',
                    'description' => 'Organized the annual "Construct 2023" exhibition, managing a team of 50 volunteers. Coordinated logistics and sponsorships, resulting in a 20% increase in attendee participation.',
                    'type' => 'volunteer'
                ],
                [
                    'title' => 'Sustainable Bridge Design Project',
                    'company' => 'Academic Project',
                    'period' => 'Aug 2022 - Dec 2022',
                    'description' => 'Designed a mock eco-friendly pedestrian bridge using recycled materials. Conducted load testing simulations in AutoCAD and presented findings on cost-effectiveness and environmental impact.',
                    'type' => 'project'
                ],
            ],
            'education' => [
                [
                    'institution' => 'University of Moratuwa',
                    'degree' => 'BSc (Hons) in Civil Engineering',
                    'period' => 'Expected 2025',
                    'details' => 'Specializing in Structural Engineering. Current GPA: 3.8/4.0',
                    'logo' => true
                ],
                [
                    'institution' => 'Royal College, Colombo',
                    'degree' => 'GCE Advanced Level',
                    'period' => '2019',
                    'details' => 'Physical Science Stream - 3 As',
                    'logo' => false
                ],
            ],
            'social' => [
                'linkedin' => '#',
                'email' => '#',
                'github' => '#',
            ]
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
                    <span>Connect</span>
                </button>
                <button class="btn btn-outline gap-2 min-w-[140px]">
                    <x-icon name="o-arrow-down-tray" class="w-5 h-5" />
                    <span>Download CV</span>
                </button>
            </div>

            {{-- Contact Links --}}
            <div class="flex items-center gap-6 mt-2 pt-4 border-t border-base-300 w-full justify-center">
                <a href="{{ $student['social']['linkedin'] }}" class="text-base-content/60 hover:text-info transition-colors flex items-center gap-2 text-sm font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    <span>LinkedIn</span>
                </a>
                <a href="mailto:{{ $student['social']['email'] }}" class="text-base-content/60 hover:text-error transition-colors flex items-center gap-2 text-sm font-medium">
                    <x-icon name="o-envelope" class="w-5 h-5" />
                    <span>Email</span>
                </a>
                <a href="{{ $student['social']['github'] }}" class="text-base-content/60 hover:text-base-content transition-colors flex items-center gap-2 text-sm font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    <span>GitHub</span>
                </a>
            </div>
        </div>
    </div>

    {{-- About Section --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6 md:p-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-primary/10 text-primary p-2 rounded-lg">
                    <x-icon name="o-user" class="w-5 h-5" />
                </div>
                <h2 class="card-title">About Me</h2>
            </div>
            <p class="text-base leading-relaxed">{{ $student['about'] }}</p>
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

    {{-- Experience & Projects Section --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-primary/10 text-primary p-2 rounded-lg">
                    <x-icon name="o-briefcase" class="w-5 h-5" />
                </div>
                <h2 class="card-title">Experience & Projects</h2>
            </div>
            <div class="flex flex-col gap-6">
                @foreach($student['experience'] as $index => $exp)
                    <div class="flex flex-col sm:flex-row gap-4 items-start {{ $index < count($student['experience']) - 1 ? 'pb-6 border-b border-base-300' : '' }}">
                        {{-- Icon --}}
                        <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-lg bg-base-200 text-base-content/60 shrink-0">
                            @if($exp['type'] === 'work')
                                <x-icon name="o-building-office" class="w-6 h-6" />
                            @elseif($exp['type'] === 'volunteer')
                                <x-icon name="o-users" class="w-6 h-6" />
                            @else
                                <x-icon name="o-academic-cap" class="w-6 h-6" />
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <h3 class="text-lg font-bold">{{ $exp['title'] }}</h3>
                                <span class="text-sm text-base-content/60 font-medium">{{ $exp['period'] }}</span>
                            </div>
                            <p class="text-sm text-primary font-semibold mb-2">{{ $exp['company'] }}</p>
                            <p class="text-sm text-base-content/70 leading-relaxed">{{ $exp['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Education Section --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-primary/10 text-primary p-2 rounded-lg">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                </div>
                <h2 class="card-title">Education</h2>
            </div>
            <div class="flex flex-col gap-6">
                @foreach($student['education'] as $index => $edu)
                    <div class="flex flex-col sm:flex-row gap-4 items-start {{ $index < count($student['education']) - 1 ? 'pb-6 border-b border-base-300' : '' }}">
                        {{-- Logo/Icon --}}
                        <div class="flex items-center justify-center w-14 h-14 rounded-lg {{ $edu['logo'] ? 'bg-base-100 border border-base-300 p-1' : 'bg-base-200 text-base-content/60' }} shrink-0 overflow-hidden">
                            @if($edu['logo'])
                                <div class="w-full h-full bg-contain bg-center bg-no-repeat" style="background-image: url('https://ui-avatars.com/api/?name=UoM&background=0d9ef2&color=fff&size=56')"></div>
                            @else
                                <x-icon name="o-book-open" class="w-7 h-7" />
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <h3 class="text-lg font-bold">{{ $edu['institution'] }}</h3>
                                <span class="text-sm text-base-content/60 font-medium">{{ $edu['period'] }}</span>
                            </div>
                            <p class="text-sm text-primary font-semibold">{{ $edu['degree'] }}</p>
                            <p class="text-sm text-base-content/70 mt-1">{{ $edu['details'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
