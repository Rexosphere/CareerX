<div class="space-y-6">
    {{-- Header with Sub-tab Navigation --}}
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="card-title text-2xl flex items-center gap-3">
                        <x-icon name="o-document-text" class="w-7 h-7 text-primary" />
                        @if ($blogSubTab === 'form')
                            Create New Blog
                        @elseif ($blogSubTab === 'edit')
                            Edit Blog
                        @else
                            My Blogs
                        @endif
                    </h2>
                    <p class="text-base-content/60 mt-1">
                        @if ($blogSubTab === 'form')
                            Write and publish engaging content for your audience.
                        @elseif ($blogSubTab === 'edit')
                            Update and refine your blog post.
                        @else
                            Create and manage your company's blog posts
                        @endif
                    </p>
                </div>

                {{-- Sub-tab Toggle --}}
                @if ($blogSubTab === 'list')
                    <button wire:click="createBlog" class="btn btn-primary gap-2">
                        <x-icon name="o-plus" class="w-5 h-5" />
                        Create New Blog
                    </button>
                @else
                    <div class="join bg-base-100 shadow-sm border border-base-200">
                        <button wire:click="setBlogSubTab('list')"
                            class="join-item btn btn-sm {{ $blogSubTab === 'list' ? 'btn-primary' : 'btn-ghost' }} gap-2">
                            <x-icon name="o-list-bullet" class="w-4 h-4" />
                            View List
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success shadow-sm">
            <x-icon name="o-check-circle" class="w-6 h-6" />
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Content Area --}}
    @if ($blogSubTab === 'form' || $blogSubTab === 'edit')
        {{-- Blog Form --}}
        <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
            <div class="p-6 border-b border-base-200 bg-base-100/50">
                <h3 class="font-bold text-lg flex items-center gap-2 text-primary">
                    <x-icon name="o-pencil-square" class="w-5 h-5" />
                    Blog Details
                </h3>
            </div>
            <div class="card-body p-6">
                <div class="max-w-5xl mx-auto w-full">
                    <form wire:submit.prevent="saveBlog(false)" class="flex flex-col gap-y-6">

                        {{-- Title --}}
                        <div class="form-control">
                            <label class="label mb-2">
                                <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                    <x-icon name="o-pencil-square" class="w-4 h-4 text-primary" />
                                    Blog Title *
                                </span>
                            </label>
                            <input type="text" wire:model="title"
                                class="input input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                placeholder="e.g. 5 Tips for Acing Your First Technical Interview" />
                            @error('title')
                                <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Category --}}
                            <div class="form-control">
                                <label class="label mb-2">
                                    <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                        <x-icon name="o-tag" class="w-4 h-4 text-primary" />
                                        Category *
                                    </span>
                                </label>
                                <select wire:model="category"
                                    class="select select-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300">
                                    <option value="Career Guidance">Career Guidance</option>
                                    <option value="Interview Tips">Interview Tips</option>
                                    <option value="Industry Insights">Industry Insights</option>
                                    <option value="Company Culture">Company Culture</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Career Development">Career Development</option>
                                </select>
                                @error('category')
                                    <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div class="form-control">
                            <label class="label mb-2">
                                <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                    <x-icon name="o-document-text" class="w-4 h-4 text-primary" />
                                    Excerpt (Optional)
                                </span>
                            </label>
                            <textarea wire:model="excerpt" rows="3"
                                class="textarea textarea-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                placeholder="A brief summary of your blog post (shown in listings)"></textarea>
                            <label class="label">
                                <span class="label-text-alt text-base-content/60">Recommended: 150-200 characters</span>
                            </label>
                            @error('excerpt')
                                <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Featured Image --}}
                        <div class="form-control">
                            <label class="label mb-2">
                                <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                    <x-icon name="o-photo" class="w-4 h-4 text-primary" />
                                    Featured Image
                                </span>
                            </label>
                            <input type="file" wire:model="featured_image" accept="image/*"
                                class="file-input file-input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300" />
                            <label class="label">
                                <span class="label-text-alt text-base-content/60">Max 2MB. Recommended: 1200x600px</span>
                            </label>
                            @error('featured_image')
                                <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror

                            {{-- Image Preview --}}
                            @if ($featured_image)
                                <div class="mt-4">
                                    <p class="text-sm font-medium mb-2">Preview:</p>
                                    <img src="{{ $featured_image->temporaryUrl() }}"
                                        class="w-full max-w-md rounded-lg shadow-md" alt="Cover preview">
                                </div>
                            @elseif($existingFeaturedImage && $editMode)
                                <div class="mt-4">
                                    <p class="text-sm font-medium mb-2">Current Image:</p>
                                    <img src="{{ asset('storage/' . $existingFeaturedImage) }}"
                                        class="w-full max-w-md rounded-lg shadow-md" alt="Current cover">
                                </div>
                            @endif
                        </div>

                        {{-- Content (Markdown Editor) --}}
                        <div class="form-control">
                            <x-markdown wire:model="content" label="Content (Markdown) *"
                                hint="Write your blog content here using Markdown..." :config="[
                'spellChecker' => false,
                'toolbar' => ['bold', 'italic', 'heading', '|', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image', '|', 'preview', 'side-by-side', 'fullscreen', '|', 'guide'],
                'placeholder' => 'Write your blog content here using Markdown...',
            ]" />
                            @error('content')
                                <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tags --}}
                        <div class="form-control">
                            <label class="label mb-2">
                                <span class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                    <x-icon name="o-hashtag" class="w-4 h-4 text-primary" />
                                    Tags (Optional)
                                </span>
                            </label>
                            <div class="flex gap-2 mb-2">
                                <input type="text" wire:model="tagInput" wire:keydown.enter.prevent="addTag"
                                    class="input input-bordered flex-1 bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                    placeholder="Add a tag and press Enter" />
                                <button type="button" wire:click="addTag" class="btn btn-primary">Add</button>
                            </div>
                            @if(count($tags) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $index => $tag)
                                        <div class="badge badge-primary gap-2">
                                            {{ $tag }}
                                            <button type="button" wire:click="removeTag({{ $index }})"
                                                class="btn btn-xs btn-circle btn-ghost">
                                                <x-icon name="o-x-mark" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Form Actions --}}
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-base-200">
                            <button type="button" wire:click="setBlogSubTab('list')" class="btn btn-ghost gap-2">
                                <x-icon name="o-arrow-left" class="w-5 h-5" />
                                Back to List
                            </button>
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-ghost gap-2">
                                    <x-icon name="o-document" class="w-5 h-5" />
                                    Save as Draft
                                </button>
                                <button type="button" wire:click="submitForReview"
                                    class="btn btn-primary px-8 shadow-lg hover:shadow-primary/20 transition-all gap-2">
                                    <x-icon name="o-paper-airplane" class="w-5 h-5" />
                                    Submit for Review
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{-- Blog List --}}
        <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr class="bg-base-200/50 text-base-content">
                            <th class="pl-6">Title</th>
                            <th>Status</th>
                            <th>Approval Status</th>
                            <th>Submitted</th>
                            <th class="text-right pr-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr wire:key="blog-{{ $blog->id }}" class="hover:bg-base-200/30 transition-colors">
                                <td class="pl-6">
                                    <div>
                                        <div class="font-bold">{{ $blog->title }}</div>
                                        <div class="text-xs opacity-60">{{ Str::limit($blog->excerpt, 60) }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($blog->status === 'draft')
                                        <span class="badge badge-ghost">Draft</span>
                                    @elseif($blog->status === 'pending')
                                        <span class="badge badge-warning">Pending Review</span>
                                    @elseif($blog->status === 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($blog->status === 'archived')
                                        <span class="badge badge-error">Archived</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->is_approved)
                                        <div class="flex items-center gap-2">
                                            <span class="badge badge-success badge-sm">Approved</span>
                                            @if($blog->approved_at)
                                                <span class="text-xs opacity-60">{{ $blog->approved_at->format('M d') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="badge badge-warning badge-sm">Pending Approval</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->submitted_at)
                                        <div class="text-sm">{{ $blog->submitted_at->format('M d, Y') }}</div>
                                    @else
                                        <span class="text-sm opacity-60">Not submitted</span>
                                    @endif
                                </td>
                                <td class="text-right pr-6">
                                    <div class="flex justify-end gap-1">
                                        {{-- Edit (only if draft) --}}
                                        @if($blog->status === 'draft')
                                            <button wire:click="editBlog({{ $blog->id }})" class="btn btn-ghost btn-sm"
                                                title="Edit">
                                                <x-icon name="o-pencil" class="w-4 h-4" />
                                            </button>
                                        @endif

                                        {{-- View Link (if published) --}}
                                        @if($blog->status === 'published')
                                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                                                class="btn btn-ghost btn-sm" title="View Published">
                                                <x-icon name="o-eye" class="w-4 h-4" />
                                            </a>
                                        @endif

                                        {{-- Delete (only if draft) --}}
                                        @if($blog->status === 'draft')
                                            <button wire:click="deleteBlog({{ $blog->id }})"
                                                wire:confirm="Are you sure you want to delete this blog?"
                                                class="btn btn-error btn-ghost btn-sm" title="Delete">
                                                <x-icon name="o-trash" class="w-4 h-4" />
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 bg-base-50/50">
                                    <div
                                        class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                                        <x-icon name="o-document-text" class="w-10 h-10 text-primary opacity-50" />
                                    </div>
                                    <h3 class="font-bold text-xl mb-1">No Blogs Yet</h3>
                                    <p class="text-base-content/60 max-w-sm mx-auto mb-4">Start creating blog posts to share
                                        with your audience.</p>
                                    <button wire:click="createBlog" class="btn btn-primary btn-sm gap-2">
                                        <x-icon name="o-plus" class="w-4 h-4" />
                                        Create Your First Blog
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($blogs->hasPages())
                <div class="p-4 border-t border-base-200 bg-base-50">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- Info Alert for Pending Blogs --}}
    @if($blogSubTab === 'list' && $blogs->where('status', 'pending')->count() > 0)
        <div class="alert alert-info shadow-sm">
            <x-icon name="o-information-circle" class="w-6 h-6" />
            <div>
                <h4 class="font-bold">Pending Review</h4>
                <p class="text-sm">You have {{ $blogs->where('status', 'pending')->count() }} blog(s) waiting for admin
                    approval.</p>
            </div>
        </div>
    @endif
</div>