<x-layouts.public title="Blog">
    <div class="bg-base-100 border-b border-base-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 pb-4">
                <div class="flex flex-col gap-3">
                    <h1 class="text-4xl font-black">Blog</h1>
                    <p class="text-base-content/70 text-base max-w-2xl">
                        Insights & Stories for UoM Future Leaders. Stay updated with the latest career advice, industry
                        news, and success stories from alumni.
                    </p>
                </div>

                @if(auth('company')->check())
                    <a href="{{ route('company.blogs') }}" class="btn btn-primary gap-2">
                        <x-icon name="o-document-text" class="w-5 h-5" />
                        My Blogs
                    </a>
                @endif
            </div>
        </div>
    </div>

    <livewire:blog.listing />
</x-layouts.public>