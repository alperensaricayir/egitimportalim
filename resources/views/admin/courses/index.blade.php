<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Courses') }}
            </h2>
            <a href="{{ route('admin.courses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Add New Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6 dark:bg-gray-900 dark:border dark:border-gray-700">
                <form action="{{ route('admin.courses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Title..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            <option value="">All Statuses</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div>
                        <label for="is_paid" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Type</label>
                        <select name="is_paid" id="is_paid" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            <option value="">All</option>
                            <option value="1" {{ request('is_paid') === '1' ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ request('is_paid') === '0' ? 'selected' : '' }}>Free</option>
                        </select>
                    </div>
                    <div>
                        <label for="trashed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deleted</label>
                        <select name="trashed" id="trashed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                            <option value="">Active Only</option>
                            <option value="with" {{ request('trashed') === 'with' ? 'selected' : '' }}>With Trashed</option>
                            <option value="only" {{ request('trashed') === 'only' ? 'selected' : '' }}>Only Trashed</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full dark:bg-gray-700 dark:hover:bg-gray-600">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions & List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
                <form action="{{ route('admin.courses.bulk_action') }}" method="POST" id="bulk-action-form">
                    @csrf
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between dark:border-gray-700">
                        <div class="flex items-center space-x-2">
                            <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish</option>
                                <option value="unpublish">Unpublish</option>
                                <option value="delete">Delete</option>
                                <option value="restore">Restore</option>
                                <option value="force_delete">Force Delete</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to apply this action to selected items?')">
                                Apply
                            </button>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-300">
                            {{ $courses->total() }} courses found
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4 dark:text-gray-300">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="group flex items-center">
                                            Title
                                            <!-- Sort icon logic here if needed -->
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'students_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Students
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                            Date
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @forelse($courses as $course)
                                    <tr class="{{ $course->trashed() ? 'bg-red-50 dark:bg-red-900/40' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="ids[]" value="{{ $course->id }}" class="course-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($course->thumbnail)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded object-cover" src="{{ Storage::disk('public')->url($course->thumbnail) }}" alt="">
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center dark:bg-gray-800">
                                                        <span class="text-gray-500 text-xs dark:text-gray-300">No Img</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $course->title }}
                                                        @if($course->trashed())
                                                            <span class="text-red-600 text-xs ml-2 dark:text-red-400">(Deleted)</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($course->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                   ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $course->is_paid ? '$' . $course->price : 'Free' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $course->users_count ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $course->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($course->trashed())
                                                <button type="button" onclick="confirmRestore('{{ $course->id }}')" class="text-green-600 hover:text-green-900 mr-3">Restore</button>
                                            @else
                                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            @endif
                                            
                                            <button type="button" onclick="confirmDelete('{{ $course->id }}', {{ $course->trashed() ? 'true' : 'false' }})" class="text-red-600 hover:text-red-900">
                                                {{ $course->trashed() ? 'Force Delete' : 'Delete' }}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300">
                                            No courses found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            
            <div class="mt-4">
                {{ $courses->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Hidden forms for individual actions -->
    @foreach($courses as $course)
        @if($course->trashed())
            <form id="restore-form-{{ $course->id }}" action="{{ route('admin.courses.restore', $course->id) }}" method="POST" class="hidden">
                @csrf
                @method('PUT')
            </form>
        @endif
        <form id="delete-form-{{ $course->id }}" action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
            @if($course->trashed())
                <input type="hidden" name="force" value="1">
            @endif
        </form>
    @endforeach

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.getElementsByClassName('course-checkbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });

        function confirmDelete(id, isForce) {
            var message = isForce ? 'Are you sure you want to permanently delete this course? This action cannot be undone.' : 'Are you sure you want to move this course to trash?';
            if (confirm(message)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function confirmRestore(id) {
            if (confirm('Restore this course from trash?')) {
                document.getElementById('restore-form-' + id).submit();
            }
        }
    </script>

</x-app-layout>
