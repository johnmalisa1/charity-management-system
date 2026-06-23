@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Participants</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('manager.participants.create') }}" class="btn btn-primary">+ Add Participant</a>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Event</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->user->name }}</td>
                            <td>{{ $participant->user->email }}</td>
                            <td>{{ $participant->event->title }}</td>
                            <td>{{ $participant->role ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('manager.participants.edit', $participant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('manager.participants.destroy', $participant->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this participant?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $participants->links() }}
        </div>
    </div>
</div>
@endsection

