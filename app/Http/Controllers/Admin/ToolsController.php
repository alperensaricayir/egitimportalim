<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRevision;
use App\Models\Lesson;
use App\Models\LessonRevision;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function routeTester(Request $request)
    {
        $courses = Course::withTrashed()->orderBy('id')->get();
        $lessons = Lesson::withTrashed()->orderBy('id')->get();
        $courseRevisions = CourseRevision::orderBy('id')->get();
        $lessonRevisions = LessonRevision::orderBy('id')->get();

        $firstCourse = Course::orderBy('id')->first();
        $firstLesson = Lesson::orderBy('id')->first();
        $defaultLessonOrder = [];
        if ($firstCourse) {
            $defaultLessonOrder = $firstCourse->lessons()->orderBy('order')->pluck('id')->all();
        }

        return view('admin.tools.route-tester', [
            'courses' => $courses,
            'lessons' => $lessons,
            'courseRevisions' => $courseRevisions,
            'lessonRevisions' => $lessonRevisions,
            'firstCourse' => $firstCourse,
            'firstLesson' => $firstLesson,
            'defaultLessonOrder' => $defaultLessonOrder,
        ]);
    }
}
