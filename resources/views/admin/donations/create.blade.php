@extends('layouts.app')

@section('title', 'Create Donation')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">💰 Record New Donation</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.donations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="donor_id" class="form-label">Donor</label>
            <select name="donor_id" id="user_id" class="form-select bg-dark text-light border-secondary" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="campaign_id" class="form-label">Campaign</label>
            <select name="campaign_id" id="campaign_id" class="form-select bg-dark text-light border-secondary" required>
                <option value="">-- Select Campaign --</option>
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control bg-dark text-light border-secondary" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-success">Save Donation</button>
        </div>
    </form>
</div>
@endsection
