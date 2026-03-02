@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Üyelik Paketleri</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($plans as $plan)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold">{{ $plan->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $plan->is_premium ? 'Premium plan' : 'Standart plan' }}</p>
                    <div class="mt-4">
                        @if(isset($current) && $current && $current->id === $plan->id)
                            <form action="{{ route('plans.unsubscribe') }}" method="POST">
                                @csrf
                                <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Aboneliği Sonlandır</button>
                            </form>
                        @else
                            <form action="{{ route('plans.subscribe', $plan) }}" method="POST">
                                @csrf
                                <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Abone Ol</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
</div>
@endsection

