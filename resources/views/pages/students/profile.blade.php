<x-layouts.public title="Student Profile">
    <div class="flex justify-center pt-8 px-4">
        <livewire:students.profile :studentId="$studentId ?? 1" />
    </div>
</x-layouts.public>