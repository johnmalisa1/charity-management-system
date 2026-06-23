@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Participation History</h1>
@endsection

@section('content')
<div class="container-fluid">
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $record)
                <tr>
                    <td>{{ $record->event->title }}</td>
                    <td>{{ $record->date->format('M d, Y') }}</td>
                    <td>{{ ucfirst($record->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $history->links() }}
    </div>
</div>
@endsection
