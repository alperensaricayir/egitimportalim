<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonRevision;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('admin.lessons.create', compact('course'));
    }

    public function store(LessonRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

        if (($validated['status'] ?? null) === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        if (($validated['status'] ?? null) !== 'published') {
            $validated['published_at'] = null;
        }
        
        $validated['updated_by'] = auth()->id();
        $course->lessons()->create($validated);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Lesson added successfully.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        $this->authorize('update', $course);
        $this->authorize('update', $lesson);
        if ((int) $lesson->course_id !== (int) $course->id) {
            abort(404);
        }

        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    public function update(LessonRequest $request, Course $course, Lesson $lesson)
    {
        $this->authorize('update', $course);
        $this->authorize('update', $lesson);
        if ((int) $lesson->course_id !== (int) $course->id) {
            abort(404);
        }

        $validated = $request->validated();

        if (($validated['status'] ?? null) === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        if (($validated['status'] ?? null) !== 'published') {
            $validated['published_at'] = null;
        }

        // Create revision if content changed
        if ($lesson->content !== $validated['content']) {
            LessonRevision::create([
                'lesson_id' => $lesson->id,
                'user_id' => auth()->id(),
                'content' => $lesson->content,
            ]);
        }

        $validated['updated_by'] = auth()->id();
        $lesson->update($validated);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $this->authorize('delete', $lesson);
        if ((int) $lesson->course_id !== (int) $course->id) {
            abort(404);
        }

        $lesson->delete();
        return back()->with('success', 'Lesson deleted (soft delete).');
    }

    public function restore(Course $course, $id)
    {
        $lesson = Lesson::withTrashed()->where('course_id', $course->id)->findOrFail($id);
        $this->authorize('restore', $lesson);
        $lesson->restore();

        return back()->with('success', 'Lesson restored successfully.');
    }

    public function restoreRevision(Course $course, Lesson $lesson, LessonRevision $revision)
    {
        $this->authorize('update', $lesson);
        if ((int) $lesson->course_id !== (int) $course->id) {
            abort(404);
        }
        if ((int) $revision->lesson_id !== (int) $lesson->id) {
            abort(404);
        }

        $lesson->update([
            'content' => $revision->content,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Lesson restored to revision from ' . $revision->created_at->format('M d, Y H:i'));
    }
    
    public function reorder(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:lessons,id',
        ]);

        foreach ($request->order as $index => $id) {
            Lesson::where('id', $id)->where('course_id', $course->id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
