@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Topluluk Profilleri</h1>
            <p class="text-gray-600 dark:text-gray-300">Topluluğumuzdaki diğer üyeleri keşfedin ve bağlantı kurun.</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form method="GET" action="{{ route('public.profiles.index') }}" class="max-w-2xl">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="İsim, yetenek, şehir ile ara...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Ara
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Profiles Grid -->
        @if($profiles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($profiles as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                        <!-- Cover -->
                        <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                        
                        <!-- Profile Info -->
                        <div class="px-6 pb-6">
                            <!-- Avatar -->
                            <div class="flex justify-center -mt-12 mb-4">
                                <img src="{{ $user->profile && $user->profile->avatar_path ? Storage::url($user->profile->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=96&background=6366f1&color=fff' }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-24 h-24 rounded-full border-4 border-white dark:border-gray-800 shadow-lg">
                            </div>

                            <!-- Name and Headline -->
                            <div class="text-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->profile && $user->profile->headline ? $user->profile->headline : 'Üye' }}</p>
                                @if($user->profile && ($user->profile->city || $user->profile->country))
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        @if($user->profile && $user->profile->city && $user->profile->country)
                                            {{ $user->profile->city }}, {{ $user->profile->country }}
                                        @elseif($user->profile && $user->profile->city)
                                            {{ $user->profile->city }}
                                        @elseif($user->profile && $user->profile->country)
                                            {{ $user->profile->country }}
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <!-- Skills -->
                            @if($user->profile && $user->profile->skills && count($user->profile->skills) > 0)
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1 justify-center">
                                        @foreach(array_slice($user->profile->skills, 0, 3) as $skill)
                                            <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded text-xs">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                        @if(count($user->profile->skills) > 3)
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-xs">
                                                +{{ count($user->profile->skills) - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Action Button -->
                            <div class="text-center">
                                <a href="{{ route('public.profiles.show', $user) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    Profili Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $profiles->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Profil bulunamadı</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if(request('q'))
                        Arama terimlerinizi değiştirmeyi deneyin.
                    @else
                        Şu anda herkese açık profil bulunmuyor.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection