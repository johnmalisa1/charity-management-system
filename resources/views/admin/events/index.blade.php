@extends('layouts.app')

@section('title', 'Events Management')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎉 Events Management</h2>
        <a href="{{ route('admin.events.create') }}" class="btn btn-success">➕ Add Event</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Charity</th>
                <th>Location</th>
                <th>Start</th>
                <th>End</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ optional($event->charity)->name }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->start_time->format('M d, Y H:i') }}</td>
                    <td>{{ $event->end_time->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No events found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $events->links() }}
</div>
@endsection
