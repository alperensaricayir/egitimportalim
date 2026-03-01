<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="text-gray-500 text-sm uppercase font-semibold">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['users'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="text-gray-500 text-sm uppercase font-semibold">Total Courses</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['courses'] }}</div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="text-gray-500 text-sm uppercase font-semibold">Total Enrollments</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['enrollments'] }}</div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ route('admin.courses.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Manage Courses &rarr;</a>
            </div>
        </div>
    </div>
</x-app-layout>
