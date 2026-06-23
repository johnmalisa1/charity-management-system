@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Event Details</h1>
@endsection

@section('content')
<div class="container-fluid">

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h3>{{ $event->title }}</h3>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Start:</strong> {{ $event->start_time ? $event->start_time->format('M d, Y H:i') : 'N/A' }}</p>
            <p><strong>End:</strong> {{ $event->end_time ? $event->end_time->format('M d, Y H:i') : 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
        </div>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h4>Participants</h4>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">No participants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $participants->links() }}
        </div>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h4>Volunteers</h4>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->volunteers as $volunteer)
                        <tr>
                            <td>{{ $volunteer->name }}</td>
                            <td>{{ $volunteer->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">No volunteers have joined this event yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h4>Donations (via Campaign)</h4>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr>
                            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">No donations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $donations->links() }}
        </div>
    </div>

</div>
@endsection

