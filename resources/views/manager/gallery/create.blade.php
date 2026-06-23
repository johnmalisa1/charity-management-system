@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Upload Image</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <!-- Event Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="event_id" class="form-control" required>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-success">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection

