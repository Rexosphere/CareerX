<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\User;
use App\Models\Company;
use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $stats = [];
    public string $activeTab = 'overview'; // 'overview', 'companies', 'jobs', 'courses', 'students'
    public string $courseSubTab = 'list'; // 'list', 'form'

    protected $queryString = [
        'activeTab' => ['except' => 'overview', 'as' => 'tab'],
        'courseSubTab' => ['except' => 'list', 'as' => 'subTab'],
    ];

    // Course Form Properties
    public $course_title;
    public $course_category;
    public $course_content;

    // Student Filter Properties
    public $studentSearch = '';

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
        session()->flash('message', "Company {$company->name} has been approved.");
        $this->refreshStats();
    }

    public function reject($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['status' => 'rejected']);
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

        return view('livewire.admin.dashboard', [
            'pendingCompanies' => $pendingCompanies,
            'jobs' => $jobs,
            'courses' => $courses,
            'students' => $students
        ]);
    }
}