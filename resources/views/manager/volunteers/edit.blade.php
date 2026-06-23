@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Edit Volunteer</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.volunteers.update', $volunteer->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $volunteer->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Skills</label>
                    <input type="text" name="skills" value="{{ $volunteer->skills }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Availability</label>
                    <input type="text" name="availability" value="{{ $volunteer->availability }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ $volunteer->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $volunteer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ $volunteer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Volunteer</button>
            </form>
        </div>
    </div>
</div>
@endsection
