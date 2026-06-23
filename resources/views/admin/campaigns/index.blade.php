@extends('layouts.app')

@section('title', 'Campaigns Management')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📢 Campaigns Management</h2>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-success">➕ Add Campaign</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Goal</th>
                <th>Charity</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->id }}</td>
                    <td>{{ $campaign->title }}</td>
                    <td>{{ Str::limit($campaign->description, 50) }}</td>
                    <td>${{ number_format($campaign->goal, 2) }}</td>
                    <td>{{ optional($campaign->charity)->name }}</td>
                    <td>{{ $campaign->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this campaign?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No campaigns found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $campaigns->links() }}
</div>
@endsection
