@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Notifications</h1>
@endsection

@section('content')
<div class="container-fluid">
    <ul class="list-group list-group-flush">
        @foreach($notifications as $note)
            <li class="list-group-item bg-dark text-light">
                {{ $note->message }}
                <span class="text-muted float-end">{{ $note->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
