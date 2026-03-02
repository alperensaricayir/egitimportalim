<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">
                Course
            </p>
            <h2 class="text-2xl font-semibold leading-tight text-gray-900">
                {{ $course->title }}
            </h2>
        </div>
    </x-slot>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="p-6 md:p-8">
            <div class="flex flex-col gap-8 md:flex-row md:items-start">
                <div class="md:w-1/3">
                    @if($course->thumbnail)
                        <img src="{{ Storage::disk('public')->url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full rounded-xl shadow-md">
                    @else
                        <div class="flex h-64 w-full items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                            No Image
                        </div>
                    @endif

                    <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-5">
                        <div class="mb-3 text-sm font-medium text-gray-500">
                            Course price
                        </div>
                        <div class="text-3xl font-bold text-gray-900">
                            {{ $course->is_paid ? '$' . $course->price : 'Free' }}
                        </div>

                        <div class="mt-4 text-xs text-gray-500">
                            {{ $course->lessons->count() }} lesson{{ $course->lessons->count() === 1 ? '' : 's' }} included
                        </div>
                        
                        <div class="mt-5">
                            @auth
                                @if(auth()->user()->courses->contains($course->id))
                                    <div class="w-full rounded-full bg-green-100 py-2.5 text-center text-sm font-semibold text-green-800">
                                        You are enrolled
                                    </div>
                                @else
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center justify-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                            Enroll now
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="flex w-full items-center justify-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                        Login to enroll
                                    </a>
                                @else
                                    <span class="block w-full rounded-full bg-gray-300 py-2.5 text-center text-sm font-semibold text-gray-600">
                                        Login feature not available
                                    </span>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="md:w-2/3">
                    <section class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Description
                        </h3>
                        <div class="mt-3 max-w-none text-sm leading-relaxed text-gray-600">
                            {{ $course->description }}
                        </div>
                    </section>

                    <section>
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">
                            Course content
                        </h3>
                        <div class="overflow-hidden rounded-2xl border border-gray-100">
                            @forelse($course->lessons as $lesson)
                                <div class="flex items-center justify-between gap-4 border-b last:border-b-0 bg-white px-4 py-3.5 text-sm transition hover:bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-xs font-semibold text-indigo-700">
                                            {{ $loop->iteration }}
                                        </span>
                                        <span class="font-medium text-gray-900">
                                            {{ $lesson->title }}
                                        </span>
                                    </div>
                                    
                                    @auth
                                        @if(auth()->user()->courses->contains($course->id) || in_array(auth()->user()->role, ['admin', 'editor'], true))
                                            <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="text-xs font-semibold uppercase tracking-wide text-indigo-600 hover:text-indigo-800">
                                                Start
                                            </a>
                                        @else
                                            <span class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                                Locked
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                            Locked
                                        </span>
                                    @endauth
                                </div>
                            @empty
                                <div class="px-4 py-6 text-sm text-gray-500">
                                    No lessons available yet.
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
