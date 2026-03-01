<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Models\CourseRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Course::class);

        $query = Course::query()->withCount('users');

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('trashed')) {
            if ($request->trashed === 'with') {
                $query->withTrashed();
            } elseif ($request->trashed === 'only') {
                $query->onlyTrashed();
            }
        }

        if ($request->filled('is_paid')) {
            $query->where('is_paid', $request->is_paid);
        }

        // Sorting
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['title', 'students_count', 'created_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $direction = $direction === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sort === 'students_count' ? 'users_count' : $sort, $direction);

        $courses = $query->paginate(10)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);
        return view('admin.courses.create');
    }

    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();
        $validated['is_paid'] = $request->boolean('is_paid') ? 1 : 0;
        if (!$validated['is_paid']) {
            $validated['price'] = null;
        }

        if (($validated['status'] ?? null) === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        if (($validated['status'] ?? null) !== 'published') {
            $validated['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['updated_by'] = auth()->id();
        $course = Course::create($validated);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        return redirect()->route('admin.courses.edit', $course);
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $course->load([
            'lessons' => fn ($q) => $q->orderBy('order'),
            'revisions.user' => fn ($q) => $q,
            'updater' => fn ($q) => $q,
        ]);

        return view('admin.courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validated();
        $validated['is_paid'] = $request->boolean('is_paid') ? 1 : 0;
        if (!$validated['is_paid']) {
            $validated['price'] = null;
        }

        if (($validated['status'] ?? null) === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        if (($validated['status'] ?? null) !== 'published') {
            $validated['published_at'] = null;
        }

        // Create revision if description changed
        if ($course->description !== $validated['description']) {
            CourseRevision::create([
                'course_id' => $course->id,
                'user_id' => auth()->id(),
                'description' => $course->description,
            ]);
        }

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        $validated['updated_by'] = auth()->id();
        $course->update($validated);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Course updated successfully.');
    }

    public function destroy(Request $request, Course $course)
    {
        $this->authorize('delete', $course);

        if ($request->has('force') && $request->force == 1) {
            $course->forceDelete();
            return back()->with('success', 'Course permanently deleted.');
        }

        $course->delete();
        return back()->with('success', 'Course moved to trash.');
    }

    public function restore(Course $course)
    {
        $this->authorize('restore', $course);
        $course->restore();

        return back()->with('success', 'Course restored successfully.');
    }

    public function restoreRevision(Course $course, CourseRevision $revision)
    {
        $this->authorize('update', $course);
        if ((int) $revision->course_id !== (int) $course->id) {
            abort(404);
        }

        $course->update([
            'description' => $revision->description,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Course restored to revision from ' . $revision->created_at->format('M d, Y H:i'));
    }

    public function bulkAction(Request $request)
    {
        $this->authorize('viewAny', Course::class);

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:courses,id',
            'action' => 'required|in:publish,unpublish,delete,restore,force_delete',
        ]);

        $query = Course::withTrashed()->whereIn('id', $request->ids);
        $courses = $query->get();

        foreach ($courses as $course) {
            switch ($request->action) {
                case 'publish':
                    $course->update(['status' => 'published', 'published_at' => now(), 'updated_by' => auth()->id()]);
                    break;
                case 'unpublish':
                    $course->update(['status' => 'draft', 'published_at' => null, 'updated_by' => auth()->id()]);
                    break;
                case 'delete':
                    $course->delete();
                    break;
                case 'restore':
                    if ($course->trashed()) {
                        $course->restore();
                    }
                    break;
                case 'force_delete':
                    if ($course->trashed()) {
                        $course->forceDelete();
                    }
                    break;
            }
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}
