@extends('layouts.guest')

@section('content')
    <!-- System Name -->
    <h1 class="text-3xl font-extrabold text-center mb-2 text-indigo-400">
        Charity Management System
    </h1>

    <!-- Page Title -->
    <h2 class="text-xl font-semibold text-center mb-6 text-gray-100">
        Forgot Password
    </h2>

    <p class="mb-4 text-sm text-gray-200 text-center">
        Forgot your password? No problem. Just enter your email address and we’ll send you a reset link.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-200" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                          class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                Back to login
            </a>

            <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Email Reset Link') }}
            </x-primary-button>
        </div>
    </form>
@endsection


