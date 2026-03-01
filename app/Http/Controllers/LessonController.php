<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        // Check if lesson belongs to course
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Check visibility
        if ($course->status !== 'published') {
            abort(404);
        }

        // If lesson is preview, allow guests or non-enrolled users
        $canView = $lesson->is_preview;

        // If not preview, check enrollment
        if (!$canView && auth()->check()) {
            $canView = auth()->user()->courses()->where('course_id', $course->id)->exists();
            
            // Allow admin/editor
            if (auth()->user()->role === 'admin' || auth()->user()->role === 'editor') {
                $canView = true;
            }
        }

        if (!$canView) {
            return redirect()->route('courses.show', $course)->with('error', 'You must enroll to view this lesson.');
        }

        // Previous and Next lessons for navigation (only published)
        $previous = $course->lessons()
            ->published()
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();
            
        $next = $course->lessons()
            ->published()
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();

        return view('lessons.show', compact('course', 'lesson', 'previous', 'next'));
    }
}
