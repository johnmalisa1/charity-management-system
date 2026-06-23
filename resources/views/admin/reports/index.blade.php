@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="max-w-6xl mx-auto bg-gray-900 dark:bg-gray-900 shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-pink-400">System Reports</h1>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="p-4 bg-gray-800 rounded-lg shadow">
            <h2 class="text-sm font-semibold text-gray-300">Total Users</h2>
            <p class="mt-1 text-xl font-bold text-indigo-400">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 bg-gray-800 rounded-lg shadow">
            <h2 class="text-sm font-semibold text-gray-300">Total Donations</h2>
            <p class="mt-1 text-xl font-bold text-green-400">
                {{ number_format($totalDonations, 0) }} TZS
            </p>
        </div>
        <div class="p-4 bg-gray-800 rounded-lg shadow">
            <h2 class="text-sm font-semibold text-gray-300">Campaigns</h2>
            <p class="mt-1 text-xl font-bold text-yellow-400">{{ $campaignsCount }}</p>
        </div>
        <div class="p-4 bg-gray-800 rounded-lg shadow">
            <h2 class="text-sm font-semibold text-gray-300">Charities</h2>
            <p class="mt-1 text-xl font-bold text-pink-400">{{ $charitiesCount }}</p>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.reports') }}" class="mb-4 no-print text-gray-300">
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
        <div class="bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-200 mb-4">Donations by Month</h2>
            <div class="h-64"><canvas id="donationsByMonthChart"></canvas></div>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-200 mb-4">Campaigns Status</h2>
            <div class="h-64"><canvas id="campaignsStatusChart"></canvas></div>
        </div>
    </div>

        <!-- Donations Section -->
    @if(!empty($reports['donations']))
        <div class="bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-200 mb-4">Recent Donations</h3>
            <table class="table-auto w-full text-gray-200 border-collapse">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 border">User</th>
                        <th class="px-4 py-2 border">Campaign</th>
                        <th class="px-4 py-2 border">Amount</th>
                        <th class="px-4 py-2 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports['donations'] as $donation)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2 border">{{ $donation->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $donation->campaign->title ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ number_format($donation->amount,2) }}</td>
                            <td class="px-4 py-2 border">{{ $donation->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Campaigns Section -->
    @if(!empty($reports['campaigns']))
        <div class="bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-200 mb-4">Recent Campaigns</h3>
            <table class="table-auto w-full text-gray-200 border-collapse">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Goal</th>
                        <th class="px-4 py-2 border">Charity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports['campaigns'] as $campaign)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2 border">{{ $campaign->title }}</td>
                            <td class="px-4 py-2 border">{{ $campaign->goal }}</td>
                            <td class="px-4 py-2 border">{{ $campaign->charity->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Users Section -->
    @if(!empty($reports['users']))
        <div class="bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-200 mb-4">Recent Users</h3>
            <table class="table-auto w-full text-gray-200 border-collapse">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports['users'] as $user)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2 border">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">{{ $user->email }}</td>
                            <td class="px-4 py-2 border">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    </div>
    @endsection 


@push('styles')
<style>
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
        options: { responsive: true, maintainAspectRatio: false }
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
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush
