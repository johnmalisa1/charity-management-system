@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Donor Dashboard</h1>
@endsection

@section('content')
<div class="container-fluid py-8">

    <!-- Statistics Cards -->
    <div class="row mb-6">
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cash-stack me-2"></i> Total Donations</h5>
                    <h2 class="fw-bold">{{ number_format($totalDonations) }} TZS</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-megaphone me-2"></i> Campaigns Supported</h5>
                    <h2 class="fw-bold">{{ $campaignsSupported }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-calendar-event me-2"></i> Events Joined</h5>
                    <h2 class="fw-bold">{{ $eventsJoined }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-handshake me-2"></i> Volunteer Activities</h5>
                    <h2 class="fw-bold">{{ $volunteerActivities }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Donation Trends Chart -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-graph-up-arrow me-2"></i> Donation Trends</h5>
            <div class="h-64">
                <canvas id="donationTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-clock-history me-2"></i> Recent Donations</h5>
            <table class="table table-dark table-striped mb-3">
                <thead>
                    <tr>
                        <th>Campaign</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                        <tr>
                            <td>{{ $donation->campaign->title }}</td>
                            <td>{{ number_format($donation->amount) }} TZS</td>
                            <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('donor.donations') }}" class="btn btn-outline-light">View All Donations</a>
        </div>
    </div>

    <!-- Featured Campaigns -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-star-fill me-2"></i> Featured Campaigns</h5>
            <div class="row">
                @foreach($featuredCampaigns as $campaign)
                    <div class="col-md-6 mb-4">
                        <div class="card bg-secondary text-light">
                            <img src="{{ $campaign->image_url ?? 'https://via.placeholder.com/600x200' }}" 
                                 class="card-img-top" alt="Campaign Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $campaign->title }}</h5>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" style="width: {{ $campaign->progress }}%">
                                        {{ $campaign->progress }}%
                                    </div>
                                </div>
                                <button class="btn btn-outline-light">Donate</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('donor.campaigns') }}" class="btn btn-outline-light">View All Campaigns</a>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-calendar-check me-2"></i> Upcoming Events</h5>
            <table class="table table-dark table-hover mb-3">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upcomingEvents as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d H:i') }}</td>
                            <td>{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('Y-m-d H:i') : '-' }}</td>
                            <td>{{ $event->location }}</td>
                            <td><button class="btn btn-outline-light btn-sm">Join</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('donor.events') }}" class="btn btn-outline-light">View All Events</a>
        </div>
    </div>

    <!-- Volunteer Activities -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-hand-thumbs-up me-2"></i> Recent Volunteer Activities</h5>
            @if($user->volunteerActivities->isEmpty())
                <p>No volunteer activities yet.</p>
            @else
                <table class="table table-dark table-striped mb-3">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->volunteerActivities()->latest()->take(3)->get() as $activity)
                            <tr>
                                <td>{{ $activity->activity_name }}</td>
                                <td>{{ $activity->date?->format('Y-m-d') }}</td>
                                <td>{{ $activity->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <a href="{{ route('donor.volunteer') }}" class="btn btn-outline-light">View All Activities</a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card bg-dark text-light shadow mb-6">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-bell me-2"></i> Latest Notifications</h5>
            @foreach($latestNotifications as $note)
                <div class="alert alert-info">{{ $note->message }}</div>
            @endforeach
            <a href="{{ route('donor.notifications') }}" class="btn btn-outline-light">See All Notifications</a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donationTrendsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Donations (TZS)',
                data: [20000, 15000, 30000, 25000, 40000],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.3)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#e0e0e0' } }
            },
            scales: {
                x: { ticks: { color: '#e0e0e0' } },
                y: { ticks: { color: '#e0e0e0' } }
            }
        }
    });
</script>
@endpush











