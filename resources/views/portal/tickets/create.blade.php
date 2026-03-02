@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Yeni Destek Talebi</h1>
        
        <div class="bg-white dark:bg-gray-900 dark:border dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konu</label>
                    <input
                        type="text"
                        name="subject"
                        id="subject"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                        placeholder="teknik / eğitim / üyelik / ödeme"
                    >
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mesajınız</label>
                    <textarea
                        name="message"
                        id="message"
                        rows="5"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                        required
                    ></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ekler (Görsel/Video)</label>
                    <input
                        type="file"
                        name="attachments[]"
                        multiple
                        accept="image/*,video/*"
                        class="block w-full text-sm text-gray-900 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white hover:file:bg-indigo-700 dark:text-gray-100"
                    >
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Birden fazla dosya seçebilirsiniz. Boyut sınırlaması uygulanmaz (sunucu limitleri hariç).</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bağlantılar (isteğe bağlı)</label>
                    <div id="links-container" class="space-y-2">
                        <input type="url" name="links[]" placeholder="https://örnek.com" class="block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                    </div>
                    <button type="button" id="add-link" class="mt-2 px-3 py-1.5 text-sm rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">+ Bağlantı Ekle</button>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var addBtn = document.getElementById('add-link');
    var container = document.getElementById('links-container');
    if (addBtn && container) {
        addBtn.addEventListener('click', function () {
            var input = document.createElement('input');
            input.type = 'url';
            input.name = 'links[]';
            input.placeholder = 'https://örnek.com';
            input.className = 'block w-full rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400';
            container.appendChild(input);
        });
    }
});
</script>
@endpush
