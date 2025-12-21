<x-layouts.public title="{{ $post['title'] ?? 'Blog Post' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumbs --}}
        <nav class="flex mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="link link-hover text-base-content/60">Home</a></li>
                <li><span class="text-base-content/40">/</span></li>
                <li><a href="{{ route('blog.index') }}" class="link link-hover text-base-content/60">Blog</a></li>
                <li><span class="text-base-content/40">/</span></li>
                <li class="text-base-content font-medium truncate max-w-xs">{{ $post['title'] ?? 'Post' }}</li>
            </ol>
        </nav>

        <livewire:blog.post-detail :slug="$slug" />
    </div>
</x-layouts.public>
