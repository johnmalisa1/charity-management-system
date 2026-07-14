@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Active Campaigns</h1>
@endsection

@section('content')
<div class="container py-8">
    <div class="row">
        @foreach($campaigns as $campaign)
            <div class="col-md-6 mb-4">
                <div class="card bg-dark text-light">
                    
                    <!-- ✅ Link image to campaign detail -->
                    <a href="{{ route('donor.campaigns.show', $campaign->id) }}">
                        @if($campaign->galleries->count())
                            <img src="{{ Storage::url($campaign->galleries->first()->image_path) }}" 
                                 class="card-img-top" alt="{{ $campaign->title }}">
                        @else
                            <img src="https://via.placeholder.com/600x200" 
                                 class="card-img-top" alt="Campaign Image">
                        @endif
                    </a>

                    <div class="card-body">
                        <!-- ✅ Link title to campaign detail -->
                        <h5 class="card-title">
                            <a href="{{ route('donor.campaigns.show', $campaign->id) }}" class="text-light">
                                {{ $campaign->title }}
                            </a>
                        </h5>
                        <p class="card-text">{{ $campaign->description }}</p>

                        <!-- ✅ Progress bar -->
                        @php
                            $progress = $campaign->goal_amount > 0 
                                ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100) 
                                : 0;
                        @endphp
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%">
                                {{ round($progress) }}%
                            </div>
                        </div>
                        <p>Raised: {{ $campaign->raised_amount }} / Goal: {{ $campaign->goal_amount }}</p>

                        <!-- ✅ Donate form -->
<form action="{{ route('donor.campaigns.donate.confirm', $campaign->id) }}" method="POST" class="d-inline">
    @csrf
    <input type="number" name="amount" min="1" class="form-control mb-2" placeholder="Enter amount" required>
    <button type="submit" class="btn btn-outline-light btn-sm">Donate</button>
</form>



                        <!-- ✅ View Details button -->
                        <a href="{{ route('donor.campaigns.show', $campaign->id) }}" class="btn btn-info btn-sm ms-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection







