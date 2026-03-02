@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="h-64 bg-gradient-to-r from-indigo-500 to-purple-600 relative">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <div class="p-8 pb-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
                    <div class="relative -mt-20">
                        <img src="{{ $profile->avatar_path ? Storage::url($profile->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=6366f1&color=fff' }}" 
                             alt="{{ $user->name }}" 
                             class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                            @unless($profile->is_public)
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    Gizli
                                </span>
                            @endunless
                        </div>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mt-1">{{ $profile->headline ?? 'Üye' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            @if($profile->city && $profile->country)
                                {{ $profile->city }}, {{ $profile->country }}
                            @elseif($profile->city)
                                {{ $profile->city }}
                            @elseif($profile->country)
                                {{ $profile->country }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8">
                @if($profile->bio)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Hakkında</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300">{{ $profile->bio }}</p>
                        </div>
                    </div>
                @endif

                @if($profile->skills && count($profile->skills) > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Yetenekler</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($profile->skills as $skill)
                                <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full text-sm">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($profile->website_url || $profile->linkedin_url || $profile->github_url || 
                     $profile->instagram_url || $profile->youtube_url || $profile->x_url || 
                     $profile->behance_url || $profile->dribbble_url)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Bağlantılar</h2>
                        <div class="flex flex-wrap gap-4">
                            @if($profile->website_url)
                                <a href="{{ $profile->website_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Web Sitesi</span>
                                </a>
                            @endif
                            @if($profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>LinkedIn</span>
                                </a>
                            @endif
                            @if($profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>GitHub</span>
                                </a>
                            @endif
                            @if($profile->instagram_url)
                                <a href="{{ $profile->instagram_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Instagram</span>
                                </a>
                            @endif
                            @if($profile->youtube_url)
                                <a href="{{ $profile->youtube_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>YouTube</span>
                                </a>
                            @endif
                            @if($profile->x_url)
                                <a href="{{ $profile->x_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>X</span>
                                </a>
                            @endif
                            @if($profile->behance_url)
                                <a href="{{ $profile->behance_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Behance</span>
                                </a>
                            @endif
                            @if($profile->dribbble_url)
                                <a href="{{ $profile->dribbble_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Dribbble</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

