@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">{{ $campaign->title }}</h1>
@endsection

@section('content')
<div class="container py-8">

    <!-- ✅ Back button -->
    <div class="mb-3">
        <a href="{{ route('donor.campaigns') }}" class="btn btn-secondary">
            ← Back to Campaigns
        </a>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $campaign->title }}</h5>
            <p class="card-text">{{ $campaign->description }}</p>
            
            <!-- ✅ Goal and Raised amounts -->
            <p class="card-text">
                Goal: {{ number_format($campaign->goal_amount) }} <br>
                Raised: {{ number_format($campaign->raised_amount) }}
            </p>

            <!-- ✅ Progress bar -->
            @php
                $progress = $campaign->goal_amount > 0 
                    ? min(100, ($campaign->raised_amount / $campaign->goal_amount) * 100) 
                    : 0;
            @endphp
            <div class="progress mb-3">
                <div class="progress-bar bg-success" role="progressbar"
                     style="width: {{ $progress }}%;" 
                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                    {{ round($progress) }}%
                </div>
            </div>

            <!-- ✅ Raised vs Goal text -->
            <p class="mt-2">
                Raised: {{ number_format($campaign->raised_amount) }} / 
                Goal: {{ number_format($campaign->goal_amount) }}
            </p>

            <!-- ✅ Donate form -->
            <form action="{{ route('donor.campaigns.donate', $campaign->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="number" name="amount" min="1" class="form-control mb-2" placeholder="Enter amount" required>
                <button type="submit" class="btn btn-outline-light">Donate</button>
            </form>
        </div>
    </div>

    <!-- ✅ Campaign Gallery -->
    <div class="row">
        @if($campaign->galleries->count())
            @foreach($campaign->galleries as $gallery)
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-light">
                        <img src="{{ Storage::url($gallery->image_path) }}" 
                             class="card-img-top" alt="{{ $gallery->title }}">
                        <div class="card-body">
                            <p class="card-text">{{ $gallery->title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">No images uploaded for this campaign yet.</p>
        @endif
    </div>
</div>
@endsection



