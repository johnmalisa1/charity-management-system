@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">My Donations</h1>
@endsection

@section('content')
<div class="container py-8">
    <p class="text-gray-300 mb-4">Here you’ll see a list of your past donations with receipts.</p>

    <!-- Download All Donations -->
    <div class="mb-3">
        <a href="{{ route('donor.donations.download') }}" class="btn btn-outline-light">
            Download All Donations
        </a>
    </div>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Campaign</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
                <tr>
                    <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                    <td>{{ $donation->campaign->title }}</td>
                    <td>{{ number_format($donation->amount, 0) }} TZS</td>
                    <td>{{ $donation->status ?? 'Confirmed' }}</td>
                    <td>
                        <a href="{{ route('donor.receipts.download', $donation->id) }}" 
                           class="btn btn-sm btn-outline-light">
                            Download
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $donations->links() }}
    </div>
</div>
@endsection


