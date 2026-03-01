<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($course->thumbnail)
                    <img src="{{ Storage::disk('public')->url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-baseline">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">
                            {{ $course->is_paid ? '$' . $course->price : 'Free' }}
                        </span>
                        <span class="text-gray-500 text-xs">{{ $course->lessons_count }} Lessons</span>
                    </div>
                    
                    <h4 class="mt-2 font-semibold text-lg leading-tight truncate">{{ $course->title }}</h4>
                    <p class="mt-1 text-gray-500 text-sm line-clamp-2">{{ $course->description }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('courses.show', $course) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition duration-150">
                            View Course
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</x-app-layout>
