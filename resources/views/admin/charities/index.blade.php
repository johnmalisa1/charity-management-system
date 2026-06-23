@extends('layouts.app')

@section('title', 'Charities')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">🏥 Charities</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.charities.create') }}" class="btn btn-success">➕ Add Charity</a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Registration #</th>
                    <th>Manager</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($charities as $charity)
                    <tr>
                        <td>{{ $charity->name }}</td>
                        <td>{{ $charity->registration_number }}</td>
                        <td>{{ $charity->manager_id }}</td>
                        <td>{{ $charity->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.charities.edit', $charity->id) }}" class="btn btn-primary btn-sm">✏️ Edit</a>
                            <form action="{{ route('admin.charities.destroy', $charity->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this charity?')">🗑 Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No charities found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $charities->links() }}
    </div>
</div>
@endsection
