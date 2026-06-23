@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Donation Receipts</h1>
@endsection

@section('content')
<div class="container py-8">
    <p class="text-gray-300">Download your official receipts for donations.</p>

    <ul class="list-group">
        @foreach($receipts as $donation)
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                {{ $donation->campaign->title }} - {{ number_format($donation->amount, 0) }} TZS
                <a href="{{ route('donor.receipts.download', $donation->id) }}" 
                   class="btn btn-sm btn-outline-light">
                    Download PDF
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $receipts->links() }}
    </div>
</div>
@endsection

