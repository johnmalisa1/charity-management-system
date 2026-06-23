@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Edit Participant</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.participants.update', $participant->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $participant->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="event_id" class="form-control" required>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $participant->event_id == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" value="{{ $participant->role }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Update Participant</button>
            </form>
        </div>
    </div>
</div>
@endsection
