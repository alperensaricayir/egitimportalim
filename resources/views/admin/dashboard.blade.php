<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ui.admin_dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['users'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Courses</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['courses'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="text-gray-500 text-sm uppercase font-semibold dark:text-gray-300">Total Enrollments</div>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['enrollments'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100">{{ __('ui.quick_actions') }}</h3>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-wrap gap-4 dark:bg-gray-900 dark:border-gray-700">
                @if(in_array(auth()->user()->role, ['admin','editor']))
                    <a href="{{ route('admin.courses.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.courses') }} &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.lessons.create', ['course' => optional(\App\Models\Course::first())->id]) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.lessons') }} &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.tickets.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.tickets') }} &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.announcements.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.announcements') }} &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.jobs.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.jobs') }} &rarr;</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.students') }} &rarr;</a>
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                    <a href="{{ route('admin.settings.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('ui.settings') }} &rarr;</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
