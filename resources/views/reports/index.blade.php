@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-pink-600">System Reports</h1>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
            <h2>Total Users</h2>
            <p class="mt-1 text-xl font-bold text-indigo-600">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
            <h2>Total Donations</h2>
            <p class="mt-1 text-xl font-bold text-green-600">{{ number_format($totalDonations, 0) }} TZS</p>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
            <h2>Campaigns</h2>
            <p class="mt-1 text-xl font-bold text-yellow-600">{{ $campaignsCount }}</p>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
            <h2>Charities</h2>
            <p class="mt-1 text-xl font-bold text-pink-600">{{ $charitiesCount }}</p>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.reports') }}" class="mb-4 no-print">
        <label><input type="checkbox" name="donations" value="1" {{ request('donations') ? 'checked' : '' }}> Donations</label>
        <label><input type="checkbox" name="campaigns" value="1" {{ request('campaigns') ? 'checked' : '' }}> Campaigns</label>
        <label><input type="checkbox" name="users" value="1" {{ request('users') ? 'checked' : '' }}> Users</label>
        <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
    </form>

    <!-- Actions -->
    <div class="mb-4 no-print">
        <button onclick="window.print()" class="btn btn-secondary">🖨 Print Report</button>
        <a href="{{ route('admin.reports.pdf', request()->all()) }}" class="btn btn-danger">📄 Export PDF</a>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2>Donations by Month</h2>
            <div class="h-64"><canvas id="donationsByMonthChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2>Campaigns Status</h2>
            <div class="h-64"><canvas id="campaignsStatusChart"></canvas></div>
        </div>
    </div>

    <!-- Sections -->
    @if(!empty($reports['donations']))
        <h3>Recent Donations</h3>
        <table class="table table-dark table-striped">
            <thead><tr><th>User</th><th>Campaign</th><th>Amount</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($reports['donations'] as $donation)
                    <tr>
                        <td>{{ $donation->user->name ?? 'N/A' }}</td>
                        <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
                        <td>{{ number_format($donation->amount,2) }}</td>
                        <td>{{ $donation->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($reports['campaigns']))
        <h3>Recent Campaigns</h3>
        <ul>
            @foreach($reports['campaigns'] as $campaign)
                <li>{{ $campaign->title }} (Goal: {{ $campaign->goal }})</li>
            @endforeach
        </ul>
    @endif

    @if(!empty($reports['users']))
        <h3>Recent Users</h3>
        <ul>
            @foreach($reports['users'] as $user)
                <li>{{ $user->name }} ({{ $user->email }})</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Print-friendly styles */
@media print {
    .no-print, nav, header, footer {
        display: none !important;
    }
    .max-w-6xl {
        max-width: 100% !important;
        box-shadow: none !important;
        border: none !important;
    }
    canvas {
        max-height: 300px !important;
    }
    table {
        width: 100% !important;
        border-collapse: collapse;
    }
    table th, table td {
        border: 1px solid #000;
        padding: 6px;
    }
    body {
        background: #fff !important;
        color: #000 !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Donations by Month Line Chart
    new Chart(document.getElementById('donationsByMonthChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($donationsByMonthNamed)) !!},
            datasets: [{
                label: 'Donations (TZS)',
                data: {!! json_encode(array_values($donationsByMonthNamed)) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Campaigns Status Pie Chart
    new Chart(document.getElementById('campaignsStatusChart'), {
        type: 'pie',
        data: {
            labels: ['Active','Completed','Pending'],
            datasets: [{
                data: [{{ $activeCampaigns }}, {{ $completedCampaigns }}, {{ $pendingCampaigns }}],
                backgroundColor: ['#4f46e5','#10b981','#f59e0b']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush




