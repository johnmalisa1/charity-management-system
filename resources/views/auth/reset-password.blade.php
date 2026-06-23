@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
     style="background-image: url('/images/charity-bg.jpg');">

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Reset Card -->
    <div class="relative z-10 w-full max-w-md bg-gray-900 text-gray-100 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                              class="block mt-1 w-full bg-gray-800 text-gray-100 border-gray-700 rounded-md" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                              class="block mt-1 w-full bg-gray-800 text-gray-100 border-gray-700 rounded-md" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                              class="block mt-1 w-full bg-gray-800 text-gray-100 border-gray-700 rounded-md" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                    Back to login
                </a>

                <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

