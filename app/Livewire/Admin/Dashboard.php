<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\User;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\Blog;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Admin Dashboard - CareerX')]
class Dashboard extends Component
{
    use WithPagination, WithFileUploads;

    public $stats = [];
    public string $activeTab = 'overview'; // 'overview', 'companies', 'jobs', 'courses', 'students', 'blogs'
    public string $courseSubTab = 'list'; // 'list', 'form'
    public string $blogSubTab = 'list'; // 'list', 'form', 'edit'

    protected $queryString = [
        'activeTab' => ['except' => 'overview', 'as' => 'tab'],
        'courseSubTab' => ['except' => 'list', 'as' => 'subTab'],
        'blogSubTab' => ['except' => 'list', 'as' => 'blogTab'],
    ];

    // Course Form Properties
    public $course_title;
    public $course_category;
    public $course_content;

    // Student Filter Properties
    public $studentSearch = '';

    // Blog Form Properties
    public $blog_id = null;
    public $blog_title;
    public $blog_excerpt;
    public $blog_content;
    public $blog_category;
    public $blog_tags = [];
    public $blog_cover_image;
    public $blog_status = 'draft';
    public $blog_published_at;
    public $existing_cover_image = null;

    public function mount()
    {
        $this->refreshStats();

        // Check for tab in request
        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }

        // Check for subTab in request
        if (request()->has('subTab')) {
            $this->courseSubTab = request('subTab');
        }
    }

    public function setCourseSubTab(string $sub)
    {
        $this->courseSubTab = $sub;
        if ($this->activeTab !== 'courses') {
            $this->activeTab = 'courses';
        }
    }

    public function refreshStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'total_companies' => Company::count(),
            'total_jobs' => JobPosting::count(),
            'total_courses' => Course::count(),
            'total_students' => User::whereHas('roles', function ($q) {
                $q->where('name', 'student');
            })->count(),
            'pending_companies' => Company::where('status', 'pending')->count(),
            'total_blogs' => Blog::count(),
            'published_blogs' => Blog::published()->count(),
        ];
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function approve($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['status' => 'active']);
        
        // Send approval notification to company
        $company->notify(new \App\Notifications\CompanyApproved());
        
        session()->flash('message', "Company {$company->name} has been approved.");
        $this->refreshStats();
    }

    public function reject($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['status' => 'rejected']);
        
        // Send rejection notification to company
        $company->notify(new \App\Notifications\CompanyRejected());
        
        session()->flash('message', "Company {$company->name} has been rejected.");
        $this->refreshStats();
    }

    public function deleteJob($jobId)
    {
        $job = JobPosting::findOrFail($jobId);
        $job->delete();
        session()->flash('message', "Job posting '{$job->title}' has been deleted.");
        $this->refreshStats();
    }

    const COURSE_CATEGORIES = [
        'Cv creating sessions',
        'Interview facing sessions',
        'Industrial careers sessions',
        'Academia careers sessions'
    ];

    const BLOG_CATEGORIES = [
        'Career Advice',
        'Interview Prep',
        'Tech Trends',
        'Alumni Stories',
        'Student Life',
        'Internships',
        'Workshop',
    ];

    public function addCourse()
    {
        $this->validate([
            'course_title' => 'required|min:3',
            'course_category' => 'required',
            'course_content' => [
                'required',
                'url',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/', $value)) {
                        $fail('The ' . $attribute . ' must be a valid YouTube URL.');
                    }
                }
            ],
        ]);

        Course::create([
            'title' => $this->course_title,
            'category' => $this->course_category,
            'content' => $this->course_content,
        ]);

        $this->reset(['course_title', 'course_category', 'course_content']);
        $this->refreshStats();
        session()->flash('message', 'Course added successfully!');
    }

    public function deleteCourse($courseId)
    {
        Course::findOrFail($courseId)->delete();
        $this->refreshStats();
        session()->flash('message', 'Course deleted successfully.');
    }

    public function deleteStudent($studentId)
    {
        $student = User::findOrFail($studentId);
        $student->delete();
        $this->refreshStats();
        session()->flash('message', "Student '{$student->name}' has been deleted.");
    }

    public function setBlogSubTab(string $sub)
    {
        $this->blogSubTab = $sub;
        if ($this->activeTab !== 'blogs') {
            $this->activeTab = 'blogs';
        }
        if ($sub === 'form') {
            $this->resetBlogForm();
        }
    }

    public function resetBlogForm()
    {
        $this->reset(['blog_id', 'blog_title', 'blog_excerpt', 'blog_content', 'blog_category', 'blog_tags', 'blog_cover_image', 'blog_status', 'blog_published_at', 'existing_cover_image']);
        $this->blog_status = 'draft';
    }

    public function addBlog()
    {
        $this->validate([
            'blog_title' => 'required|min:3|max:255',
            'blog_excerpt' => 'nullable|max:500',
            'blog_content' => 'required|min:10',
            'blog_category' => 'required',
            'blog_status' => 'required|in:draft,published',
            'blog_cover_image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $coverImagePath = null;
        if ($this->blog_cover_image) {
            $coverImagePath = $this->blog_cover_image->store('blog-covers', 'public');
        }

        $blog = Blog::create([
            'author_id' => auth('admin')->id() ?? auth()->id(),
            'title' => $this->blog_title,
            'excerpt' => $this->blog_excerpt,
            'content' => $this->blog_content,
            'category' => $this->blog_category,
            'tags' => $this->blog_tags ? (is_array($this->blog_tags) ? $this->blog_tags : explode(',', $this->blog_tags)) : [],
            'featured_image' => $coverImagePath,
            'status' => $this->blog_status,
            'published_at' => $this->blog_status === 'published' ? ($this->blog_published_at ?? now()) : null,
        ]);

        $this->resetBlogForm();
        $this->blogSubTab = 'list';
        $this->refreshStats();
        session()->flash('message', "Blog article '{$blog->title}' has been created successfully!");
    }

    public function editBlog($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        $this->blog_id = $blog->id;
        $this->blog_title = $blog->title;
        $this->blog_excerpt = $blog->excerpt;
        $this->blog_content = $blog->content;
        $this->blog_category = $blog->category;
        $this->blog_tags = $blog->tags ?? [];
        $this->blog_status = $blog->status;
        $this->blog_published_at = $blog->published_at?->format('Y-m-d\TH:i');
        $this->existing_cover_image = $blog->featured_image;
        
        $this->blogSubTab = 'edit';
        $this->activeTab = 'blogs';
    }

    public function updateBlog()
    {
        $this->validate([
            'blog_title' => 'required|min:3|max:255',
            'blog_excerpt' => 'nullable|max:500',
            'blog_content' => 'required|min:10',
            'blog_category' => 'required',
            'blog_status' => 'required|in:draft,published,archived',
            'blog_cover_image' => 'nullable|image|max:2048',
        ]);

        $blog = Blog::findOrFail($this->blog_id);

        $coverImagePath = $this->existing_cover_image;
        if ($this->blog_cover_image) {
            // Delete old image if exists
            if ($this->existing_cover_image) {
                Storage::disk('public')->delete($this->existing_cover_image);
            }
            $coverImagePath = $this->blog_cover_image->store('blog-covers', 'public');
        }

        $blog->update([
            'title' => $this->blog_title,
            'excerpt' => $this->blog_excerpt,
            'content' => $this->blog_content,
            'category' => $this->blog_category,
            'tags' => $this->blog_tags ? (is_array($this->blog_tags) ? $this->blog_tags : explode(',', $this->blog_tags)) : [],
            'featured_image' => $coverImagePath,
            'status' => $this->blog_status,
            'published_at' => $this->blog_status === 'published' ? ($this->blog_published_at ?? $blog->published_at ?? now()) : $blog->published_at,
        ]);

        $this->resetBlogForm();
        $this->blogSubTab = 'list';
        $this->refreshStats();
        session()->flash('message', "Blog article '{$blog->title}' has been updated successfully!");
    }

    public function deleteBlog($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        // Delete cover image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();
        $this->refreshStats();
        session()->flash('message', "Blog article '{$blog->title}' has been deleted.");
    }

    public function publishBlog($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        $blog->publish();
        $this->refreshStats();
        session()->flash('message', "Blog article '{$blog->title}' has been published!");
    }

    public function render()
    {
        $pendingCompanies = Company::where('status', 'pending')
            ->latest()
            ->paginate(10, pageName: 'companies-page');

        $jobs = JobPosting::with('company')
            ->latest()
            ->paginate(10, pageName: 'jobs-page');

        $courses = Course::latest()
            ->paginate(10, pageName: 'courses-page');

        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->studentSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->studentSearch . '%');
            })
            ->latest()
            ->paginate(10, pageName: 'students-page');

        $blogs = Blog::with('author')
            ->latest('created_at')
            ->paginate(10, pageName: 'blogs-page');

        return view('livewire.admin.dashboard', [
            'pendingCompanies' => $pendingCompanies,
            'jobs' => $jobs,
            'courses' => $courses,
            'students' => $students,
            'blogs' => $blogs,
        ]);
    }
}