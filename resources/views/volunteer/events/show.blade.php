@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">{{ $event->title }}</h1>
@endsection

@section('content')
<div class="container py-8">

    <!-- ✅ Back button -->
    <div class="mb-3">
        <a href="{{ route('volunteer.events.index') }}" class="btn btn-secondary">
            ← Back to Events
        </a>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $event->title }}</h5>
            <p class="card-text">{{ $event->description }}</p>
            <p class="card-text">
                Date: {{ $event->start_time ? $event->start_time->format('M d, Y') : 'N/A' }} <br>
                Location: {{ $event->location ?? 'Unknown location' }}
            </p>

            <!-- ✅ Join/Cancel buttons using volunteers pivot -->
            @if($event->volunteers->contains(Auth::id()))
                <form action="{{ route('volunteer.events.cancel', $event->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel Event</button>
                </form>
            @else
                <form action="{{ route('volunteer.events.join', $event->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Join Event</button>
                </form>
            @endif
        </div>
    </div>

    <!-- ✅ Event Gallery -->
    <div class="row">
        @if($event->galleries->count())
            @foreach($event->galleries as $gallery)
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
            <p class="text-muted">No images uploaded for this event yet.</p>
        @endif
    </div>
</div>
@endsection

