@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Edit Event</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <!-- ✅ Added enctype for file upload -->
            <form action="{{ route('manager.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ $event->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ $event->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ $event->location }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="datetime-local" name="start_time" value="{{ $event->start_time }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Time</label>
                    <input type="datetime-local" name="end_time" value="{{ $event->end_time }}" class="form-control" required>
                </div>

                <!-- ✅ Multiple image upload field -->
                <div class="mb-3">
                    <label class="form-label">Upload New Event Images</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="text-muted">You can select multiple images to add.</small>
                </div>

                <!-- ✅ Show all current images with delete + replace modals -->
                @if($event->galleries->count())
                    <div class="mt-3">
                        <p>Current Images:</p>
                        <div class="row">
                            @foreach($event->galleries as $gallery)
                                <div class="col-md-3 mb-3 text-center">
                                    <img src="{{ Storage::url($gallery->image_path) }}" 
                                         alt="{{ $event->title }}" 
                                         class="img-fluid rounded mb-2" style="max-height: 150px;">

                                    <!-- Delete button -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $gallery->id }}">
                                        Delete
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content bg-dark text-light">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                          </div>
                                          <div class="modal-body">
                                            Are you sure you want to delete this image?
                                          </div>
                                          <div class="modal-footer">
                                            <form action="{{ route('manager.gallery.destroy', $gallery->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- Replace button -->
                                    <button type="button" class="btn btn-sm btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#replaceModal{{ $gallery->id }}">
                                        Replace
                                    </button>

                                    <!-- Replace Modal -->
                                    <div class="modal fade" id="replaceModal{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content bg-dark text-light">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Replace Image</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                          </div>
                                          <div class="modal-body">
                                            <form action="{{ route('manager.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Upload New Image</label>
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-warning">Confirm Replace</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-success mt-3">Update Event</button>
            </form>
        </div>
    </div>
</div>
@endsection


