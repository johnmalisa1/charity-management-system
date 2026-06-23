@extends('layouts.app')

@section('title', 'Add Charity')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">➕ Add Charity</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.charities.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Charity Name</label>
            <input type="text" name="name" class="form-control bg-dark text-light border-secondary" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control bg-dark text-light border-secondary" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Registration Number</label>
            <input type="text" name="registration_number" class="form-control bg-dark text-light border-secondary" value="{{ old('registration_number') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Manager</label>
            <select name="manager_id" class="form-select bg-dark text-light border-secondary" required>
                <option value="">-- Select Manager --</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.charities.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-success">Save Charity</button>
        </div>
    </form>
</div>
@endsection
