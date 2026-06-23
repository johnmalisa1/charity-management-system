@extends('layouts.app')

@section('title', 'Add Charity')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-center text-indigo-600">Add a New Charity</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('charities.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Charity Name</label>
            <input type="text" name="name" class="w-full mt-1 p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" class="w-full mt-1 p-2 border rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Registration Number</label>
            <input type="text" name="registration_number" class="w-full mt-1 p-2 border rounded" required>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500">
                Save Charity
            </button>
        </div>
    </form>
</div>
@endsection
