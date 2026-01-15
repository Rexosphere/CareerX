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
                                        <div class="font-bold">{{ $application->student->name }}</div>
                                        <div class="text-xs opacity-60">{{ $application->student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="text-sm opacity-70">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs opacity-50">{{ $application->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-4">
                                <span class="badge badge-sm badge-outline">{{ ucfirst($application->status) }}</span>
                            </td>
                            <td class="text-right pr-6 py-4">
                                @if($application->student->studentProfile?->cv_path)
                                    <a href="{{ route('cv.download.application', $application->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline btn-primary">
                                        View CV
                                    </a>
                                @else
                                    <span class="text-xs opacity-50 italic">No CV uploaded</span>
                                @endif
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