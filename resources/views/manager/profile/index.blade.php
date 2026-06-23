@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Profile Settings</h1>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Success / Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo -->
                <div class="mb-3">
                    <label for="photo" class="form-label">Profile Photo</label>
                    <input type="file" class="form-control bg-dark text-light border-secondary" id="photo" name="photo">
                    @if($manager->photo_url)
                        <img src="{{ $manager->photo_url }}" alt="Profile Photo" 
                             class="mt-2 rounded-circle border border-light" width="80" height="80">
                    @endif
                </div>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" id="name" name="name"
                           value="{{ old('name', $manager->name) }}">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email"
                           value="{{ old('email', $manager->email) }}">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control bg-dark text-light border-secondary" id="password" name="password">
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control bg-dark text-light border-secondary" id="password_confirmation" name="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection


