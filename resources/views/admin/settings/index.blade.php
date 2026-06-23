@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-100">⚙️ Settings</h1>

    @if(session('success'))
        <div class="bg-green-700 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 text-gray-100 shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Site Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                       class="mt-1 block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Timezone</label>
                <input type="text" name="timezone" value="{{ $settings['timezone'] ?? '' }}"
                       class="mt-1 block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Currency</label>
                <input type="text" name="currency" value="{{ $settings['currency'] ?? '' }}"
                       class="mt-1 block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection



