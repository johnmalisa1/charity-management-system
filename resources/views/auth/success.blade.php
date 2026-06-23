@extends('layouts.guest')

@section('content')
    <!-- System Name -->
    <h1 class="text-3xl font-extrabold text-center mb-2 text-indigo-400">
        Charity Management System
    </h1>

    <!-- Success Title -->
    <div class="flex flex-col items-center mb-6">
        <!-- Animated Checkmark -->
        <svg class="w-16 h-16 text-green-400 animate-bounce mb-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 13l4 4L19 7" />
        </svg>

        <h2 class="text-3xl font-bold text-green-400">
            🎉 Success!
        </h2>
    </div>

    <!-- Message -->
    <p class="mb-6 text-sm text-gray-200 text-center">
        Your action was completed successfully. You can now continue to your dashboard and start using the system.
    </p>

    <!-- Action Button -->
    <div class="flex justify-center">
        <a href="{{ route('dashboard') }}" 
           class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition">
            Go to Dashboard
        </a>
    </div>
@endsection


