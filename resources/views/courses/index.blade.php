<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-semibold text-gray-900">
                Learn something new today
            </h2>
            <p class="text-sm text-gray-500">
                Browse curated courses and keep improving your skills.
            </p>
        </div>
    </x-slot>

    <section class="mb-6 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500 px-6 py-8 text-white">
        <div class="max-w-3xl">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                Upgrade your skills with modern courses
            </h1>
            <p class="mt-3 text-sm sm:text-base text-indigo-100">
                Discover practical, up-to-date content designed to help you move faster in your learning journey.
            </p>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 text-xs sm:text-sm">
            <span class="rounded-full bg-white/10 px-3 py-1">
                Real-world projects
            </span>
            <span class="rounded-full bg-white/10 px-3 py-1">
                Lifetime access
            </span>
            <span class="rounded-full bg-white/10 px-3 py-1">
                Learn at your pace
            </span>
        </div>
    </section>

    <section>
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-900">
                All courses
            </h3>
            <span class="text-xs sm:text-sm text-gray-500">
                {{ $courses->total() }} course{{ $courses->total() === 1 ? '' : 's' }} available
            </span>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($courses as $course)
                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    @if($course->thumbnail)
                        <div class="relative">
                            <img
                                src="{{ Storage::disk('public')->url($course->thumbnail) }}"
                                alt="{{ $course->title }}"
                                class="h-44 w-full object-cover transition duration-200 group-hover:scale-[1.02]"
                            >
                        </div>
                    @else
                        <div class="flex h-44 w-full items-center justify-center bg-gray-100 text-sm font-medium text-gray-400">
                            No Image
                        </div>
                    @endif

                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-baseline justify-between gap-2 text-xs">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 font-semibold text-indigo-700">
                                {{ $course->is_paid ? '$' . $course->price : 'Free' }}
                            </span>
                            <span class="text-gray-500">
                                {{ $course->lessons_count }} lesson{{ $course->lessons_count === 1 ? '' : 's' }}
                            </span>
                        </div>

                        <h4 class="mt-3 line-clamp-2 text-sm sm:text-base font-semibold text-gray-900">
                            {{ $course->title }}
                        </h4>
                        <p class="mt-2 line-clamp-2 text-xs sm:text-sm text-gray-500">
                            {{ $course->description }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a
                                href="{{ route('courses.show', $course) }}"
                                class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                            >
                                View details
                                <span class="ml-1 text-xs">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    </section>
</x-app-layout>
