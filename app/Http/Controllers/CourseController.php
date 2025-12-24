<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('pages.courses.index');
    }

    public function show(Course $course)
    {
        return view('pages.courses.show', compact('course'));
    }
}
