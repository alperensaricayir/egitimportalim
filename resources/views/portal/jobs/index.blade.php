@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">{{ __('ui.jobs_title') }}</h1>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($jobs as $job)
                    <li class="p-6 hover:bg-gray-50 transition dark:hover:bg-gray-800">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $job->title }}</h3>
                                <div class="mt-1 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-300">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $job->city ?? 'Konum Belirtilmemiş' }}
                                    </span>
                                    <span class="bg-gray-100 px-2 py-1 rounded text-xs dark:bg-gray-800 dark:text-gray-100">{{ $job->category }}</span>
                                    <span>{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $job->description }}</p>
                            </div>
                            <button class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50 transition dark:border-indigo-400 dark:text-indigo-300 dark:hover:bg-indigo-950/40">
                                Başvur
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="p-6 text-gray-500 text-center dark:text-gray-300">Şu anda açık iş ilanı bulunmuyor.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
