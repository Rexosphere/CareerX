<x-layouts.main title="Applicants">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Applicants</h1>
            <div class="flex gap-2">
                <!-- Search/Filter could go here -->
                <button class="btn btn-ghost btn-sm">
                    <x-icon name="o-funnel" class="w-5 h-5 mr-1" />
                    Filter
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
             @forelse($applicants as $applicant)
                 <div class="card bg-base-100 shadow-md border border-base-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                     <div class="card-body items-center text-center p-6">
                         <div class="avatar placeholder mb-4">
                             <div class="bg-primary/10 text-primary rounded-full w-24 ring ring-primary ring-offset-base-100 ring-offset-2">
                                 <span class="text-3xl font-bold">{{ $applicant->initials() }}</span>
                             </div>
                         </div>
                         <h2 class="card-title text-lg">{{ $applicant->name }}</h2>
                         <p class="text-sm text-base-content/70 mb-4">{{ $applicant->email }}</p>
                         
                         @if($applicant->studentProfile)
                             <div class="w-full bg-base-200/50 rounded-lg p-3 text-left text-sm space-y-2 mb-4">
                                 @if($applicant->studentProfile->course)
                                    <div class="flex items-start gap-2">
                                        <x-icon name="o-academic-cap" class="w-4 h-4 mt-0.5 opacity-70" />
                                        <span class="line-clamp-1" title="{{ $applicant->studentProfile->course }}">{{ $applicant->studentProfile->course }}</span>
                                    </div>
                                 @endif
                                 @if($applicant->studentProfile->year)
                                    <div class="flex items-start gap-2">
                                        <x-icon name="o-calendar" class="w-4 h-4 mt-0.5 opacity-70" />
                                        <span>Year {{ $applicant->studentProfile->year }}</span>
                                    </div>
                                 @endif
                             </div>
                         @else
                            <div class="w-full py-4 text-center text-xs text-base-content/50 italic mb-4">
                                No profile details available
                            </div>
                         @endif

                         <div class="card-actions justify-center w-full mt-auto">
                             <a href="{{ route('students.profile', $applicant->id) }}" class="btn btn-outline btn-primary btn-sm w-full">View Profile</a>
                         </div>
                     </div>
                 </div>
             @empty
                 <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                     <div class="w-16 h-16 bg-base-200 rounded-full flex items-center justify-center mb-4">
                         <x-icon name="o-users" class="w-8 h-8 opacity-50" />
                     </div>
                     <h3 class="text-lg font-bold">No Applicants Found</h3>
                     <p class="text-base-content/60">There are currently no students registered as applicants.</p>
                 </div>
             @endforelse
        </div>
        
        <div class="mt-8 flex justify-center">
            {{ $applicants->links() }} 
        </div>
    </div>
</x-layouts.main>