<?php

namespace App\Livewire\Admin;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class BlogManagement extends Component
{
    use WithPagination;

    public $filterStatus = 'all';
    public $filterAuthorType = 'all';
    public $filterApproval = 'all';
    public $search = '';
    public $selectedBlog = null;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $showApproveModal = false;
    public $blogToAction = null;

    protected $queryString = ['search', 'filterStatus', 'filterAuthorType', 'filterApproval'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterAuthorType()
    {
        $this->resetPage();
    }

    public function updatingFilterApproval()
    {
        $this->resetPage();
    }

    public function getBlogs()
    {
        $query = Blog::with(['author', 'company', 'approvedBy'])
            ->notDeleted();

        // Apply search
        if ($this->search) {
            $query->search($this->search);
        }

        // Apply status filter
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Apply author type filter
        if ($this->filterAuthorType === 'admin') {
            $query->userBlogs();
        } elseif ($this->filterAuthorType === 'company') {
            $query->companyBlogs();
        }

        // Apply approval filter
        if ($this->filterApproval === 'approved') {
            $query->approved();
        } elseif ($this->filterApproval === 'pending') {
            $query->where('is_approved', false);
        }

        return $query->latest()->paginate(15);
    }

    public function viewBlog($blogId)
    {
        $this->selectedBlog = Blog::with(['author', 'company', 'approvedBy'])->find($blogId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedBlog = null;
    }

    public function confirmApprove($blogId)
    {
        $this->blogToAction = Blog::find($blogId);
        $this->showApproveModal = true;
    }

    public function approveBlog()
    {
        if ($this->blogToAction) {
            $this->blogToAction->approve(Auth::id());
            session()->flash('message', 'Blog approved successfully!');
            $this->showApproveModal = false;
            $this->blogToAction = null;
        }
    }

    public function rejectBlog($blogId)
    {
        $blog = Blog::find($blogId);
        if ($blog) {
            $blog->reject();
            session()->flash('message', 'Blog rejected and moved back to draft.');
        }
    }

    public function publishBlog($blogId)
    {
        $blog = Blog::find($blogId);
        if ($blog && $blog->is_approved) {
            $blog->publish();
            session()->flash('message', 'Blog published successfully!');
        }
    }

    public function draftBlog($blogId)
    {
        $blog = Blog::find($blogId);
        if ($blog) {
            $blog->update(['status' => 'draft']);
            session()->flash('message', 'Blog moved to draft.');
        }
    }

    public function confirmDelete($blogId)
    {
        $this->blogToAction = Blog::find($blogId);
        $this->showDeleteModal = true;
    }

    public function softDeleteBlog()
    {
        if ($this->blogToAction) {
            $this->blogToAction->softDelete();
            session()->flash('message', 'Blog deleted successfully!');
            $this->showDeleteModal = false;
            $this->blogToAction = null;
        }
    }

    public function restoreBlog($blogId)
    {
        $blog = Blog::withoutGlobalScope('notDeleted')->find($blogId);
        if ($blog) {
            $blog->restore();
            session()->flash('message', 'Blog restored successfully!');
        }
    }

    public function editBlog($blogId)
    {
        return redirect()->route('admin.blogs.edit', $blogId);
    }

    public function render()
    {
        return view('livewire.admin.blog-management', [
            'blogs' => $this->getBlogs(),
        ]);
    }
}
