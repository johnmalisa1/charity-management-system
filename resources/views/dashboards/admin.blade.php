@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark text-light shadow rounded-lg p-3 card-donations">
                <h6 class="text-secondary">Total Donations</h6>
                <h3 class="fw-bold">{{ number_format($totalDonations ?? 0) }} TZS</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light shadow rounded-lg p-3 card-users">
                <h6 class="text-secondary">Total Users</h6>
                <h3 class="fw-bold">{{ $totalUsers ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light shadow rounded-lg p-3 card-campaigns">
                <h6 class="text-secondary">Active Campaigns</h6>
                <h3 class="fw-bold">{{ $campaignsCount ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light shadow rounded-lg p-3 card-charities">
                <h6 class="text-secondary">Total Events</h6>
                <h3 class="fw-bold">{{ $charitiesCount ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-dark text-light shadow rounded-lg p-3">
                <h5 class="mb-3">Donation Trends</h5>
                <div style="height:300px;">
                    <canvas id="donationsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-dark text-light shadow rounded-lg p-3">
                <h5 class="mb-3">User Growth</h5>
                <div style="height:300px;">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution Chart -->
    <div class="card bg-dark text-light shadow rounded-lg p-3 mb-4">
        <h5 class="mb-3">Role Distribution</h5>
        <div style="height:300px;">
            <canvas id="rolesChart"></canvas>
        </div>
    </div>

    <!-- Campaign Progress Bars -->
<div class="card bg-dark text-light shadow rounded-lg p-3 mb-4">
    <h5 class="mb-3">Campaign Progress</h5>
    @foreach($campaigns as $campaign)
        @php
            $progress = $campaign->goal_amount > 0
                ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100)
                : 0;
        @endphp

        <p class="mb-1 fw-bold">{{ $campaign->title }}</p>
        <div class="progress mb-2" style="height: 20px;">
            <div class="progress-bar bg-success" role="progressbar"
                 style="width: {{ $progress }}%"
                 aria-valuenow="{{ $progress }}"
                 aria-valuemin="0"
                 aria-valuemax="100">
                {{ round($progress, 1) }}%
            </div>
        </div>
        <small>
            Collected: {{ number_format($campaign->raised_amount) }} TZS /
            Target: {{ number_format($campaign->goal_amount) }} TZS
        </small>
    @endforeach
</div>



   <!-- Recent Activity -->
<div class="card bg-dark text-light shadow rounded-lg p-3">
    <h5 class="mb-3">Recent Activity</h5>
    <div class="row">
        <!-- Donations -->
        <div class="col-md-3">
            <h6 class="text-secondary">Latest Donations</h6>
            <ul class="list-unstyled small">
                @foreach($recentDonations as $donation)
                    <li class="d-flex align-items-center">
                        <i class="bi bi-cash-stack me-2"></i>
                        <span>
                            {{ $donation->user->name ?? 'Anonymous' }} donated 
                            {{ number_format($donation->amount) }} TZS 
                            <span class="text-muted">({{ $donation->created_at->diffForHumans() }})</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Campaigns -->
        <div class="col-md-3">
            <h6 class="text-secondary">New Campaigns</h6>
            <ul class="list-unstyled small">
                @foreach($recentCampaigns as $campaign)
                    <li class="d-flex align-items-center">
                        <i class="bi bi-megaphone me-2"></i>
                        <span>
                            {{ $campaign->title }} 
                            <span class="text-muted">({{ $campaign->created_at->diffForHumans() }})</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Users -->
        <div class="col-md-3">
            <h6 class="text-secondary">New Users</h6>
            <ul class="list-unstyled small">
                @foreach($recentUsers as $user)
                    <li class="d-flex align-items-center">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>
                            {{ $user->name }} 
                            <span class="text-muted">({{ $user->created_at->diffForHumans() }})</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Events -->
        <div class="col-md-3">
            <h6 class="text-secondary">Latest Events</h6>
            <ul class="list-unstyled small">
                @foreach($recentEvents as $event)
                    <li class="d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span>
                            {{ $event->title }} 
                            <span class="text-muted">({{ $event->created_at->diffForHumans() }})</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const donationsByMonth = @json($donationsByMonthNamed);
    const usersByMonth = @json($usersByMonthNamed);
    const userRoles = @json($userRoles);

    // Donation Trends Chart
    new Chart(document.getElementById('donationsChart'), {
        type: 'line',
        data: {
            labels: Object.keys(donationsByMonth),
            datasets: [{
                label: 'Donations (TZS)',
                data: Object.values(donationsByMonth),
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // User Growth Chart
    new Chart(document.getElementById('usersChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(usersByMonth),
            datasets: [{
                label: 'New Users',
                data: Object.values(usersByMonth),
                backgroundColor: '#6366F1'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Role Distribution Chart
    new Chart(document.getElementById('rolesChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(userRoles),
            datasets: [{
                data: Object.values(userRoles),
                backgroundColor: ['#6366F1', '#22C55E', '#F59E0B', '#EF4444']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush



















