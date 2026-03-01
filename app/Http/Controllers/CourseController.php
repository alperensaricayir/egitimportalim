<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::published()
            ->withCount(['lessons' => function ($query) {
                $query->published();
            }])
            ->latest('published_at')
            ->paginate(12);
            
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $course->load(['lessons' => function ($query) {
            $query->published()->orderBy('order');
        }]);
        
        return view('courses.show', compact('course'));
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        if ($course->status !== 'published') {
            abort(404);
        }

        if (!$user->courses()->where('course_id', $course->id)->exists()) {
            $user->courses()->attach($course->id);
            return redirect()->route('courses.show', $course)->with('success', 'You have successfully enrolled in the course!');
        }

        return redirect()->route('courses.show', $course)->with('info', 'You are already enrolled.');
    }
}
