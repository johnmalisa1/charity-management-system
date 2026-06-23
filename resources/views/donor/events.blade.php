@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Upcoming Events</h1>
@endsection

@section('content')
<div class="container py-8">
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light">
                    
                    <!-- ✅ Link image to event detail -->
                    <a href="{{ route('donor.events.show', $event->id) }}">
                        @if($event->galleries->count())
                            <img src="{{ Storage::url($event->galleries->first()->image_path) }}" 
                                 class="card-img-top" alt="{{ $event->title }}">
                        @else
                            <img src="/images/placeholder.png" 
                                 class="card-img-top" alt="No image available">
                        @endif
                    </a>

                    <div class="card-body">
                        <!-- ✅ Link title to event detail -->
                        <h5 class="card-title">
                            <a href="{{ route('donor.events.show', $event->id) }}" class="text-light">
                                {{ $event->title }}
                            </a>
                        </h5>
                        <p class="card-text">
                            {{ $event->start_time->format('Y-m-d') }} | {{ $event->location }}
                        </p>

                        <!-- ✅ Join/Cancel button logic -->
                        @if($event->donors->contains(Auth::id()))
                            <form method="POST" action="{{ route('donor.events.cancel', $event->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Cancel
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('donor.events.join', $event->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    Join
                                </button>
                            </form>
                        @endif

                        <!-- ✅ View Details button -->
                        <a href="{{ route('donor.events.show', $event->id) }}" class="btn btn-info btn-sm ms-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>
@endsection





