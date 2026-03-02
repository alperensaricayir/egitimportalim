@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">{{ __('ui.products_title') }}</h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900 dark:border dark:border-gray-700">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($products as $product)
                    <li class="p-6 hover:bg-gray-50 transition dark:hover:bg-gray-800">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $product->title }}</h3>
                                <div class="mt-2 text-gray-600 dark:text-gray-300">{{ $product->description }}</div>
                                <div class="mt-2 flex items-center gap-2">
                                    @if($product->discounted_price)
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format($product->discounted_price, 2) }} TL</span>
                                        <span class="text-sm text-gray-400 line-through dark:text-gray-500">{{ number_format($product->price, 2) }} TL</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ number_format($product->price, 2) }} TL</span>
                                    @endif
                                </div>
                            </div>
                            <button class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-50 transition dark:border-indigo-400 dark:text-indigo-300 dark:hover:bg-indigo-950/40">
                                Detaylar
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="p-6 text-gray-500 text-center dark:text-gray-300">Şu anda listelenecek ürün bulunmuyor.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
