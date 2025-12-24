<x-layouts.public title="{{ $course->title }}">
    <div class="bg-base-100 border-b border-base-300 relative overflow-hidden">
        {{-- Decorative background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto max-w-7xl px-4 py-16 relative">
            <div class="flex flex-col gap-6 max-w-3xl">
                <nav class="text-sm">
                    <ul class="flex items-center gap-2 text-base-content/50 font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                        <li><x-icon name="o-chevron-right" class="w-3 h-3" /></li>
                        <li><a href="{{ route('courses.index') }}"
                                class="hover:text-primary transition-colors">Courses</a></li>
                        <li><x-icon name="o-chevron-right" class="w-3 h-3" /></li>
                        <li class="text-base-content truncate">{{ $course->title }}</li>
                    </ul>
                </nav>

                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold w-fit">
                    {{ $course->category }}
                </div>

                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                    {{ $course->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 mt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-base-200 flex items-center justify-center text-primary">
                            <x-icon name="o-calendar" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50 uppercase font-black">Last Updated</p>
                            <p class="font-bold text-sm">{{ $course->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-4xl px-4 py-16">
        <div
            class="prose prose-lg prose-primary max-w-none bg-base-100 p-8 md:p-12 rounded-3xl border border-base-300 shadow-sm leading-relaxed">
            <h2 class="text-3xl font-black mb-10 text-base-content flex items-center gap-3">
                <x-icon name="o-document-text" class="w-8 h-8 text-primary" />
                Course Overview
            </h2>

            <div class="text-base-content/80 whitespace-pre-line">
                {!! $course->content !!}
            </div>

            {{-- Curriculum section --}}
            <div class="mt-16 pt-16 border-t border-base-200">
                <h2 class="text-3xl font-black mb-6 text-base-content flex items-center gap-3">
                    <x-icon name="o-list-bullet" class="w-8 h-8 text-primary" />
                    Curriculum Overview
                </h2>

                <p class="text-base-content/70 mb-8 leading-relaxed">
                    This course is structured into several comprehensive modules designed to take you from fundamentals
                    to advanced real-world implementation.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach(['Introduction & Fundamentals', 'Intermediate Concepts', 'Advanced Techniques', 'Real-world Project Implementation'] as $index => $module)
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-base-200/50 border border-base-300">
                            <div
                                class="w-10 h-10 rounded-xl bg-primary text-primary-content flex items-center justify-center font-black shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <span class="font-bold text-base-content">{{ $module }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>