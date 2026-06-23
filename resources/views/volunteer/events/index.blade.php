@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">All Events</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-3">
                <div class="card bg-dark text-light">
                    
                    <!-- ✅ Link image to event detail -->
                    <a href="{{ route('volunteer.events.show', $event->id) }}">
                        @if($event->galleries->count())
                            <img src="{{ Storage::url($event->galleries->first()->image_path) }}" 
                                 class="card-img-top" alt="{{ $event->title }}">
                        @else
                            <img src="/images/placeholder.png" class="card-img-top" alt="No image available">
                        @endif
                    </a>

                    <div class="card-body">
                        <!-- ✅ Link title to event detail -->
                        <h5>
                            <a href="{{ route('volunteer.events.show', $event->id) }}" class="text-light">
                                {{ $event->title }}
                            </a>
                        </h5>
                        <p>
                            {{ $event->start_time ? $event->start_time->format('M d, Y') : 'N/A' }} 
                            | {{ $event->location ?? 'Unknown location' }}
                        </p>

                        <!-- ✅ Show gallery thumbnails (skip first image) -->
                        @if($event->galleries->count() > 1)
                            <div class="mt-3">
                                <h6>Gallery</h6>
                                <div class="row">
                                    @foreach($event->galleries->skip(1) as $gallery)
                                        <div class="col-6 mb-2">
                                            <img src="{{ Storage::url($gallery->image_path) }}" 
                                                 class="img-fluid rounded" alt="{{ $gallery->title }}">
                                            <small class="d-block text-muted">{{ $gallery->title }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- ✅ Join/Cancel buttons using volunteers pivot -->
                        @if($event->volunteers->contains(Auth::id()))
                            <form action="{{ route('volunteer.events.cancel', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Cancel Event</button>
                            </form>
                        @else
                            <form action="{{ route('volunteer.events.join', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Join Event</button>
                            </form>
                        @endif

                        <!-- ✅ View Details button -->
                        <a href="{{ route('volunteer.events.show', $event->id) }}" class="btn btn-info btn-sm ms-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection





