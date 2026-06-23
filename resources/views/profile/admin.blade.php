@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-red-600">Admin Profile</h1>

    <!-- Admin Info -->
    <div class="mb-6">
        <h2 class="text-xl font-bold">{{ $user->name }}</h2>
        <p>{{ $user->email }}</p>
        <span class="text-sm text-red-600">Role: Admin</span>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="p-4 bg-gray-50 rounded-lg shadow">Users: {{ $totalUsers }}</div>
        <div class="p-4 bg-gray-50 rounded-lg shadow">Donations: {{ number_format($totalDonations) }} TZS</div>
        <div class="p-4 bg-gray-50 rounded-lg shadow">Campaigns: {{ $campaignsCount }}</div>
        <div class="p-4 bg-gray-50 rounded-lg shadow">Charities: {{ $charitiesCount }}</div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('campaigns.create') }}" class="p-4 bg-blue-100 rounded-lg shadow text-center">Add Campaign</a>
        <a href="{{ route('charities.create') }}" class="p-4 bg-green-100 rounded-lg shadow text-center">Add Charity</a>
        <a href="{{ route('reports.index') }}" class="p-4 bg-pink-100 rounded-lg shadow text-center">View Reports</a>
    </div>

    <!-- Role Distribution Chart -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Role Distribution</h2>
         <pre>{{ json_encode($userRoles) }}</pre>  
        <div class="h-64">
            <canvas id="rolesChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inject PHP array into JS
    const userRoles = @json($userRoles);

    // Role Distribution Pie Chart
    new Chart(document.getElementById('rolesChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(userRoles), // ["Admins","Managers","Donors","Volunteers"]
            datasets: [{
                data: Object.values(userRoles),
                backgroundColor: ['#6366F1', '#22C55E', '#F59E0B', '#EF4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#374151'
                    }
                }
            }
        }
    });
</script>
@endpush

