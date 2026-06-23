@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Profile Settings</h1>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('volunteer.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-dark p-4 rounded">
        @csrf
        <div class="mb-3">
            <label class="form-label text-light">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control bg-dark text-light">
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control bg-dark text-light">
        </div>
        <div class="mb-3">
            <label class="form-label text-light">Profile Photo</label>
            <input type="file" name="photo" class="form-control bg-dark text-light">
            <img src="{{ $user->photo_url }}" class="rounded mt-2" width="100" alt="Profile Photo">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
