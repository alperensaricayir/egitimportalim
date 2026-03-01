<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Lesson: {{ $lesson->title }}
            </h2>
            <div class="flex items-center space-x-2">
                @if($lesson->updated_by)
                    <span class="text-xs text-gray-500 mr-2">
                        Last updated by {{ $lesson->updater->name ?? 'Unknown' }} 
                        {{ $lesson->updated_at->diffForHumans() }}
                    </span>
                @endif
                <a href="{{ route('admin.courses.edit', $course) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-2">
                    Back to Course
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.lessons.update', [$course, $lesson]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Lesson Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title', $lesson->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (Embed)</label>
                            <input type="url" name="video_url" id="video_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('video_url', $lesson->video_url) }}">
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                            <input type="number" name="order" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('order', $lesson->order) }}" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="draft" {{ old('status', $lesson->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $lesson->status) === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $lesson->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700">Publish Date</label>
                                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $lesson->published_at ? $lesson->published_at->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_preview" id="is_preview" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="1" {{ old('is_preview', $lesson->is_preview) ? 'checked' : '' }}>
                            <label for="is_preview" class="ml-2 block text-sm text-gray-900">Is Preview? (Allow free access)</label>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea name="content" id="content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content', $lesson->content) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update Lesson
                            </button>
                        </div>
                    </form>
                </div>
            </div>

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
                                    <th class="px-4 py-2 text-left">Content (old)</th>
                                    <th class="px-4 py-2 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($lesson->revisions as $revision)
                                    <tr>
                                        <td class="px-4 py-2">{{ $revision->created_at->format('M d, H:i') }}</td>
                                        <td class="px-4 py-2">{{ $revision->user->name ?? 'Unknown' }}</td>
                                        <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($revision->content, 60) }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <form action="{{ route('admin.lessons.restore_revision', [$course, $lesson, $revision]) }}" method="POST" onsubmit="return confirm('Restore this version? Current data will be lost.');">
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
    </div>
</x-app-layout>
