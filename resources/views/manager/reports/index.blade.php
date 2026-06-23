@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Reports</h1>
@endsection

@section('content')
<div class="container-fluid">

    <div class="mb-3">
        <a href="{{ route('manager.reports.pdf') }}" class="btn btn-danger">Export PDF</a>
        <button onclick="window.print()" class="btn btn-secondary">Print</button>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5>Total Donations</h5>
                    <p>${{ $totalDonations }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5>Campaigns</h5>
                    <p>{{ $campaignsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5>Volunteers</h5>
                    <p>{{ $volunteersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5>Events</h5>
                    <p>{{ $eventsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h4>Recent Donations</h4>
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
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                            <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $donations->links() }}
        </div>
    </div>

    {{-- Chart.js integration --}}
    <canvas id="donationsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donationsChart').getContext('2d');
    const donationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyDonations->toArray())) !!},
            datasets: [{
                label: 'Monthly Donations',
                data: {!! json_encode(array_values($monthlyDonations->toArray())) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
            }]
        }
    });
</script>
@endsection

