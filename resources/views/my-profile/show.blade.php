@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Cover Area -->
    <div class="h-64 bg-gradient-to-r from-indigo-500 to-purple-600 relative">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    </div>

    <!-- Profile Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <!-- Profile Header -->
            <div class="p-8 pb-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
                    <!-- Avatar -->
                    <div class="relative -mt-20">
                        <img src="{{ $profile && $profile->avatar_path ? Storage::url($profile->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=6366f1&color=fff' }}" 
                             alt="{{ $user->name }}" 
                             class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>

                    <!-- Name and Headline -->
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mt-1">{{ $profile ? ($profile->headline ?? 'Üye') : 'Üye' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            @if($profile && $profile->city && $profile->country)
                                {{ $profile->city }}, {{ $profile->country }}
                            @elseif($profile && $profile->city)
                                {{ $profile->city }}
                            @elseif($profile && $profile->country)
                                {{ $profile->country }}
                            @endif
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <a href="{{ route('my.profile.edit') }}" 
                           class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Profili Düzenle
                        </a>
                        @if($profile && $profile->is_public)
                            <a href="{{ route('public.profiles.show', $user) }}" 
                               target="_blank"
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Herkese Açık Profil
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="px-8 pb-8">
                <!-- About Section -->
                @if($profile && $profile->bio)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Hakkında</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300">{{ $profile->bio }}</p>
                        </div>
                    </div>
                @endif

                <!-- Skills Section -->
                @if($profile && $profile->skills && count($profile->skills) > 0)
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

                <!-- Social Links -->
                @if($profile && ($profile->website_url || $profile->linkedin_url || $profile->github_url || 
                     $profile->instagram_url || $profile->youtube_url || $profile->x_url || 
                     $profile->behance_url || $profile->dribbble_url))
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Bağlantılar</h2>
                        <div class="flex flex-wrap gap-4">
                            @if($profile->website_url)
                                <a href="{{ $profile->website_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    Web Sitesi
                                </a>
                            @endif
                            @if($profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    LinkedIn
                                </a>
                            @endif
                            @if($profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                    GitHub
                                </a>
                            @endif
                            @if($profile->instagram_url)
                                <a href="{{ $profile->instagram_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    Instagram
                                </a>
                            @endif
                            @if($profile->youtube_url)
                                <a href="{{ $profile->youtube_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    YouTube
                                </a>
                            @endif
                            @if($profile->x_url)
                                <a href="{{ $profile->x_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    X (Twitter)
                                </a>
                            @endif
                            @if($profile->behance_url)
                                <a href="{{ $profile->behance_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.938 4.503c.702 0 1.34.06 1.92.188.577.13 1.07.33 1.485.61.41.28.733.65.96 1.12.225.47.34 1.05.34 1.73 0 .74-.17 1.36-.507 1.86-.338.5-.837.9-1.502 1.22.906.26 1.576.72 2.022 1.37.448.66.665 1.45.665 2.36 0 .75-.13 1.39-.41 1.93-.28.55-.67 1-1.16 1.35-.48.348-1.05.6-1.67.76-.62.16-1.25.24-1.91.24H0V4.51h6.938v-.007zM16.94 16.665c.44.428 1.073.643 1.894.643.59 0 1.1-.148 1.53-.447.424-.3.68-.77.78-1.4h2.588c-.403 1.28-1.048 2.2-1.9 2.75-.85.56-1.884.83-3.08.83-.837 0-1.584-.13-2.272-.4-.673-.27-1.24-.65-1.72-1.14-.464-.49-.823-1.08-1.077-1.77-.253-.69-.373-1.45-.373-2.27 0-.803.135-1.54.403-2.23.27-.7.644-1.28 1.12-1.79.495-.51 1.063-.9 1.736-1.194.673-.3 1.405-.45 2.207-.45.86 0 1.622.16 2.277.48.656.32 1.204.77 1.627 1.35.424.58.65 1.24.68 1.98h-2.588c-.05-.56-.23-1.02-.55-1.37-.32-.35-.77-.52-1.36-.52-.423 0-.78.1-1.07.3-.29.2-.52.46-.69.79-.17.33-.29.7-.36 1.11-.07.41-.1.81-.1 1.21 0 .4.03.8.1 1.21.07.41.19.78.36 1.11.17.33.4.59.69.79.29.2.65.3 1.07.3.59 0 1.037-.17 1.35-.52.32-.35.5-.81.55-1.37zM6.95 7.154h3.24c.56 0 1.03-.13 1.41-.39.38-.26.57-.7.57-1.32 0-.6-.19-1.04-.57-1.32-.38-.28-.85-.42-1.41-.42H6.95v3.45zm0 5.64h3.99c.65 0 1.19-.15 1.62-.46.43-.3.65-.8.65-1.48 0-.67-.22-1.17-.65-1.48-.43-.3-.97-.45-1.62-.45H6.95v3.87z"/>
                                    </svg>
                                    Behance
                                </a>
                            @endif
                            @if($profile->dribbble_url)
                                <a href="{{ $profile->dribbble_url }}" target="_blank" 
                                   class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.374 0 0 5.374 0 12s5.374 12 12 12 12-5.374 12-12S18.626 0 12 0zm8.568 7.161c1.85 1.85 2.861 4.463 2.861 7.339 0 .638-.052 1.267-.152 1.883-1.126-.246-2.43-.468-3.865-.468-.758 0-1.492.083-2.193.235.041-.28.062-.565.062-.853 0-2.71-1.33-5.123-3.366-6.612.052-.041.103-.083.155-.124 1.35.675 2.573 1.65 3.548 2.797zm-2.86 2.797c.041.103.082.206.123.309-1.605.929-3.433 1.421-5.392 1.421-.827 0-1.635-.103-2.418-.298.103-1.462.516-2.833 1.135-4.086.885.258 1.799.413 2.75.413 1.544 0 2.998-.361 4.24-.999.309.619.515 1.288.6 2.018zm-6.704-3.959c1.298.515 2.38 1.443 3.075 2.585-.72.206-1.462.319-2.234.319-.999 0-1.957-.196-2.853-.566.309-.876.772-1.668 1.381-2.338.206-.103.412-.206.631-.309zm-1.134 4.086c.876.309 1.812.474 2.793.474.947 0 1.85-.155 2.709-.44-.155.876-.464 1.688-.904 2.43-.72-.464-1.544-.74-2.43-.74-.947 0-1.85.216-2.668.618-.206-.721-.33-1.474-.33-2.257 0-.257.021-.515.062-.772zm-.618 3.075c-.876-.309-1.668-.772-2.338-1.381.67-.618 1.462-1.072 2.338-1.381.103.206.206.412.309.631-.515.515-.876 1.155-1.072 1.85-.103-.041-.206-.082-.309-.123zm3.075 2.86c1.35-.675 2.573-1.65 3.548-2.797.041.052.083.103.124.155-1.35.67-2.573 1.65-3.548 2.797-.041-.052-.083-.103-.124-.155zm4.086-1.134c.876-.309 1.688-.464 2.585-.464.783 0 1.544.124 2.257.33-.309.876-.772 1.668-1.381 2.338-.618-.67-1.35-1.134-2.234-1.298-.103-.309-.206-.618-.227-.906z"/>
                                    </svg>
                                    Dribbble
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Activity Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Activity</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $user->enrollments()->count() }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">Courses Enrolled</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $user->supportTickets()->count() }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">Support Tickets</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $user->likesGiven()->count() }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">Likes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
