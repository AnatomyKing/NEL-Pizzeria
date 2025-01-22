<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name (User) -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" 
                          type="text" 
                          name="name" 
                          :value="old('name')" 
                          required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email (User) -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password (User) -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Password Confirmation -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" 
                          required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Additional Klant Fields -->
        <div class="mt-4">
            <x-input-label for="naam" value="Naam (Klant)"/>
            <x-text-input id="naam" class="block mt-1 w-full" 
                          type="text" 
                          name="naam" 
                          :value="old('naam')" 
                          required />
            <x-input-error :messages="$errors->get('naam')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="adres" value="Adres (Klant)"/>
            <x-text-input id="adres" class="block mt-1 w-full" 
                          type="text" 
                          name="adres" 
                          :value="old('adres')" 
                          required />
            <x-input-error :messages="$errors->get('adres')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="woonplaats" value="Woonplaats (Klant)"/>
            <x-text-input id="woonplaats" class="block mt-1 w-full" 
                          type="text" 
                          name="woonplaats" 
                          :value="old('woonplaats')" 
                          required />
            <x-input-error :messages="$errors->get('woonplaats')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="telefoonnummer" value="Telefoonnummer (Klant)"/>
            <x-text-input id="telefoonnummer" class="block mt-1 w-full" 
                          type="text" 
                          name="telefoonnummer" 
                          :value="old('telefoonnummer')" 
                          required />
            <x-input-error :messages="$errors->get('telefoonnummer')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="emailadres" value="E-mailadres (Klant)"/>
            <x-text-input id="emailadres" class="block mt-1 w-full" 
                          type="email" 
                          name="emailadres" 
                          :value="old('emailadres')" 
                          required />
            <x-input-error :messages="$errors->get('emailadres')" class="mt-2" />
        </div>
        <!-- End Additional Klant Fields -->

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" 
               href="{{ route('login') }}">
               {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
