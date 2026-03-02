@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-full overflow-hidden mb-6">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-5xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-lg mb-4">{{ $user->city ?? 'Konum Yok' }}</p>
                    
                    <div class="flex gap-4 mb-6">
                        @foreach($user->socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" class="text-gray-600 hover:text-indigo-600">
                                {{ ucfirst($link->platform) }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex gap-2">
                        <span class="px-4 py-2 bg-gray-100 rounded text-gray-700 font-semibold">
                            {{ $user->likesReceived->count() }} Beğeni
                        </span>
                        @auth
                            <form action="{{ route('profiles.like', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition disabled:opacity-50"
                                        {{ $likedToday || auth()->id() === $user->id ? 'disabled' : '' }}>
                                    {{ $likedToday ? 'Bugün Beğenildi' : 'Beğen' }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <h2 class="text-2xl font-bold mb-4">Hakkında</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $user->bio ?? 'Biyografi eklenmemiş.' }}</p>

                    @if($user->email)
                        <h3 class="text-xl font-bold mt-8 mb-2">İletişim</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
