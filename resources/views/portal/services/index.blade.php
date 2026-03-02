@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Üyelere Özel Hizmetler</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($services as $service)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    @if($service->image)
                        <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-48 h-full object-cover">
                    @endif
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-semibold mb-2">{{ $service->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        <div class="flex items-baseline gap-4">
                            @if($service->discounted_price)
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($service->discounted_price, 2) }} TL</span>
                                <span class="text-lg text-gray-400 line-through">{{ number_format($service->price, 2) }} TL</span>
                            @else
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($service->price, 2) }} TL</span>
                            @endif
                        </div>
                        <button class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition w-full">
                            Satın Al / Detay Gör
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Henüz hizmet eklenmemiş.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
