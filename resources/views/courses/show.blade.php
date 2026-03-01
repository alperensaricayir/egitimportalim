<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="md:flex md:space-x-8">
                <div class="md:w-1/3 mb-6 md:mb-0">
                    @if($course->thumbnail)
                        <img src="{{ Storage::disk('public')->url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full rounded shadow-md">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400 rounded">
                            No Image
                        </div>
                    @endif

                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $course->is_paid ? '$' . $course->price : 'Free' }}
                        </div>
                        
                        @auth
                            @if(auth()->user()->courses->contains($course->id))
                                <div class="w-full py-3 bg-green-100 text-green-800 text-center rounded font-semibold">
                                    You are enrolled
                                </div>
                            @else
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded font-semibold transition duration-150">
                                        Enroll Now
                                    </button>
                                </form>
                            @endif
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded font-semibold transition duration-150">
                                    Login to Enroll
                                </a>
                            @else
                                <span class="block w-full py-3 bg-gray-300 text-gray-600 text-center rounded font-semibold">
                                    Login feature not available
                                </span>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="md:w-2/3">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <div class="prose max-w-none text-gray-600 mb-8">
                        {{ $course->description }}
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Course Content</h3>
                    <div class="border rounded-md overflow-hidden">
                        @forelse($course->lessons as $lesson)
                            <div class="flex items-center justify-between p-4 border-b last:border-b-0 hover:bg-gray-50">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-600 mr-3">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="font-medium text-gray-900">{{ $lesson->title }}</span>
                                </div>
                                
                                @auth
                                    @if(auth()->user()->courses->contains($course->id) || in_array(auth()->user()->role, ['admin', 'editor'], true))
                                        <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            Start
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">Locked</span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-sm">Locked</span>
                                @endauth
                            </div>
                        @empty
                            <div class="p-4 text-gray-500 italic">No lessons available yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
