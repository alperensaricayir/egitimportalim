<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket Details') }} #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</p>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $ticket->subject }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">User</p>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $ticket->user->name }} ({{ $ticket->user->email }})</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $ticket->status === 'open' ? 'green' : ($ticket->status === 'closed' ? 'gray' : 'blue') }}-100 text-{{ $ticket->status === 'open' ? 'green' : ($ticket->status === 'closed' ? 'gray' : 'blue') }}-800 dark:{{ $ticket->status === 'open' ? 'bg-green-800 text-green-100' : ($ticket->status === 'closed' ? 'bg-gray-700 text-gray-100' : 'bg-blue-800 text-blue-100') }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Priority</p>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ ucfirst($ticket->priority) }}</p>
                        </div>
                        <div class="col-span-2">
                             <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Message</p>
                             <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-900 rounded-md border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                                 {{ $ticket->message }}
                             </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="flex items-end gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Update Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>Answered</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Conversation</h3>
                    @forelse($ticket->messages as $message)
                        <div class="mb-4 p-4 rounded-lg {{ $message->user_id === $ticket->user_id ? 'bg-gray-50 dark:bg-gray-900' : 'bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800' }}">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold {{ $message->user_id === $ticket->user_id ? 'text-gray-700 dark:text-gray-300' : 'text-indigo-700 dark:text-indigo-300' }}">
                                    {{ $message->user->name }} {{ $message->user_id !== $ticket->user_id ? '(Staff)' : '' }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-800 dark:text-gray-200">{{ $message->message }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 italic">No replies yet.</p>
                    @endforelse

                    <div class="mt-6">
                        <form action="{{ route('tickets.reply', $ticket) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reply</label>
                                <textarea name="message" id="message" rows="3" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Send Reply
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
