@extends('layouts.guest')

@section('content')
    <!-- System Name -->
    <h1 class="text-3xl font-extrabold text-center mb-2 text-indigo-400">
        Charity Management System
    </h1>

    <!-- Page Title -->
    <h2 class="text-xl font-semibold text-center mb-6 text-gray-100">
        Create Account
    </h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" class="text-gray-200" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                          class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-200" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required
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

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-200" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                          class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Role Selection -->
        <div class="mb-4">
            <x-input-label for="role" :value="__('Role')" class="text-gray-200" />
            <select id="role" name="role" required
                    class="block mt-1 w-full bg-gray-800/70 text-gray-100 border-gray-600 rounded-md">
                <option value="">-- Select Role --</option>
                <option value="Donor">Donor</option>
                <option value="Volunteer">Volunteer</option>
                <option value="Manager">Manager</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-400" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                Already registered?
            </a>

            <x-primary-button class="ml-3 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
@endsection



