@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">🎉 Create New Event</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" id="title" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="form-control bg-dark text-light border-secondary" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('location') }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('start_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('end_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="charity_id" class="form-label">Charity</label>
            <select name="charity_id" id="charity_id" class="form-select bg-dark text-light border-secondary" required>
                <option value="">-- Select Charity --</option>
                @foreach($charities as $charity)
                    <option value="{{ $charity->id }}">{{ $charity->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-success">Save Event</button>
        </div>
    </form>
</div>
@endsection
