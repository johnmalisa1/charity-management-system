@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Feedback</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Charity</th>
                        <th>Message</th>
                        <th>Rating</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbackItems as $feedback)
                        <tr>
                            <td>{{ $feedback->user->name ?? 'Anonymous' }}</td>
                            <td>{{ $feedback->charity->name ?? 'N/A' }}</td>
                            <td>{{ $feedback->message }}</td>
                            <td>
                                @if($feedback->rating)
                                    {{ $feedback->rating }}/5
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $feedback->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No feedback available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $feedbackItems->links() }}
        </div>
    </div>
</div>
@endsection

