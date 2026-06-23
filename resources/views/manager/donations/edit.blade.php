@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Edit Donation</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.donations.update', $donation->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Donor</label>
                    <select name="donor_id" class="form-control" required>
                        <option value="">-- Select Donor --</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}" 
                                {{ $donation->donor_id == $donor->id ? 'selected' : '' }}>
                                {{ $donor->name }} ({{ $donor->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Campaign</label>
                    <select name="campaign_id" class="form-control" required>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" 
                                {{ $donation->campaign_id == $campaign->id ? 'selected' : '' }}>
                                {{ $campaign->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" value="{{ $donation->amount }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Update Donation</button>
            </form>
        </div>
    </div>
</div>
@endsection

