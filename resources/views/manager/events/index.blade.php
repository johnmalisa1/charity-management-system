@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">All Events</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('manager.events.create') }}" class="btn btn-primary">+ Add Event</a>
    </div>

    <!-- ✅ Instagram-style feed with carousel -->
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light">
                    
                    <!-- Carousel for event images -->
                    @if($event->galleries->count())
                        <div id="carouselEvent{{ $event->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($event->galleries as $index => $gallery)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($gallery->image_path) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $event->title }}" 
                                             style="max-height: 250px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Carousel controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEvent{{ $event->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselEvent{{ $event->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    @else
                        <img src="/images/placeholder.png" class="card-img-top" alt="No image available">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">
                            📍 {{ $event->location }} <br>
                            🗓 {{ $event->start_time }} – {{ $event->end_time }}
                        </p>
                        <a href="{{ route('manager.events.show', $event->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('manager.events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('manager.events.destroy', $event->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this event?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection


