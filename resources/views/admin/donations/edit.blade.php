@extends('layouts.app')

@section('title', 'Edit Donation')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <h2 class="mb-4">✏️ Edit Donation</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Donation Form --}}
    <form action="{{ route('admin.donations.update', $donation->id) }}" method="POST">
        @csrf
        @method('PUT')   {{-- ✅ Use PUT to match your route --}}

        <div class="mb-3">
            <label for="donor_id" class="form-label">Donor</label>
            <select name="donor_id" id="donor_id" class="form-select bg-dark text-light border-secondary" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ $donation->donor_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="campaign_id" class="form-label">Campaign</label>
            <select name="campaign_id" id="campaign_id" class="form-select bg-dark text-light border-secondary" required>
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" 
                        {{ $donation->campaign_id == $campaign->id ? 'selected' : '' }}>
                        {{ $campaign->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount"
                   class="form-control bg-dark text-light border-secondary"
                   value="{{ old('amount', $donation->amount) }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Update Donation</button>
        </div>
    </form>
</div>
@endsection

