@extends('layouts.app')

@section('title', 'Volunteers Management')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🙋 Volunteers Management</h2>
        <a href="{{ route('admin.volunteers.create') }}" class="btn btn-success">➕ Add Volunteer</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Skills</th>
                <th>Availability</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->id }}</td>
                    <td>{{ $volunteer->user->name ?? 'N/A' }}</td>
                    <td>{{ $volunteer->user->email ?? 'N/A' }}</td>
                    <td>{{ $volunteer->skills ?? '-' }}</td>
                    <td>{{ $volunteer->availability ?? '-' }}</td>
                    <td>{{ ucfirst($volunteer->status) }}</td>
                    <td>{{ $volunteer->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.volunteers.destroy', $volunteer->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this volunteer?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">No volunteers found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $volunteers->links() }}
</div>
@endsection

