@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Volunteers</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('manager.volunteers.create') }}" class="btn btn-primary">+ Add Volunteer</a>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Skills</th>
                        <th>Availability</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($volunteers as $volunteer)
                        <tr>
                            <td>{{ $volunteer->user->name ?? 'N/A' }}</td>
                            <td>{{ $volunteer->user->email ?? 'N/A' }}</td>
                            <td>{{ $volunteer->skills ?? '—' }}</td>
                            <td>{{ $volunteer->availability ?? '—' }}</td>
                            <td>{{ ucfirst($volunteer->status) }}</td>
                            <td>
                                <a href="{{ route('manager.volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('manager.volunteers.destroy', $volunteer->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this volunteer?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">No volunteers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $volunteers->links() }}
        </div>
    </div>
</div>
@endsection

