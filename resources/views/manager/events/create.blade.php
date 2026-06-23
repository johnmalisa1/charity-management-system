@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Add Event</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <!-- ✅ Add enctype for file uploads -->
            <form action="{{ route('manager.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control" required>
                </div>

                <!-- ✅ Charity Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Charity</label>
                    <select name="charity_id" class="form-control" required>
                        @foreach($charities as $charity)
                            <option value="{{ $charity->id }}">{{ $charity->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- ✅ Multiple Image Upload -->
                <div class="mb-3">
                    <label class="form-label">Upload Event Images</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="text-muted">You can select multiple images at once.</small>
                </div>

                <button type="submit" class="btn btn-success">Save Event</button>
            </form>
        </div>
    </div>
</div>
@endsection


