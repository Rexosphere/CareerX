<x-layouts.main title="My Research & Academia">
    <div class="min-h-[calc(100vh-4rem)] bg-base-200 py-10 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center gap-3 mb-8">
                <div class="bg-primary/10 text-primary p-3 rounded-lg">
                    <x-icon name="o-academic-cap" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Academia & Research</h1>
                    <p class="text-base-content/60">Showcase your research projects and academic achievements</p>
                </div>
            </div>
            <livewire:academia.research-manager />
        </div>
    </div>
</x-layouts.main>
