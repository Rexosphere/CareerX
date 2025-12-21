<?php
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        // Mock data - replace with actual database queries
        return [
            'stats' => [
                [
                    'title' => 'Active Applications',
                    'value' => '12',
                    'change' => '+12% vs last week',
                    'changeType' => 'positive',
                    'icon' => 'document-text',
                    'iconBg' => 'bg-info/10 text-info',
                ],
                [
                    'title' => 'Active Job Postings',
                    'value' => '5',
                    'change' => 'Same as last week',
                    'changeType' => 'neutral',
                    'icon' => 'briefcase',
                    'iconBg' => 'bg-secondary/10 text-secondary',
                ],
                [
                    'title' => 'Candidates Viewed',
                    'value' => '48',
                    'change' => '+24% vs last week',
                    'changeType' => 'positive',
                    'icon' => 'eye',
                    'iconBg' => 'bg-warning/10 text-warning',
                ],
            ],
            'recentJobs' => [
                ['title' => 'Software Engineer Intern', 'status' => 'Active', 'applicants' => 24, 'statusColor' => 'badge-success'],
                ['title' => 'UI/UX Designer', 'status' => 'Pending', 'applicants' => 0, 'statusColor' => 'badge-warning'],
                ['title' => 'Data Analyst', 'status' => 'Closed', 'applicants' => 15, 'statusColor' => 'badge-neutral'],
            ],
            'recentApplications' => [
                ['name' => 'Amara Silva', 'job' => 'Software Engineer', 'date' => 'Oct 24', 'status' => 'New', 'statusColor' => 'badge-info'],
                ['name' => 'Kasun Perera', 'job' => 'Data Analyst', 'date' => 'Oct 22', 'status' => 'Reviewed', 'statusColor' => 'badge-secondary'],
                ['name' => 'Nimali De Silva', 'job' => 'Software Engineer', 'date' => 'Oct 20', 'status' => 'Rejected', 'statusColor' => 'badge-neutral'],
            ],
        ];
    }
}; ?>

<div class="space-y-10">
    <!-- Stats Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($stats as $stat)
            <div class="card bg-base-100 shadow-sm border border-base-300 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 rounded-lg {{ $stat['iconBg'] }}">
                            <x-icon :name="'o-' . $stat['icon']" class="w-6 h-6" />
                        </div>
                        <span class="badge badge-sm {{ $stat['changeType'] === 'positive' ? 'badge-success' : 'badge-ghost' }}">
                            {{ $stat['change'] }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold mb-1">{{ $stat['value'] }}</h3>
                        <p class="text-base-content/70 font-medium text-sm">{{ $stat['title'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Job Postings -->
        <div class="card bg-base-100 shadow-sm border border-base-300 overflow-hidden">
            <div class="card-body p-0">
                <div class="p-6 border-b border-base-300 flex justify-between items-center">
                    <h2 class="text-lg font-bold">Recent Job Postings</h2>
                    <a href="#" class="link link-primary text-sm font-medium">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr class="bg-base-200/50">
                                <th class="text-xs uppercase font-semibold">Job Title</th>
                                <th class="text-xs uppercase font-semibold">Status</th>
                                <th class="text-xs uppercase font-semibold">Applicants</th>
                                <th class="text-xs uppercase font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentJobs as $job)
                                <tr class="hover">
                                    <td class="font-medium">{{ $job['title'] }}</td>
                                    <td>
                                        <span class="badge {{ $job['statusColor'] }} badge-sm">
                                            {{ $job['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2 text-base-content/70">
                                            <x-icon name="o-users" class="w-4 h-4" />
                                            {{ $job['applicants'] }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button class="btn btn-ghost btn-xs" title="Edit">
                                                <x-icon name="o-pencil-square" class="w-4 h-4" />
                                            </button>
                                            <button class="btn btn-ghost btn-xs text-error" title="Delete">
                                                <x-icon name="o-trash" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="card bg-base-100 shadow-sm border border-base-300 overflow-hidden">
            <div class="card-body p-0">
                <div class="p-6 border-b border-base-300 flex justify-between items-center">
                    <h2 class="text-lg font-bold">Recent Applications</h2>
                    <a href="#" class="link link-primary text-sm font-medium">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr class="bg-base-200/50">
                                <th class="text-xs uppercase font-semibold">Student Name</th>
                                <th class="text-xs uppercase font-semibold">Job</th>
                                <th class="text-xs uppercase font-semibold">Date</th>
                                <th class="text-xs uppercase font-semibold">Status</th>
                                <th class="text-xs uppercase font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $application)
                                <tr class="hover">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                    <span class="text-xs">{{ substr($application['name'], 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="font-medium">{{ $application['name'] }}</div>
                                        </div>
                                    </td>
                                    <td class="text-base-content/70">{{ $application['job'] }}</td>
                                    <td class="text-base-content/70">{{ $application['date'] }}</td>
                                    <td>
                                        <span class="badge {{ $application['statusColor'] }} badge-sm">
                                            {{ $application['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-primary btn-outline btn-xs">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
