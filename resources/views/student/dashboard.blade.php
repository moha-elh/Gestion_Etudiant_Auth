<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Student Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-md overflow-hidden shadow-sm sm:rounded-lg border border-white/50">
                <div class="p-6 bg-transparent border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-20 w-20">
                            @if($user->photo)
                                <img class="w-full h-full rounded-full object-cover" src="{{ Str::startsWith($user->photo, 'http') ? $user->photo : asset('storage/' . $user->photo) }}" alt="" />
                            @else
                                <span class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            @endif
                        </div>
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
