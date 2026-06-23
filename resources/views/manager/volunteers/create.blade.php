@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Add Volunteer</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.volunteers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Select User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Activity Name</label>
                    <input type="text" name="activity_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Skills</label>
                    <input type="text" name="skills" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Availability</label>
                    <input type="text" name="availability" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Save Volunteer</button>
            </form>
        </div>
    </div>
</div>
@endsection

