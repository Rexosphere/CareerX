<div class="space-y-6">
    {{-- Header with Filters --}}
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h2 class="card-title text-2xl flex items-center gap-3">
                        <x-icon name="o-document-text" class="w-7 h-7 text-primary" />
                        Blog Management
                    </h2>
                    <p class="text-base-content/60 mt-1">Manage blog posts from admins and companies</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('blogs.index') }}" class="btn btn-ghost btn-sm gap-2" target="_blank">
                        <x-icon name="o-eye" class="w-4 h-4" />
                        View Public Blogs
                    </a>
                </div>
            </div>

            {{-- Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                {{-- Search --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Search</span>
                    </label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search blogs..."
                        class="input input-bordered input-sm" />
                </div>

                {{-- Status Filter --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select wire:model.live="filterStatus" class="select select-bordered select-sm">
                        <option value="all">All Statuses</option>
                        <option value="draft">Draft</option>
                        <option value="pending">Pending Review</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                {{-- Author Type Filter --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Author Type</span>
                    </label>
                    <select wire:model.live="filterAuthorType" class="select select-bordered select-sm">
                        <option value="all">All Authors</option>
                        <option value="admin">Admin Users</option>
                        <option value="company">Companies</option>
                    </select>
                </div>

                {{-- Approval Filter --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Approval Status</span>
                    </label>
                    <select wire:model.live="filterApproval" class="select select-bordered select-sm">
                        <option value="all">All</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending Approval</option>
                    </select>
                </div>
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

    {{-- Blogs Table --}}
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr class="bg-base-200/50 text-base-content">
                        <th class="pl-6">Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Approval</th>
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
                                <div class="flex flex-col">
                                    <div class="font-medium">{{ $blog->getAuthorName() }}</div>
                                    <div class="flex items-center gap-1">
                                        @if($blog->isCompanyBlog())
                                            <span class="badge badge-secondary badge-xs">Company</span>
                                        @else
                                            <span class="badge badge-primary badge-xs">Admin</span>
                                        @endif
                                    </div>
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
                                    <div class="flex flex-col">
                                        <span class="badge badge-success badge-sm">Approved</span>
                                        @if($blog->approvedBy)
                                            <span class="text-xs opacity-60 mt-1">by {{ $blog->approvedBy->name }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="badge badge-warning badge-sm">Not Approved</span>
                                @endif
                            </td>
                            <td>
                                @if($blog->submitted_at)
                                    <div class="text-sm">{{ $blog->submitted_at->format('M d, Y') }}</div>
                                    <div class="text-xs opacity-60">{{ $blog->submitted_at->format('h:i A') }}</div>
                                @else
                                    <span class="text-sm opacity-60">—</span>
                                @endif
                            </td>
                            <td class="text-right pr-6">
                                <div class="flex justify-end gap-1">
                                    {{-- View --}}
                                    <button wire:click="viewBlog({{ $blog->id }})" class="btn btn-ghost btn-sm"
                                        title="View Details">
                                        <x-icon name="o-eye" class="w-4 h-4" />
                                    </button>

                                    {{-- Approve (if pending and not approved) --}}
                                    @if($blog->status === 'pending' && !$blog->is_approved)
                                        <button wire:click="confirmApprove({{ $blog->id }})"
                                            class="btn btn-success btn-sm text-white" title="Approve">
                                            <x-icon name="o-check" class="w-4 h-4" />
                                        </button>
                                    @endif

                                    {{-- Reject (if approved or pending) --}}
                                    @if($blog->status === 'pending' || $blog->is_approved)
                                        <button wire:click="rejectBlog({{ $blog->id }})"
                                            wire:confirm="Reject this blog? It will be moved back to draft."
                                            class="btn btn-error btn-sm btn-outline" title="Reject">
                                            <x-icon name="o-x-mark" class="w-4 h-4" />
                                        </button>
                                    @endif

                                    {{-- Publish (if approved and not published) --}}
                                    @if($blog->is_approved && $blog->status !== 'published')
                                        <button wire:click="publishBlog({{ $blog->id }})" wire:confirm="Publish this blog?"
                                            class="btn btn-primary btn-sm" title="Publish">
                                            <x-icon name="o-rocket-launch" class="w-4 h-4" />
                                        </button>
                                    @endif

                                    {{-- Move to Draft (if published or archived) --}}
                                    @if($blog->status === 'published' || $blog->status === 'archived')
                                        <button wire:click="draftBlog({{ $blog->id }})" wire:confirm="Move this blog to draft?"
                                            class="btn btn-ghost btn-sm" title="Move to Draft">
                                            <x-icon name="o-document" class="w-4 h-4" />
                                        </button>
                                    @endif

                                    {{-- Delete --}}
                                    <button wire:click="confirmDelete({{ $blog->id }})"
                                        class="btn btn-error btn-ghost btn-sm" title="Delete">
                                        <x-icon name="o-trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 bg-base-50/50">
                                <div
                                    class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                                    <x-icon name="o-document-text" class="w-10 h-10 text-primary opacity-50" />
                                </div>
                                <h3 class="font-bold text-xl mb-1">No Blogs Found</h3>
                                <p class="text-base-content/60 max-w-sm mx-auto">No blogs match your current filters.</p>
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

    {{-- View Modal --}}
    @if($showViewModal && $selectedBlog)
        <div class="modal modal-open">
            <div class="modal-box max-w-4xl">
                <h3 class="font-bold text-2xl mb-4">{{ $selectedBlog->title }}</h3>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <span class="text-sm opacity-60">Author:</span>
                        <p class="font-medium">{{ $selectedBlog->getAuthorName() }}</p>
                    </div>
                    <div>
                        <span class="text-sm opacity-60">Category:</span>
                        <p class="font-medium">{{ $selectedBlog->category }}</p>
                    </div>
                    <div>
                        <span class="text-sm opacity-60">Status:</span>
                        <p>
                            @if($selectedBlog->status === 'draft')
                                <span class="badge badge-ghost">Draft</span>
                            @elseif($selectedBlog->status === 'pending')
                                <span class="badge badge-warning">Pending Review</span>
                            @elseif($selectedBlog->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-error">Archived</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="text-sm opacity-60">Approval:</span>
                        <p>
                            @if($selectedBlog->is_approved)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-warning">Not Approved</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($selectedBlog->excerpt)
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Excerpt</h4>
                        <p class="text-base-content/80">{{ $selectedBlog->excerpt }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h4 class="font-semibold mb-2">Content</h4>
                    <div class="prose max-w-none">
                        {!! Str::markdown($selectedBlog->content) !!}
                    </div>
                </div>

                <div class="modal-action">
                    <button wire:click="closeViewModal" class="btn">Close</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Approve Confirmation Modal --}}
    @if($showApproveModal && $blogToAction)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Approve Blog</h3>
                <p class="py-4">Are you sure you want to approve "{{ $blogToAction->title }}"?</p>
                <div class="modal-action">
                    <button wire:click="$set('showApproveModal', false)" class="btn btn-ghost">Cancel</button>
                    <button wire:click="approveBlog" class="btn btn-success text-white">Approve</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal && $blogToAction)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Delete Blog</h3>
                <p class="py-4">Are you sure you want to delete "{{ $blogToAction->title }}"? This will soft delete the blog
                    (it won't be permanently removed from the database).</p>
                <div class="modal-action">
                    <button wire:click="$set('showDeleteModal', false)" class="btn btn-ghost">Cancel</button>
                    <button wire:click="softDeleteBlog" class="btn btn-error">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>