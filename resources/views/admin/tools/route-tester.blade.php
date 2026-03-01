<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Tools / Route Tester
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-50 text-green-800 rounded border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 text-red-800 rounded border border-red-200">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="p-4 bg-yellow-50 text-yellow-800 rounded border border-yellow-200">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Navigable GET pages -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">A) Navigable GET Pages</h3>
                        <ul class="list-disc pl-5 space-y-2 text-indigo-700">
                            <li><a class="hover:underline" href="{{ url('/') }}">/</a></li>
                            <li><a class="hover:underline" href="{{ route('courses.index') }}">/courses</a></li>
                            @if($firstCourse)
                                <li><a class="hover:underline" href="{{ route('courses.show', $firstCourse) }}">/courses/{{ $firstCourse->id }}</a></li>
                            @endif
                            <li><a class="hover:underline" href="{{ route('admin.dashboard') }}">/admin</a></li>
                            <li><a class="hover:underline" href="{{ route('admin.courses.index') }}">/admin/courses</a></li>
                            <li><a class="hover:underline" href="{{ route('admin.courses.create') }}">/admin/courses/create</a></li>
                            @if($firstCourse)
                                <li><a class="hover:underline" href="{{ route('admin.courses.edit', $firstCourse) }}">/admin/courses/{{ $firstCourse->id }}/edit</a></li>
                            @endif
                            @if($firstCourse && $firstLesson)
                                <li><a class="hover:underline" href="{{ route('admin.lessons.create', $firstCourse) }}">/admin/courses/{{ $firstCourse->id }}/lessons/create</a></li>
                                <li><a class="hover:underline" href="{{ route('admin.lessons.edit', [$firstCourse, $firstLesson]) }}">/admin/courses/{{ $firstCourse->id }}/lessons/{{ $firstLesson->id }}/edit</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Action routes -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">B) Action Routes (Forms)</h3>
                        <div class="space-y-6">
                            <!-- POST /courses/{course}/enroll -->
                            <div>
                                <h4 class="font-medium mb-2">Enroll Course (POST)</h4>
                                <form method="POST" data-template="/courses/{course}/enroll" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses->whereNull('deleted_at') as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Enroll</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/bulk-action -->
                            <div>
                                <h4 class="font-medium mb-2">Courses Bulk Action (POST)</h4>
                                <form method="POST" action="{{ route('admin.courses.bulk_action') }}">
                                    @csrf
                                    <label class="block text-sm text-gray-700 mb-1">Action</label>
                                    <select name="action" class="border rounded p-2 w-full mb-2">
                                        <option value="publish">publish</option>
                                        <option value="unpublish">unpublish</option>
                                        <option value="delete">delete</option>
                                        <option value="restore">restore</option>
                                        <option value="force_delete">force_delete</option>
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">IDs</label>
                                    <select name="ids[]" multiple size="4" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }} {{ $c->deleted_at ? '(trashed)' : '' }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Apply</button>
                                </form>
                            </div>

                            <!-- PUT /admin/courses/{course}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Course (PUT)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/restore" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    @method('PUT')
                                    <label class="block text-sm text-gray-700 mb-1">Trashed Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @forelse($courses->whereNotNull('deleted_at') as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }} (trashed)</option>
                                        @empty
                                            <option value="">No trashed course</option>
                                        @endforelse
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/revisions/{revision}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Course Revision (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/revisions/{revision}/restore" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">Course Revision</label>
                                    <select name="revision" class="border rounded p-2 w-full mb-2">
                                        @foreach($courseRevisions as $r)
                                            <option value="{{ $r->id }}">#{{ $r->id }} (course {{ $r->course_id }})</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons (store) -->
                            <div>
                                <h4 class="font-medium mb-2">Create Lesson (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses->whereNull('deleted_at') as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Title</label>
                                            <input name="title" class="border rounded p-2 w-full" value="Sample Lesson">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Order</label>
                                            <input name="order" type="number" class="border rounded p-2 w-full" value="1">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                                        <select name="status" class="border rounded p-2 w-full">
                                            <option value="draft">draft</option>
                                            <option value="published">published</option>
                                            <option value="archived">archived</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Content</label>
                                        <textarea name="content" rows="3" class="border rounded p-2 w-full">Body</textarea>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Create</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons/reorder -->
                            <div>
                                <h4 class="font-medium mb-2">Reorder Lessons (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/reorder" onsubmit="return setActionFromTemplate(this, true)">
                                    @csrf
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses->whereNull('deleted_at') as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                    <label class="block text-sm text-gray-700 mb-1">Order IDs (comma separated)</label>
                                    <input name="order_csv" class="border rounded p-2 w-full mb-2" value="{{ implode(',', $defaultLessonOrder) }}">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Submit</button>
                                </form>
                            </div>

                            <!-- PUT /admin/courses/{course}/lessons/{lesson} -->
                            <div>
                                <h4 class="font-medium mb-2">Update Lesson (PUT)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                @foreach($courses->whereNull('deleted_at') as $c)
                                                    <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                @foreach($lessons as $l)
                                                    <option value="{{ $l->id }}">{{ $l->id }} — {{ $l->title }} (c:{{ $l->course_id }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Order</label>
                                            <input name="order" type="number" class="border rounded p-2 w-full" value="{{ $firstLesson?->order ?? 1 }}">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                                        <select name="status" class="border rounded p-2 w-full">
                                            <option value="draft">draft</option>
                                            <option value="published">published</option>
                                            <option value="archived">archived</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Title</label>
                                        <input name="title" class="border rounded p-2 w-full" value="{{ $firstLesson?->title ?? 'Lesson' }}">
                                    </div>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-700 mb-1">Content</label>
                                        <textarea name="content" rows="3" class="border rounded p-2 w-full">{{ $firstLesson?->content ?? '...' }}</textarea>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Update</button>
                                </form>
                            </div>

                            <!-- DELETE /admin/courses/{course} -->
                            <div>
                                <h4 class="font-medium mb-2">Delete Course (DELETE)</h4>
                                <form method="POST" data-template="/admin/courses/{course}" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    @method('DELETE')
                                    <label class="block text-sm text-gray-700 mb-1">Course</label>
                                    <select name="course" class="border rounded p-2 w-full mb-2">
                                        @foreach($courses as $c)
                                            <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }} {{ $c->deleted_at ? '(trashed)' : '' }}</option>
                                        @endforeach
                                    </select>
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="force" value="1" class="rounded">
                                        <span class="text-sm text-gray-700">Force delete (if trashed)</span>
                                    </label>
                                    <div class="mt-2">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded text-sm" onclick="return confirm('Delete course?')">Delete</button>
                                    </div>
                                </form>
                            </div>

                            <!-- DELETE /admin/courses/{course}/lessons/{lesson} -->
                            <div>
                                <h4 class="font-medium mb-2">Delete Lesson (DELETE)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    @method('DELETE')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                @foreach($courses as $c)
                                                    <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                @foreach($lessons as $l)
                                                    <option value="{{ $l->id }}">{{ $l->id }} — {{ $l->title }} (c:{{ $l->course_id }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded text-sm" onclick="return confirm('Delete lesson?')">Delete</button>
                                </form>
                            </div>

                            <!-- POST /admin/courses/{course}/lessons/{lesson}/revisions/{revision}/restore -->
                            <div>
                                <h4 class="font-medium mb-2">Restore Lesson Revision (POST)</h4>
                                <form method="POST" data-template="/admin/courses/{course}/lessons/{lesson}/revisions/{revision}/restore" onsubmit="return setActionFromTemplate(this)">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Course</label>
                                            <select name="course" class="border rounded p-2 w-full">
                                                @foreach($courses as $c)
                                                    <option value="{{ $c->id }}">{{ $c->id }} — {{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Lesson</label>
                                            <select name="lesson" class="border rounded p-2 w-full">
                                                @foreach($lessons as $l)
                                                    <option value="{{ $l->id }}">{{ $l->id }} — {{ $l->title }} (c:{{ $l->course_id }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Revision</label>
                                            <select name="revision" class="border rounded p-2 w-full">
                                                @foreach($lessonRevisions as $r)
                                                    <option value="{{ $r->id }}">#{{ $r->id }} (l:{{ $r->lesson_id }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 px-3 rounded text-sm">Restore</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setActionFromTemplate(form, isReorder = false) {
            var template = form.getAttribute('data-template');
            if (!template) return true;
            var course = form.querySelector('[name="course"]')?.value;
            var lesson = form.querySelector('[name="lesson"]')?.value;
            var revision = form.querySelector('[name="revision"]')?.value;
            var action = template;
            if (course !== undefined) action = action.replace('{course}', encodeURIComponent(course));
            if (lesson !== undefined) action = action.replace('{lesson}', encodeURIComponent(lesson));
            if (revision !== undefined) action = action.replace('{revision}', encodeURIComponent(revision));
            form.setAttribute('action', action);

            if (isReorder) {
                var csv = form.querySelector('[name="order_csv"]')?.value || '';
                var ids = csv.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
                // Ensure we send order[] inputs
                // Remove old dynamic inputs
                form.querySelectorAll('input[name="order[]"]').forEach(function(el){ el.remove(); });
                ids.forEach(function(id) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'order[]';
                    input.value = id;
                    form.appendChild(input);
                });
            }
            return true;
        }
    </script>
</x-app-layout>
