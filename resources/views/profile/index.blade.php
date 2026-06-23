@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-8 text-center text-indigo-600">My Profile</h1>

    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <div class="flex items-center space-x-6">
            <img src="{{ $user->profile_image ? asset($user->profile_image) : asset('images/default-avatar.png') }}" 
                 class="w-20 h-20 rounded-full border-2 border-indigo-500" alt="Profile Picture">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold bg-indigo-100 text-indigo-700 rounded-full">
                    Role: {{ $user->role }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('profile.edit') }}" 
           class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow text-center hover:bg-indigo-50 dark:hover:bg-gray-600 transition">
            <h3 class="font-semibold text-gray-700 dark:text-gray-200">Edit Profile</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Update your details</p>
        </a>
        <a href="{{ route('profile.update') }}" 
           class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow text-center hover:bg-indigo-50 dark:hover:bg-gray-600 transition">
            <h3 class="font-semibold text-gray-700 dark:text-gray-200">Change Password</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Secure your account</p>
        </a>
        <a href="{{ route('dashboard') }}" 
           class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow text-center hover:bg-indigo-50 dark:hover:bg-gray-600 transition">
            <h3 class="font-semibold text-gray-700 dark:text-gray-200">Back to Dashboard</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Return to main view</p>
        </a>
    </div>

    <!-- Placeholder for Role-Specific Content -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Profile Overview</h3>
        <p class="text-gray-600 dark:text-gray-400">
            This is your profile dashboard. Role-specific content (Admin KPIs, Donor donations, Volunteer campaigns, Manager campaigns) will appear here depending on your account type.
        </p>
    </div>
</div>
@endsection

