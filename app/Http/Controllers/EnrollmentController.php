<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();

        if ($user->courses()->where('courses.id', $course->id)->exists()) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        $user->courses()->attach($course);

        return redirect()->route('courses.show', $course)->with('success', 'You have successfully enrolled in the course!');
    }
}
