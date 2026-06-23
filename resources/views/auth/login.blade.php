@extends('layouts.guest')

@section('content')
    <!-- System Name -->
    <h1 class="text-3xl font-extrabold text-center mb-2 text-indigo-400">
        Charity Management System
    </h1>

    <!-- Page Title -->
    <h2 class="text-xl font-semibold text-center mb-6 text-gray-100">
        Welcome Back
    </h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-200" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                          class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-200" />
            <x-text-input id="password" type="password" name="password" required
                          class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox"
                   class="rounded bg-gray-800 border-gray-600 text-indigo-500 focus:ring-indigo-500"
                   name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-200">Remember me</label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mb-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-indigo-300 hover:text-indigo-200">
                    Forgot your password?
                </a>
            @endif

            <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Register Link -->
    <p class="mt-6 text-center text-sm text-gray-200">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">
            Register here
        </a>
    </p>
@endsection





