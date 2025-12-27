<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you please complete your profile information?') }}
    </div>

    <form method="POST" action="{{ route('student.complete-registration.store') }}">
        @csrf

        <!-- CNE -->
        <div>
            <x-input-label for="cne" :value="__('CNE')" />
            <x-text-input id="cne" class="block mt-1 w-full" type="text" name="cne" :value="old('cne')" required autofocus />
            <x-input-error :messages="$errors->get('cne')" class="mt-2" />
        </div>

        <!-- Sector -->
        <div class="mt-4">
            <x-input-label for="sector" :value="__('Sector')" />
            <x-text-input id="sector" class="block mt-1 w-full" type="text" name="sector" :value="old('sector')" required />
            <x-input-error :messages="$errors->get('sector')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Complete Registration') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
