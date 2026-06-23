@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">All Campaigns</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('manager.campaigns.create') }}" class="btn btn-primary">+ Add Campaign</a>
    </div>

    <!-- ✅ Instagram-style feed with carousel -->
    <div class="row">
        @foreach($campaigns as $campaign)
            @php
                $progress = ($campaign->goal_amount > 0)
                    ? round(($campaign->raised_amount / $campaign->goal_amount) * 100)
                    : 0;
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light">
                    
                    <!-- Carousel for campaign images -->
                    @if($campaign->galleries->count())
                        <div id="carouselCampaign{{ $campaign->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($campaign->galleries as $index => $gallery)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($gallery->image_path) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $campaign->title }}" 
                                             style="max-height: 250px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Carousel controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCampaign{{ $campaign->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselCampaign{{ $campaign->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    @else
                        <img src="/images/placeholder.png" class="card-img-top" alt="No image available">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $campaign->title }}</h5>
                        <p class="card-text">
                            🎯 Goal: {{ number_format($campaign->goal_amount) }} <br>
                            💰 Raised: {{ number_format($campaign->raised_amount) }} <br>
                            📊 Progress: {{ $progress }}% <br>
                            📅 {{ $campaign->start_date }} → {{ $campaign->end_date }}
                        </p>
                        <div class="progress mb-2" style="height: 15px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                 aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}%
                            </div>
                        </div>
                        <a href="{{ route('manager.campaigns.edit', $campaign->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('manager.campaigns.destroy', $campaign->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this campaign?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection



