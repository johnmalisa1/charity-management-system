@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Profile Settings</h1>
@endsection

@section('content')
<div class="container py-8">
    <!-- Profile Update Form -->
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Profile Photo -->
        <div class="mb-4">
            <label class="form-label text-light">Profile Photo</label>
            <input type="file" class="form-control bg-dark text-light" name="photo">
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label class="form-label text-light">Name</label>
            <input type="text" class="form-control bg-dark text-light" name="name" 
                   value="{{ old('name', Auth::user()->name) }}">
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="form-label text-light">Email</label>
            <input type="email" class="form-control bg-dark text-light" name="email" 
                   value="{{ old('email', Auth::user()->email) }}">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="form-label text-light">Change Password</label>
            <input type="password" class="form-control bg-dark text-light" name="password">
        </div>

        <button type="submit" class="btn btn-outline-light">Update Profile</button>
    </form>
</div>
@endsection


