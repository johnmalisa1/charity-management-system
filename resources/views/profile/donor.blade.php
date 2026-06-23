@extends('layouts.app')

@section('title', 'Donor Profile')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-green-600">Donor Profile</h1>

    <p class="mb-4">Total Donated: {{ number_format($totalDonated) }} TZS</p>

    <h3 class="mt-4 font-semibold">Recent Donations</h3>
    <ul class="list-disc pl-5">
        @forelse($donations as $donation)
            <li>{{ number_format($donation->amount) }} TZS to {{ $donation->campaign->title }} on {{ $donation->created_at->format('M d, Y') }}</li>
        @empty
            <li>No donations yet.</li>
        @endforelse
    </ul>
</div>
@endsection
