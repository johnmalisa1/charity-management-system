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
                        <th>Event</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paginated as $participant)
                        <tr>
                            <td>{{ $participant['event'] }}</td>
                            <td>{{ $participant['name'] }}</td>
                            <td>{{ $participant['email'] }}</td>
                            <td>{{ $participant['role'] }}</td>
                            <td>
                                {{-- Only manual participants can be edited/deleted --}}
                                @if($participant['role'] === 'Participant')
                                    <a href="{{ route('manager.participants.edit', $participant['id'] ?? '') }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('manager.participants.destroy', $participant['id'] ?? '') }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this participant?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-muted">Auto-joined</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">No participants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $paginated->links() }}
        </div>
    </div>
</div>
@endsection


