@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">✏️ Edit Campaign</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST">
        @csrf
        @method('PUT')   {{-- ✅ Use PUT to match your route definition --}}

        <div class="mb-3">
            <label for="title" class="form-label">Campaign Title</label>
            <input type="text" name="title" id="title"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('title', $campaign->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="form-control bg-dark text-light border-secondary" required>{{ old('description', $campaign->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="goal_amount" class="form-label">Goal Amount</label>
            <input type="number" name="goal_amount" id="goal_amount"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('goal_amount', $campaign->goal_amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="charity_id" class="form-label">Charity</label>
            <select name="charity_id" id="charity_id" class="form-select bg-dark text-light border-secondary" required>
                @foreach($charities as $charity)
                    <option value="{{ $charity->id }}" 
                        {{ $campaign->charity_id == $charity->id ? 'selected' : '' }}>
                        {{ $charity->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ✅ Added Start and End Dates --}}
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('start_date', $campaign->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('end_date', $campaign->end_date) }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Update Campaign</button>
        </div>
    </form>
</div>
@endsection

