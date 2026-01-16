@php
    $statusColors = [
        'pending' => 'badge-warning',
        'reviewed' => 'badge-info',
        'shortlisted' => 'badge-purple',
        'rejected' => 'badge-error',
        'accepted' => 'badge-success',
    ];
@endphp

<div class="bg-base-100 border border-base-200 shadow-sm rounded-xl overflow-hidden">
    <div class="p-6 border-b border-base-200 bg-base-50/50 flex items-center justify-between">
        <h3 class="font-bold text-lg flex items-center gap-2">
            <x-icon name="o-users" class="w-5 h-5 text-primary" />
            Received Applications
        </h3>
        @if($applications->count() > 0 && $applications->filter(fn($app) => $app->student->studentProfile?->cv_path)->count() > 0)
            <a href="{{ route('cv.download.bulk', $job->id) }}" 
                class="btn btn-primary btn-sm gap-2">
                <x-icon name="o-arrow-down-tray" class="w-4 h-4" />
                Download All CVs
            </a>
        @endif
    </div>

    {{-- Success/Error Messages --}}
    @if(session('message'))
        <div class="alert alert-success mx-6 mt-4">
            <x-icon name="o-check-circle" class="w-5 h-5" />
            <span>{{ session('message') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error mx-6 mt-4">
            <x-icon name="o-x-circle" class="w-5 h-5" />
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($applications->count() > 0)
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200/50 text-base-content/70 uppercase text-xs font-bold">
                    <tr>
                        <th class="pl-6 py-4">Applicant</th>
                        <th class="py-4">Applied Date</th>
                        <th class="py-4">Status</th>
                        <th class="text-right pr-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-base divide-y divide-base-200">
                    @foreach($applications as $application)
                        <tr class="hover:bg-base-200/50 transition-colors">
                            <td class="pl-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-neutral text-neutral-content rounded-full w-10">
                                            <span class="text-xs">{{ substr($application->student->name, 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('students.profile', $application->student->id) }}" class="font-bold hover:underline text-primary" target="_blank">{{ $application->student->name }}</a>
                                        <div class="text-xs opacity-60">{{ $application->student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="text-sm opacity-70">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs opacity-50">{{ $application->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-4">
                                <div class="dropdown">
                                    <label tabindex="0" class="badge {{ $statusColors[$application->status] ?? 'badge-ghost' }} badge-lg gap-2 cursor-pointer hover:opacity-80">
                                        {{ ucfirst($application->status) }}
                                        <x-icon name="o-chevron-down" class="w-3 h-3" />
                                    </label>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200 mt-2">
                                        <li class="menu-title"><span>Change Status</span></li>
                                        @foreach(['pending', 'reviewed', 'shortlisted', 'accepted', 'rejected'] as $status)
                                            <li>
                                                <button 
                                                    wire:click="updateApplicationStatus({{ $application->id }}, '{{ $status }}')"
                                                    class="{{ $application->status === $status ? 'active' : '' }}"
                                                    wire:loading.attr="disabled"
                                                    wire:target="updateApplicationStatus({{ $application->id }}, '{{ $status }}')"
                                                >
                                                    <span class="badge {{ $statusColors[$status] ?? 'badge-ghost' }} badge-sm"></span>
                                                    {{ ucfirst($status) }}
                                                    @if($application->status === $status)
                                                        <x-icon name="o-check" class="w-4 h-4 ml-auto" />
                                                    @endif
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            <td class="text-right pr-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($application->student->studentProfile?->cv_path)
                                        <a href="{{ route('cv.download.application', $application->id) }}" target="_blank"
                                            class="btn btn-sm btn-outline btn-primary gap-2">
                                            <x-icon name="o-document-text" class="w-4 h-4" />
                                            View CV
                                        </a>
                                    @else
                                        <span class="text-xs opacity-50 italic">No CV uploaded</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($applications->hasPages())
            <div class="p-4 border-t border-base-200 bg-base-50/50">
                {{ $applications->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16 bg-base-50/50">
            <div class="w-16 h-16 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-icon name="o-inbox" class="w-8 h-8 text-base-content/30" />
            </div>
            <h3 class="font-bold text-lg mb-1">No Applications Yet</h3>
            <p class="text-base-content/60">Wait for candidates to apply for this position.</p>
        </div>
    @endif
</div>

<style>
    .badge-purple {
        @apply bg-purple-100 text-purple-800 border-purple-200;
    }
    .dark .badge-purple {
        @apply bg-purple-900/30 text-purple-300 border-purple-800;
    }
</style>