@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Üye Profilleri</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($users as $user)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-6">
                    <div class="w-24 h-24 mx-auto bg-gray-200 rounded-full overflow-hidden mb-4">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-3xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mb-2">{{ $user->city ?? 'Konum Yok' }}</p>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $user->bio }}</p>
                    <a href="{{ route('public.profiles.show', $user) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition">
                        Profili Gör
                    </a>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">Henüz profil oluşturulmamış.</p>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
