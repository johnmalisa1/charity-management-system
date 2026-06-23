@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Notifications</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <form action="{{ route('manager.notifications.markAllRead') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Mark All as Read</button>
        </form>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification->title }}</td>
                            <td>{{ $notification->message }}</td>
                            <td>
                                @if($notification->is_read)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning">Unread</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if(!$notification->is_read)
                                    <form action="{{ route('manager.notifications.markRead', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">Mark Read</button>
                                    </form>
                                @endif
                                <form action="{{ route('manager.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this notification?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection

