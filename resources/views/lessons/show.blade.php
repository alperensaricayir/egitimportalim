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

    <div class="mx-auto max-w-4xl">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="p-6 md:p-8">
                @if($lesson->video_url)
                    <div class="mb-6 overflow-hidden rounded-xl bg-black">
                        <iframe
                            src="{{ $lesson->video_url }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="h-64 w-full md:h-96"
                        ></iframe>
                    </div>
                @endif

                <div class="mb-8 text-sm leading-relaxed text-gray-700">
                    {!! nl2br(e($lesson->content)) !!}
                </div>

                <div class="mt-6 flex items-center justify-between border-t pt-6 text-sm">
                    @if($previous)
                        <a href="{{ route('lessons.show', [$course, $previous]) }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            &larr; Previous lesson
                        </a>
                    @else
                        <span></span>
                    @endif

                    @if($next)
                        <a href="{{ route('lessons.show', [$course, $next]) }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                            Next lesson &rarr;
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course) }}" class="font-semibold text-green-600 hover:text-green-800">
                            Complete course
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
