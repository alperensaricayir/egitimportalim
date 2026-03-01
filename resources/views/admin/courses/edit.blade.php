<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Course') }}
            </h2>
            <div class="flex items-center space-x-2">
                @if($course->updated_by)
                    <span class="text-xs text-gray-500 mr-2">
                        Last updated by {{ $course->updater->name ?? 'Unknown' }} 
                        {{ $course->updated_at->diffForHumans() }}
                    </span>
                @endif
                <a href="{{ route('courses.show', $course) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 mr-2">
                    View Public
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Course Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Details</h3>
                            <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title', $course->title) }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('description', $course->description) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="archived" {{ old('status', $course->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="published_at" class="block text-sm font-medium text-gray-700">Publish Date</label>
                                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $course->published_at ? $course->published_at->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">Thumbnail</label>
                                    @if($course->thumbnail)
                                        <div class="mb-2">
                                            <img src="{{ Storage::disk('public')->url($course->thumbnail) }}" alt="Current Thumbnail" class="h-20 w-20 object-cover rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="thumbnail" id="thumbnail" class="mt-1 block w-full">
                                </div>

                                <div class="mb-4 flex items-center">
                                    <input type="hidden" name="is_paid" value="0">
                                    <input type="checkbox" name="is_paid" id="is_paid" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="1" {{ old('is_paid', $course->is_paid) ? 'checked' : '' }}>
                                    <label for="is_paid" class="ml-2 block text-sm text-gray-900">Is Paid?</label>
                                </div>

                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('price', $course->price) }}">
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                        Update Course
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        (function(){
                            var cb = document.getElementById('is_paid');
                            var price = document.getElementById('price');
                            function sync() {
                                var enabled = cb.checked;
                                price.disabled = !enabled;
                                price.closest('div').style.opacity = enabled ? '1' : '0.6';
                            }
                            if (cb && price) {
                                cb.addEventListener('change', sync);
                                sync();
                            }
                        })();
                    </script>

                    <!-- Revisions History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Revision History</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left">Date</th>
                                            <th class="px-4 py-2 text-left">User</th>
                                            <th class="px-4 py-2 text-left">Description (old)</th>
                                            <th class="px-4 py-2 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($course->revisions as $revision)
                                            <tr>
                                                <td class="px-4 py-2">{{ $revision->created_at->format('M d, H:i') }}</td>
                                                <td class="px-4 py-2">{{ $revision->user->name ?? 'Unknown' }}</td>
                                                <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($revision->description, 60) }}</td>
                                                <td class="px-4 py-2 text-right">
                                                    <form action="{{ route('admin.courses.restore_revision', [$course, $revision]) }}" method="POST" onsubmit="return confirm('Restore this version? Current data will be lost.');">
                                                        @csrf
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restore</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">No revisions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lessons Management -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Lessons</h3>
                                <a href="{{ route('admin.lessons.create', $course) }}" class="text-sm bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded">
                                    Add Lesson
                                </a>
                            </div>
                            
                            @if($course->lessons->count() > 0)
                                <div class="mb-4 text-xs text-gray-500">
                                    Drag and drop to reorder (Coming Soon)
                                </div>
                            @endif

                            <ul class="divide-y divide-gray-200">
                                @forelse($course->lessons as $lesson)
                                    <li class="py-3 flex justify-between items-center group">
                                        <div class="flex items-center">
                                            <span class="text-gray-400 mr-2 cursor-move">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                            </span>
                                            <div>
                                                <div class="flex items-center">
                                                    <span class="text-gray-900 font-medium text-sm">{{ $lesson->title }}</span>
                                                    @if($lesson->status !== 'published')
                                                        <span class="ml-2 px-1.5 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                            {{ ucfirst($lesson->status) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $lesson->is_preview ? 'Preview' : 'Locked' }} • {{ $lesson->updated_at->format('M d') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                            <form action="{{ route('admin.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('Delete lesson?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Del</button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-3 text-gray-500 italic text-sm text-center">
                                        No lessons yet.<br>
                                        <a href="{{ route('admin.lessons.create', $course) }}" class="text-indigo-600 hover:text-indigo-500 mt-1 inline-block">Create the first one</a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
