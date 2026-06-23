@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Add Participant</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.participants.store') }}" method="POST">
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
                    <label class="form-label">Event</label>
                    <select name="event_id" class="form-control" required>
                        <option value="">-- Select Event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Save Participant</button>
            </form>
        </div>
    </div>
</div>
@endsection
