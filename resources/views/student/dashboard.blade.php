<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Student Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <div class="text-xl font-medium text-gray-900">Welcome, {{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Academic Information</h3>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">CNE</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $student->cne ?? 'N/A' }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Sector</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $student->sector ?? 'N/A' }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">City</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $student->city ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
