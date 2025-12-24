<x-layouts.public title="Company Registration - CareerX">
    <div
        class="min-h-screen py-16 px-4 bg-gradient-to-br from-base-100 via-base-200 to-base-300 relative overflow-hidden flex items-center justify-center">
        {{-- Decorative background elements --}}
        <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>

        <div class="w-full relative z-10">
            <livewire:auth.company-registration />
        </div>
    </div>
</x-layouts.public>