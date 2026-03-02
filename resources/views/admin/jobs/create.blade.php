<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ui.create_job_posting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.jobs.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.title') }}</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.city') }}</label>
                                <input type="text" name="city" id="city" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div class="mb-4">
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.category') }}</label>
                                <input type="text" name="category" id="category" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('ui.description') }}</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('ui.active') }}</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('ui.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
