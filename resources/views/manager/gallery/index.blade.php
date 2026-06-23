@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Gallery</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('manager.gallery.create') }}" class="btn btn-primary">+ Upload Image</a>
    </div>

    <div class="row">
        @foreach($galleryItems as $item)
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-light">
                    <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <!-- Show event name -->
                        @if($item->event)
                            <p class="text-muted mb-2">Event: {{ $item->event->title }}</p>
                        @endif

                        <form action="{{ route('manager.gallery.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this image?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $galleryItems->links() }}
</div>
@endsection

