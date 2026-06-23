@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Manager Dashboard</h1>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark text-light card-donations">
                <div class="card-body">
                    <h5>Total Donations Received</h5>
                    <h3>{{ $totalDonations ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-campaigns">
                <div class="card-body">
                    <h5>Active Campaigns</h5>
                    <h3>{{ $activeCampaigns ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-charities">
                <div class="card-body">
                    <h5>Upcoming Events</h5>
                    <h3>{{ $upcomingEvents ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light card-users">
                <div class="card-body">
                    <h5>Registered Volunteers</h5>
                    <h3>{{ $registeredVolunteers ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Donations Preview -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Recent Donations</div>
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Campaign</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                        <tr>
                            <td>{{ $donation->donor->name }}</td>
                            <td>{{ $donation->campaign->title }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('manager.donations') }}" class="btn btn-outline-light">View All Donations</a>
        </div>
    </div>

    <!-- ✅ Campaign Progress -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Campaign Progress</div>
        <div class="card-body">
            @foreach($campaigns as $campaign)
                @php
                    $progress = ($campaign->goal_amount > 0)
                        ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100)
                        : 0;

                    if ($progress < 50) {
                        $barClass = 'bg-danger';
                    } elseif ($progress < 80) {
                        $barClass = 'bg-warning';
                    } else {
                        $barClass = 'bg-success';
                    }
                @endphp

                <div class="mb-3">
                    <h5>{{ $campaign->title }}</h5>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar {{ $barClass }}" role="progressbar"
                             style="width: {{ $progress }}%"
                             aria-valuenow="{{ $campaign->raised_amount }}"
                             aria-valuemin="0"
                             aria-valuemax="{{ $campaign->goal_amount ?? 0 }}">
                            {{ number_format($progress, 1) }}%
                        </div>
                    </div>
                    <small>
                        Raised: {{ number_format($campaign->raised_amount) }} /
                        Goal: {{ number_format($campaign->goal_amount ?? 0) }}
                    </small>
                </div>
            @endforeach

            <a href="{{ route('manager.campaigns') }}" class="btn btn-outline-light mt-3">Manage Campaigns</a>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Upcoming Events</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($events as $event)
                    <li class="list-group-item bg-dark text-light">
                        <strong>{{ $event->title }}</strong> — {{ $event->start_time->format('Y-m-d') }}
                        <br>Location: {{ $event->location }} | Participants: {{ $event->participants->count() }}
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('manager.events') }}" class="btn btn-outline-light mt-3">Manage Events</a>
        </div>
    </div>

    <!-- Recent Volunteers -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Recent Volunteers</div>
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Assigned Event</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($volunteers as $volunteer)
                        <tr>
                            <td>{{ $volunteer->user->name }}</td>
                            <td>{{ $volunteer->event->title ?? 'N/A' }}</td>
                            <td>{{ $volunteer->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('manager.volunteers') }}" class="btn btn-outline-light">View All Volunteers</a>
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <canvas id="donationTrendsChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="campaignPerformanceChart"></canvas>
        </div>
        <div class="col-md-6 mt-4">
            <canvas id="volunteerParticipationChart"></canvas>
        </div>
    </div>

    <!-- Latest Notifications -->
    <div class="card bg-dark text-light mb-4">
        <div class="card-header">Latest Notifications</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($latestNotifications as $note)
                    <li class="list-group-item bg-dark text-light">{{ $note->message }}</li>
                @endforeach
            </ul>
            <a href="{{ route('manager.notifications') }}" class="btn btn-outline-light mt-3">View All Notifications</a>
        </div>
    </div>
</div>
@endsection




