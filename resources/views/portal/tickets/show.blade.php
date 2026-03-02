@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 dark:border dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ticket->subject }}</h1>
                    <div class="mt-1 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ $ticket->created_at->format('d.m.Y H:i') }}</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <span>{{ ucfirst($ticket->priority) }} Öncelik</span>
                        @if($ticket->sla_due_at)
                            <span class="{{ $ticket->sla_due_at->isPast() && $ticket->status !== 'closed' ? 'text-red-600 dark:text-red-400' : '' }}">
                                SLA: {{ $ticket->sla_due_at->format('d.m.Y H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <p class="text-gray-700 dark:text-gray-100 whitespace-pre-line bg-gray-50 dark:bg-gray-800 p-4 rounded">{{ $ticket->message }}</p>
        </div>

        <div class="space-y-6">
            @foreach($ticket->messages as $message)
                <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-3/4 {{ $message->user_id === auth()->id() ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-700' }} rounded-lg p-4 shadow-sm">
                        <div class="flex items-center gap-2 mb-1 text-xs text-gray-500 dark:text-gray-400">
                            <span class="font-bold {{ $message->user_id === auth()->id() ? 'text-indigo-700 dark:text-indigo-200' : 'text-gray-700 dark:text-gray-200' }}">
                                {{ $message->user->name }}
                            </span>
                            <span>{{ $message->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-100 whitespace-pre-line">{{ $message->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        @if($ticket->attachments && $ticket->attachments->count() > 0)
            <div class="mt-8 bg-white dark:bg-gray-900 dark:border dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Ekler</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($ticket->attachments as $att)
                        @if($att->type === 'image' && $att->path)
                            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                <img src="{{ Storage::url($att->path) }}" alt="{{ $att->original_name }}" class="w-full h-48 object-cover">
                                <div class="p-2 text-xs text-gray-600 dark:text-gray-300 truncate">{{ $att->original_name }}</div>
                            </div>
                        @elseif($att->type === 'video' && $att->path)
                            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-2">
                                <video controls class="w-full h-48 rounded">
                                    <source src="{{ Storage::url($att->path) }}" type="{{ $att->mime }}">
                                </video>
                                <div class="mt-2 text-xs text-gray-600 dark:text-gray-300 truncate">{{ $att->original_name }}</div>
                            </div>
                        @elseif($att->type === 'link' && $att->url)
                            <a href="{{ $att->url }}" target="_blank" class="block rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-3 text-sm text-indigo-700 dark:text-indigo-300 hover:bg-gray-50 dark:hover:bg-gray-800 truncate">
                                {{ $att->url }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-8 bg-white dark:bg-gray-900 dark:border dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Yanıt Yaz</h3>
            <form action="{{ route('tickets.reply', $ticket) }}" method="POST">
                @csrf
                <textarea
                    name="message"
                    rows="3"
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-4 bg-white text-gray-900 placeholder-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                    placeholder="Mesajınız..."
                    required
                ></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Yanıtla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
