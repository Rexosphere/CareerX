<?php

namespace App\Livewire\Company;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyBlogManager extends Component
{
    use WithPagination, WithFileUploads;

    // Sub-tab navigation
    public $blogSubTab = 'list'; // 'list', 'form', 'edit'
    public $editMode = false;

    // Blog form fields
    public $blogId;
    public $title = '';
    public $excerpt = '';
    public $content = '';
    public $category = 'Career Guidance';
    public $tags = [];
    public $tagInput = '';
    public $featured_image;
    public $existingFeaturedImage;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
        ];
    }

    public function setBlogSubTab($tab)
    {
        $this->blogSubTab = $tab;
        if ($tab === 'list') {
            $this->resetForm();
        }
    }

    public function createBlog()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->blogSubTab = 'form';
    }

    public function editBlog($blogId)
    {
        $blog = Blog::where('company_id', Auth::guard('company')->id())
            ->where('id', $blogId)
            ->firstOrFail();

        $this->blogId = $blog->id;
        $this->title = $blog->title;
        $this->excerpt = $blog->excerpt;
        $this->content = $blog->content;
        $this->category = $blog->category;
        $this->tags = $blog->tags ?? [];
        $this->existingFeaturedImage = $blog->featured_image;

        $this->editMode = true;
        $this->blogSubTab = 'edit';
    }

    public function saveBlog($submitForReview = false)
    {
        $this->validate();

        $data = [
            'company_id' => Auth::guard('company')->id(),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'tags' => $this->tags,
            'status' => $submitForReview ? 'pending' : 'draft',
        ];

        if ($this->featured_image) {
            $path = $this->featured_image->store('blog-images', 'public');
            $data['featured_image'] = $path;
        }

        if ($this->editMode) {
            $blog = Blog::where('company_id', Auth::guard('company')->id())
                ->where('id', $this->blogId)
                ->firstOrFail();

            $blog->update($data);

            if ($submitForReview) {
                $blog->submitForReview();
                session()->flash('message', 'Blog updated and submitted for review!');
            } else {
                session()->flash('message', 'Blog updated successfully!');
            }
        } else {
            $blog = Blog::create($data);

            if ($submitForReview) {
                $blog->submitForReview();
                session()->flash('message', 'Blog created and submitted for review!');
            } else {
                session()->flash('message', 'Blog saved as draft!');
            }
        }

        $this->blogSubTab = 'list';
        $this->resetForm();
    }

    public function submitForReview()
    {
        $this->saveBlog(true);
    }

    public function deleteBlog($blogId)
    {
        $blog = Blog::where('company_id', Auth::guard('company')->id())
            ->where('id', $blogId)
            ->where('status', 'draft')
            ->firstOrFail();

        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();
        session()->flash('message', 'Blog deleted successfully!');
    }

    public function addTag()
    {
        if ($this->tagInput && !in_array($this->tagInput, $this->tags)) {
            $this->tags[] = $this->tagInput;
            $this->tagInput = '';
        }
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
    }

    public function resetForm()
    {
        $this->reset([
            'blogId',
            'title',
            'excerpt',
            'content',
            'category',
            'tags',
            'tagInput',
            'featured_image',
            'existingFeaturedImage',
            'editMode'
        ]);
    }

    public function render()
    {
        $blogs = Blog::where('company_id', Auth::guard('company')->id())
            ->notDeleted()
            ->latest()
            ->paginate(10);

        return view('livewire.company.company-blog-manager', [
            'blogs' => $blogs,
        ]);
    }
}
