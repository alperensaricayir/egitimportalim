<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }} - {{ $lesson->title }}
            </h2>
            <a href="{{ route('courses.show', $course) }}" class="text-sm text-indigo-600 hover:underline">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($lesson->video_url)
                    <div class="aspect-w-16 aspect-h-9 mb-6">
                        <iframe src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-96 rounded"></iframe>
                    </div>
                @endif

                <div class="prose max-w-none mb-8">
                    {!! nl2br(e($lesson->content)) !!}
                </div>

                <div class="flex justify-between border-t pt-6 mt-6">
                    @if($previous)
                        <a href="{{ route('lessons.show', [$course, $previous]) }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            &larr; Previous Lesson
                        </a>
                    @else
                        <span></span>
                    @endif

                    @if($next)
                        <a href="{{ route('lessons.show', [$course, $next]) }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            Next Lesson &rarr;
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course) }}" class="text-green-600 hover:text-green-800 font-semibold">
                            Complete Course
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
