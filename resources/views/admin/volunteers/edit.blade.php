@extends('layouts.app')

@section('title', 'Edit Volunteer')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">✏️ Edit Volunteer</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.volunteers.update', $volunteer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">Linked User</label>
            <select name="user_id" id="user_id" class="form-select bg-dark text-light border-secondary" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ $volunteer->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <input type="text" name="skills" id="skills"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('skills', $volunteer->skills) }}">
        </div>

        <div class="mb-3">
            <label for="availability" class="form-label">Availability</label>
            <textarea name="availability" id="availability" rows="3"
                      class="form-control bg-dark text-light border-secondary">{{ old('availability', $volunteer->availability) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select bg-dark text-light border-secondary">
                <option value="active" {{ $volunteer->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $volunteer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="pending" {{ $volunteer->status == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.volunteers.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Update Volunteer</button>
        </div>
    </form>
</div>
@endsection

