@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Volunteer Dashboard</h1>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark text-light card-events">
                <div class="card-body">
                    <h6>Events Joined</h6>
                    <h3>{{ $eventsJoined ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-upcoming">
                <div class="card-body">
                    <h6>Upcoming Events</h6>
                    <h3>{{ $upcomingEvents ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-hours">
                <div class="card-body">
                    <h6>Volunteer Hours</h6>
                    <h3>{{ $volunteerHours ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-completed">
                <div class="card-body">
                    <h6>Completed Activities</h6>
                    <h3>{{ $completedActivities ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Events Preview -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Available Events</div>
        <div class="card-body">
            <div class="row">
                @foreach($availableEvents as $event)
                    <div class="col-md-4 mb-3">
                        <div class="card bg-secondary text-light">
                            @if($event->galleries->count())
                                <img src="{{ Storage::url($event->galleries->first()->image_path) }}" 
                                     class="card-img-top" 
                                     alt="{{ $event->title }}">
                            @else
                                <img src="/images/placeholder.png" class="card-img-top" alt="No image available">
                            @endif

                            <div class="card-body">
                                <h5>{{ $event->title }}</h5>
                                <!-- ✅ use start_time -->
                                <p>{{ $event->start_time ? $event->start_time->format('M d, Y') : 'N/A' }} | {{ $event->location }}</p>
                                <form action="{{ route('volunteer.events.join', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Join Event</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('volunteer.events.index') }}" class="btn btn-outline-light">View All Events</a>
        </div>
    </div>

    <!-- Upcoming Joined Events -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Upcoming Joined Events</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($joinedEvents as $event)
                    <li class="list-group-item bg-dark text-light">
                        <strong>{{ $event->title }}</strong> — 
                        <!-- ✅ use start_time -->
                        {{ $event->start_time ? $event->start_time->format('M d, Y') : 'N/A' }} at {{ $event->location }}
                        <span class="badge bg-info ms-2">{{ $event->pivot->status ?? 'Pending' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Assigned Activities -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Assigned Activities</div>
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedActivities as $activity)
                        <tr>
                            <td>{{ $activity->task_name }}</td>
                            <td>{{ $activity->event->title ?? 'N/A' }}</td>
                            <td>{{ $activity->status }}</td>
                            <td>{{ $activity->deadline ? $activity->deadline->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Participation History -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Participation History</div>
        <div class="card-body">
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
                            <td>{{ $record->event->title ?? 'N/A' }}</td>
                            <!-- ✅ safe because Participation model now casts date -->
                            <td>{{ $record->date ? $record->date->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $record->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('volunteer.history') }}" class="btn btn-outline-light">View Full History</a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Notifications</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($notifications as $note)
                    <li class="list-group-item bg-dark text-light">{{ $note->message }}</li>
                @endforeach
            </ul>
            <a href="{{ route('volunteer.notifications') }}" class="btn btn-outline-light mt-3">See All Notifications</a>
        </div>
    </div>

    <!-- Participation Analytics Chart -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Participation Analytics</div>
        <div class="card-body">
            <canvas id="participationChart"></canvas>
        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('participationChart').getContext('2d');
    const participationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Events Joined',
                data: @json($eventsData),
                borderColor: 'rgba(79, 70, 229, 1)',
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });
</script>
@endpush
@endsection




