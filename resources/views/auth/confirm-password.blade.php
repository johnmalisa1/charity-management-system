@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
     style="background-image: url('/images/charity-bg.jpg');">

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Confirm Password Card -->
    <div class="relative z-10 w-full max-w-md bg-gray-900 text-gray-100 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Confirm Password</h2>

        <p class="mb-4 text-sm text-gray-400">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                              class="block mt-1 w-full bg-gray-800 text-gray-100 border-gray-700 rounded-md" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                    Back to login
                </a>

                <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

