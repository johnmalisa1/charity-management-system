@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">➕ Create New User</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    {{-- Create User Form --}}
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control bg-dark text-light border-secondary"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control bg-dark text-light border-secondary"
                   required>
        </div>

        <div class="mb-3">
            <label for="roles" class="form-label">Assign Roles</label>
            <select name="roles[]" id="roles" class="form-select bg-dark text-light border-secondary" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple roles.</small>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>
</div>
@endsection

