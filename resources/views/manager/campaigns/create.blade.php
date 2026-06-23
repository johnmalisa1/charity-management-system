@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Add Campaign</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <!-- ✅ Added enctype for file upload -->
            <form action="{{ route('manager.campaigns.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label class="form-label">Goal Amount</label>
                    <input type="number" name="goal_amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

                <!-- ✅ Multiple image upload field -->
                <div class="mb-3">
                    <label class="form-label">Campaign Images</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    <small class="text-muted">You can select multiple images at once.</small>
                </div>

                <button type="submit" class="btn btn-success">Save Campaign</button>
            </form>
        </div>
    </div>
</div>
@endsection


