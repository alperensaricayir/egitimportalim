<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                   <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                   <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
                   <!-- Add profile form here if needed -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
