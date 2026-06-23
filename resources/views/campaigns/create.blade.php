@extends('layouts.app')

@section('title', 'Add Campaign')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-center text-green-600">Add a New Campaign</h1>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Campaign form --}}
    <form method="POST" action="{{ route('campaigns.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Campaign Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full mt-1 p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" class="w-full mt-1 p-2 border rounded">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Goal Amount</label>
            <input type="number" name="goal_amount" value="{{ old('goal_amount') }}"
                   class="w-full mt-1 p-2 border rounded" required>
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                       class="w-full mt-1 p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                       class="w-full mt-1 p-2 border rounded" required>
            </div>
        </div>

        <div class="text-center">
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500">
                Save Campaign
            </button>
        </div>
    </form>
</div>
@endsection

