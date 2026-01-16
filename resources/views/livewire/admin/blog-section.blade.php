{{-- Blog Management Section --}}
@if($activeTab === 'blogs')
    <div class="p-8 space-y-8 bg-base-200/20 min-h-[600px]">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <x-icon name="o-document-text" class="w-7 h-7 text-primary" />
                    @if ($blogSubTab === 'form')
                        Create New Blog Article
                    @elseif ($blogSubTab === 'edit')
                        Edit Blog Article
                    @else
                        Blog Articles Directory
                    @endif
                </h2>
                <p class="text-base-content/60 mt-1">
                    @if ($blogSubTab === 'form')
                        Write and publish engaging content for your readers.
                    @elseif ($blogSubTab === 'edit')
                        Update and refine your blog article.
                    @else
                        Manage all published and draft blog articles.
                    @endif
                </p>
            </div>
            {{-- Sub-tab Toggle --}}
            <div class="join bg-base-100 shadow-sm border border-base-200">
                <button wire:click="setBlogSubTab('list')"
                    class="join-item btn btn-sm {{ $blogSubTab === 'list' ? 'btn-primary' : 'btn-ghost' }} gap-2">
                    <x-icon name="o-list-bullet" class="w-4 h-4" />
                    View List
                </button>
                <button wire:click="setBlogSubTab('form')"
                    class="join-item btn btn-sm {{ $blogSubTab === 'form' ? 'btn-primary' : 'btn-ghost' }} gap-2">
                    <x-icon name="o-plus-circle" class="w-4 h-4" />
                    Add Article
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-10">
            @if ($blogSubTab === 'form' || $blogSubTab === 'edit')
                {{-- Add/Edit Blog Form Card --}}
                <div class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="p-6 border-b border-base-200 bg-base-100/50">
                        <h3 class="font-bold text-lg flex items-center gap-2 text-primary">
                            <x-icon name="o-pencil-square" class="w-5 h-5" />
                            Article Details
                        </h3>
                    </div>
                    <div class="card-body p-6">
                        <div class="max-w-5xl mx-auto w-full">
                            <form wire:submit.prevent="{{ $blogSubTab === 'edit' ? 'updateBlog' : 'addBlog' }}" class="flex flex-col gap-y-6">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Blog Title --}}
                                    <div class="form-control items-start md:col-span-2">
                                        <label class="label mb-2">
                                            <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                <x-icon name="o-pencil-square" class="w-4 h-4 text-primary" />
                                                Article Title
                                            </span>
                                        </label>
                                        <input type="text" wire:model="blog_title"
                                            class="input input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                            placeholder="e.g. 5 Tips for Acing Your First Technical Interview" />
                                        @error('blog_title')
                                            <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Category --}}
                                    <div class="form-control items-start">
                                        <label class="label mb-2">
                                            <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                <x-icon name="o-tag" class="w-4 h-4 text-primary" />
                                                Category
                                            </span>
                                        </label>
                                        <select wire:model="blog_category"
                                            class="select select-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300">
                                            <option value="">Select a category</option>
                                            @foreach(\App\Livewire\Admin\Dashboard::BLOG_CATEGORIES as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                        @error('blog_category')
                                            <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="form-control items-start">
                                        <label class="label mb-2">
                                            <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                <x-icon name="o-check-circle" class="w-4 h-4 text-primary" />
                                                Status
                                            </span>
                                        </label>
                                        <select wire:model="blog_status"
                                            class="select select-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            @if($blogSubTab === 'edit')
                                                <option value="archived">Archived</option>
                                            @endif
                                        </select>
                                        @error('blog_status')
                                            <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Excerpt --}}
                                <div class="form-control items-start">
                                    <label class="label mb-2">
                                        <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                            <x-icon name="o-document-text" class="w-4 h-4 text-primary" />
                                            Excerpt (Optional)
                                        </span>
                                    </label>
                                    <textarea wire:model="blog_excerpt" rows="3"
                                        class="textarea textarea-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                        placeholder="A brief summary of your article (shown in listings)"></textarea>
                                    <label class="label">
                                        <span class="label-text-alt text-base-content/60">Recommended: 150-200 characters</span>
                                    </label>
                                    @error('blog_excerpt')
                                        <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Cover Image Upload --}}
                                <div class="form-control items-start">
                                    <label class="label mb-2">
                                        <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                            <x-icon name="o-photo" class="w-4 h-4 text-primary" />
                                            Cover Image
                                        </span>
                                    </label>
                                    <input type="file" wire:model="blog_cover_image" accept="image/*"
                                        class="file-input file-input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300" />
                                    <label class="label">
                                        <span class="label-text-alt text-base-content/60">Max 2MB. Recommended: 1200x600px</span>
                                    </label>
                                    @error('blog_cover_image')
                                        <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                    @enderror
                                    
                                    {{-- Image Preview --}}
                                    @if ($blog_cover_image)
                                        <div class="mt-4">
                                            <p class="text-sm font-medium mb-2">Preview:</p>
                                            <img src="{{ $blog_cover_image->temporaryUrl() }}" class="w-full max-w-md rounded-lg shadow-md" alt="Cover preview">
                                        </div>
                                    @elseif($existing_cover_image && $blogSubTab === 'edit')
                                        <div class="mt-4">
                                            <p class="text-sm font-medium mb-2">Current Image:</p>
                                            <img src="{{ asset('storage/' . $existing_cover_image) }}" class="w-full max-w-md rounded-lg shadow-md" alt="Current cover">
                                        </div>
                                    @endif
                                </div>

                                {{-- Content (EasyMDE Markdown Editor) --}}
                                <div class="form-control items-start">
                                    <x-markdown 
                                        wire:model="blog_content" 
                                        label="Content (Markdown)"
                                        hint="Write your blog content here using Markdown..."
                                        :config="[
                                            'spellChecker' => false,
                                            'toolbar' => ['bold', 'italic', 'heading', '|', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image', '|', 'preview', 'side-by-side', 'fullscreen', '|', 'guide'],
                                            'placeholder' => 'Write your blog content here using Markdown...',
                                        ]"
                                    />
                                </div>

                                {{-- Tags (Optional) --}}
                                <div class="form-control items-start">
                                    <label class="label mb-2">
                                        <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                            <x-icon name="o-hashtag" class="w-4 h-4 text-primary" />
                                            Tags (Optional)
                                        </span>
                                    </label>
                                    <input type="text" wire:model="blog_tags"
                                        class="input input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                        placeholder="e.g. Interview, Career, Tech (comma-separated)" />
                                    <label class="label">
                                        <span class="label-text-alt text-base-content/60">Separate tags with commas</span>
                                    </label>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-base-200">
                                    <button type="button" wire:click="setBlogSubTab('list')"
                                        class="btn btn-ghost gap-2">
                                        <x-icon name="o-arrow-left" class="w-5 h-5" />
                                        Back to List
                                    </button>
                                    <button type="submit"
                                        class="btn btn-primary px-12 shadow-lg hover:shadow-primary/20 transition-all gap-2 h-12 text-base">
                                        <x-icon name="o-paper-airplane" class="w-5 h-5 -rotate-45" />
                                        {{ $blogSubTab === 'edit' ? 'Update Article' : 'Publish Article' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @else
                {{-- Blog List Section --}}
                <div class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="p-6 border-b border-base-200 bg-base-100/50 flex justify-between items-center">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <x-icon name="o-list-bullet" class="w-5 h-5 text-primary" />
                            Published Articles
                        </h3>
                        <div class="badge badge-primary badge-soft">{{ $blogs->total() }} Total</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra table-lg">
                            <thead class="bg-base-200/50 text-base-content uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="pl-8 py-5">Article Details</th>
                                    <th class="py-5">Category</th>
                                    <th class="py-5">Status</th>
                                    <th class="py-5">Published</th>
                                    <th class="py-5">Views</th>
                                    <th class="text-right pr-8 py-5">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-base-200">
                                @forelse ($blogs as $blog)
                                    <tr wire:key="blog-{{ $blog->id }}" class="hover:bg-base-200/40 transition-all group">
                                        <td class="pl-8 py-4">
                                            <div class="font-bold text-base text-primary group-hover:underline">
                                                {{ $blog->title }}
                                            </div>
                                            <div class="text-sm opacity-60 line-clamp-1 max-w-xl mt-1">
                                                {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 100) }}
                                            </div>
                                            <div class="text-xs text-base-content/60 mt-1">
                                                By {{ $blog->author->name ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="badge badge-outline border-base-300 font-medium font-sans">
                                                {{ $blog->category }}
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            @if($blog->status === 'published')
                                                <div class="badge badge-success badge-sm gap-1">
                                                    <x-icon name="o-check-circle" class="w-3 h-3" />
                                                    Published
                                                </div>
                                            @elseif($blog->status === 'draft')
                                                <div class="badge badge-warning badge-sm gap-1">
                                                    <x-icon name="o-pencil" class="w-3 h-3" />
                                                    Draft
                                                </div>
                                            @else
                                                <div class="badge badge-ghost badge-sm">Archived</div>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            @if($blog->published_at)
                                                <div class="flex items-center gap-2 text-sm opacity-70">
                                                    <x-icon name="o-calendar" class="w-4 h-4" />
                                                    {{ $blog->published_at->format('M d, Y') }}
                                                </div>
                                            @else
                                                <span class="text-xs text-base-content/40">Not published</span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center gap-2 text-sm">
                                                <x-icon name="o-eye" class="w-4 h-4 text-base-content/60" />
                                                {{ number_format($blog->views) }}
                                            </div>
                                        </td>
                                        <td class="text-right pr-8 py-4">
                                            <div class="flex justify-end gap-2">
                                                @if($blog->status === 'draft')
                                                    <button wire:click="publishBlog({{ $blog->id }})"
                                                        wire:confirm="Publish '{{ $blog->title }}'?"
                                                        class="btn btn-success btn-ghost btn-sm text-success/70 hover:text-success hover:bg-success/10 p-2"
                                                        title="Publish">
                                                        <x-icon name="o-arrow-up-circle" class="w-5 h-5" />
                                                    </button>
                                                @endif
                                                <button wire:click="editBlog({{ $blog->id }})"
                                                    class="btn btn-primary btn-ghost btn-sm text-primary/70 hover:text-primary hover:bg-primary/10 p-2"
                                                    title="Edit">
                                                    <x-icon name="o-pencil-square" class="w-5 h-5" />
                                                </button>
                                                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                                                    class="btn btn-info btn-ghost btn-sm text-info/70 hover:text-info hover:bg-info/10 p-2"
                                                    title="View">
                                                    <x-icon name="o-eye" class="w-5 h-5" />
                                                </a>
                                                <button wire:click="deleteBlog({{ $blog->id }})"
                                                    wire:confirm="Are you sure you want to permanently delete '{{ $blog->title }}'? This will also delete the cover image."
                                                    class="btn btn-error btn-ghost btn-sm text-error/70 hover:text-error hover:bg-error/10 p-2"
                                                    title="Delete">
                                                    <x-icon name="o-trash" class="w-5 h-5" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-20 bg-base-50/20">
                                            <div class="flex flex-col items-center gap-4 opacity-40">
                                                <x-icon name="o-document-text" class="w-16 h-16" />
                                                <p class="text-lg font-medium">No blog articles yet.</p>
                                                <button wire:click="setBlogSubTab('form')" class="btn btn-primary btn-sm gap-2">
                                                    <x-icon name="o-plus" class="w-4 h-4" />
                                                    Create First Article
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($blogs->hasPages())
                        <div class="p-6 border-t border-base-200 bg-base-50/50">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif
