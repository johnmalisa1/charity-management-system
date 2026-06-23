@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
     style="background-image: url('/images/charity-bg.jpg');">

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Verification Card -->
    <div class="relative z-10 w-full max-w-md bg-gray-900 text-gray-100 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Verify Your Email</h2>

        <p class="mb-4 text-sm text-gray-400">
            Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you. 
            If you didn’t receive the email, we’ll gladly send you another.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-400">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="flex items-center justify-between mt-4">
            <!-- Resend Verification -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Resend Email') }}
                </x-primary-button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="text-sm text-indigo-400 hover:text-indigo-300 underline">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

